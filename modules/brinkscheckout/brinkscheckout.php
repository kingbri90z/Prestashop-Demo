<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *         DISCLAIMER   *
 * ***************************************
 * Do not edit or add to this file if you wish to upgrade Prestashop to newer
 * versions in the future.
 * ****************************************************
 *
 * @category    Belvg
 * @package    Belvg_Twocheckout
 * @author    Alexander Simonchik <support@belvg.com>
 * @copyright Copyright (c) 2010 - 2014 BelVG LLC. (http://www.belvg.com)
 * @license   http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

if (!defined('_PS_VERSION_'))
	exit;

require_once _PS_MODULE_DIR_.'brinkscheckout/includer.php';

class Brinkscheckout extends PaymentModule
{
	protected $hooks = array(
		'payment',
		'header',
		'orderConfirmation',
		'displayMobileHeader',
		'adminOrder',
		'BackOfficeHeader',
	);
	private $html = '';

	public function __construct()
	{
		$this->name = 'brinkscheckout';
		$this->tab = 'payments_gateways';
		$this->version = '1.6.8';
		$this->author = 'belvg';
		$this->bootstrap = true;
		$this->module_key = '';

		parent::__construct();

		$this->displayName = 'Brink\'s Checkout Payment API';
		$this->description = $this->l('Brink\'s Checkout: accept fast, safe and easy payments. Start selling now!');

		if (!Configuration::get('TWOCHECKOUT_SID') || !isset($this->currencies))
			$this->warning = $this->l('your Brink\'s vendor account number must be configured in order to use this module correctly');
		if (!Configuration::get('TWOCHECKOUT_PUBLIC'))
			$this->warning = $this->l('your Brink\'s publishable key must be configured in order to use this module correctly');
		if (!Configuration::get('TWOCHECKOUT_PRIVATE'))
			$this->warning = $this->l('your Brink\'s private key must be configured in order to use this module correctly');
		if (!Configuration::get('TWOCHECKOUT_ADMINAPI_NAME'))
			$this->warning = $this->l('your Brink\'s admin api name must be configured in order to use this module correctly');
		if (!Configuration::get('TWOCHECKOUT_ADMINAPI_PASS'))
			$this->warning = $this->l('your Brink\'s admin api password must be configured in order to use this module correctly');
	}

	public function install()
	{
		//Call PaymentModule default install function
		$install = parent::install();
		if ($install)
		{
			foreach ($this->hooks as $hook)
			{
				if (!$this->registerHook($hook))
					return false;
			}

			if (!$this->installDb())
				return false;
		}

		return $install;
	}

	protected function installDb()
	{
		return Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'twocheckout_order` (
                `id_twocheckout_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `reference` varchar(9),
                `order_number` BIGINT unsigned NOT NULL,
                `transaction_id` BIGINT unsigned NOT NULL,
                `merchant_order_id` TEXT NOT NULL,
				`date_add` datetime NOT NULL,
				`date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_twocheckout_order`),
				KEY `reference` (`reference`)
            ) ENGINE= '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');
	}

	public function uninstall()
	{
		Configuration::deleteByName('TWOCHECKOUT_SID');
		Configuration::deleteByName('TWOCHECKOUT_PUBLIC');
		Configuration::deleteByName('TWOCHECKOUT_PRIVATE');
		Configuration::deleteByName('TWOCHECKOUT_SANDBOX');
		Configuration::deleteByName('TWOCHECKOUT_ADMINAPI_NAME');
		Configuration::deleteByName('TWOCHECKOUT_ADMINAPI_PASS');
		foreach ($this->hooks as $hook)
		{
			if (!$this->unregisterHook($hook))
				return false;
		}

		return parent::uninstall();
	}

	public function setSessionMessage($key, $value)
	{
		$this->context->cookie->{$key} = $value;
	}

	public function getSessionMessage($key)
	{
		if (isset($this->context->cookie->$key))
			return $this->context->cookie->$key;

		return '';
	}

	public function getAndCleanSessionMessage($key)
	{
		$message = $this->getSessionMessage($key);
		unset($this->context->cookie->$key);
		return $message;
	}

	public function getContent()
	{
		$helper = $this->initForm();
		$this->postProcess();
		foreach ($this->fields_form as $field_form)
		{
			if (isset($field_form['form']['input']))
			{
				foreach ($field_form['form']['input'] as $input)
					$helper->fields_value[$input['name']] = Configuration::get(Tools::strtoupper($input['name']));
			}
		}

		$this->html .= $this->generateBrandbook();
		$this->html .= $helper->generateForm($this->fields_form);
		return $this->html;
	}

	public function generateBrandbook()
	{
		$this->context->controller->addCSS($this->_path.'css/2checkout_style_backend.css', 'all');
		$this->context->controller->addCSS($this->_path.'css/2checkout_responsive_backend.css', 'all');

		$this->smarty->assign(array(
			'twocheckout_img_url' => __PS_BASE_URI__.'modules/brinkscheckout/',
		));

		return $this->display(__FILE__, (Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? '1.6/':'1.5/').'brandbook.tpl');
	}

	/**
	 * helper with configuration
	 *
	 * @return HelperForm
	 */
	private function initForm()
	{
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		$helper->toolbar_scroll = true;
		$helper->toolbar_btn = $this->initToolbar();
		$helper->title = $this->displayName;
		$helper->submit_action = 'submitUpdate';

		$this->fields_form[0]['form'] = array(
			'tinymce' => true,
			'legend' => array('title' => $this->l('BRINK\'S CHECKOUT SETUP'), 'image' => $this->_path.'logo.png'),
			'submit' => array(
				'name' => 'submitUpdate',
				'title' => $this->l('   Save   ')
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Account Number'),
					'name' => 'TWOCHECKOUT_SID',
					'size' => 64,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Publishable Key'),
					'name' => 'TWOCHECKOUT_PUBLIC',
					'size' => 64,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Private Key'),
					'name' => 'TWOCHECKOUT_PRIVATE',
					'size' => 64,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Admin Api Name'),
					'desc' => array(
						$this->l('How to create it:'),
						'http://help.2checkout.com/articles/FAQ/How-to-create-an-API-only-Username/',
					),
					'name' => 'TWOCHECKOUT_ADMINAPI_NAME',
					'size' => 64,
				),
				array(
					'type' => 'password',
					'label' => $this->l('Admin Api Password'),
					'name' => 'TWOCHECKOUT_ADMINAPI_PASS',
					'size' => 64,
					'desc' => $this->l('Leave empty for prevent changes'),
				),
				array(
					'type' => Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? 'switch' : 'radio',
					'values' => array(
						array('label' => $this->l('Yes'), 'value' => 1, 'id' => 'sandbox_on'),
						array('label' => $this->l('No'), 'value' => 0, 'id' => 'sandbox_off'),
					),
					'is_bool' => true,
					'class' => 't',
					'label' => $this->l('Sandbox mode'),
					'name' => 'TWOCHECKOUT_SANDBOX',
				),
			),
		);

		return $helper;
	}

	/**
	 * PrestaShop way save button
	 *
	 * @return mixed
	 */
	private function initToolbar()
	{
		$toolbar_btn = array();
		$toolbar_btn['save'] = array('href' => '#', 'desc' => $this->l('Save'));
		return $toolbar_btn;
	}

	/**
	 * save configuration values
	 */
	protected function postProcess()
	{
		if (Tools::isSubmit('submitUpdate'))
		{
			foreach ($this->fields_form as $field_form)
			{
				foreach ($field_form['form']['input'] as $input)
				{
					$value = Tools::getValue(Tools::strtoupper($input['name']));
					if (in_array($input['name'], array('TWOCHECKOUT_ADMINAPI_PASS')) && empty($value))
						continue;
					Configuration::updateValue(Tools::strtoupper($input['name']), $value);
				}
			}

			Tools::redirectAdmin('index.php?tab=AdminModules&conf=4&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.
				(int)Tab::getIdFromClassName('AdminModules').(int)$this->context->employee->id));
		}
	}

	public function hookDisplayMobileHeader()
	{
		return $this->hookHeader();
	}

	public function hookHeader()
	{
		if (!$this->active)
			return;

		if (!in_array($this->context->controller->php_self, array('order-opc', 'order')))
			return;

		$this->context->controller->addCSS($this->_path.'css/2checkout.css', 'all');

		if (Configuration::get('TWOCHECKOUT_SANDBOX'))
			$this->context->controller->addJS('https://sandbox.2checkout.com/checkout/api/script/publickey/'.Configuration::get('TWOCHECKOUT_SID').'');
		else
			$this->context->controller->addJS('https://www.2checkout.com/checkout/api/script/publickey/'.Configuration::get('TWOCHECKOUT_SID').'');

		return $this->display(__FILE__, (Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? '1.6/':'1.5/').'header.tpl');
	}

	public function hookPayment()
	{
		if (!$this->active)
			return;

		if (!Configuration::get('TWOCHECKOUT_SID') || !Configuration::get('TWOCHECKOUT_PUBLIC') ||
		!Configuration::get('TWOCHECKOUT_PRIVATE') || !Configuration::get('TWOCHECKOUT_ADMINAPI_NAME') ||
		!Configuration::get('TWOCHECKOUT_ADMINAPI_PASS'))
			return false;

		$this->context->smarty->assign(array(
			'this_path' => $this->_path,
			'this_path_ssl' => Configuration::get('PS_FO_PROTOCOL').$_SERVER['HTTP_HOST'].__PS_BASE_URI__."modules/{$this->name}/",
			'twocheckout_sid' => Configuration::get('TWOCHECKOUT_SID'),
			'twocheckout_public_key' => Configuration::get('TWOCHECKOUT_PUBLIC'),
			'err_message' => $this->getAndCleanSessionMessage('2co_message'),
		));

		return $this->display(__FILE__, (Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? '1.6/':'1.5/').'payment_execution.tpl');
	}

	public function prepareCredentials()
	{
		include(dirname(__FILE__).'/lib/Twocheckout.php');
		Twocheckout::privateKey(Configuration::get('TWOCHECKOUT_PRIVATE'));
		Twocheckout::sellerId(Configuration::get('TWOCHECKOUT_SID'));
		// Your username and password are required to make any Admin API call.
		Twocheckout::username(Configuration::get('TWOCHECKOUT_ADMINAPI_NAME'));
		Twocheckout::password(Configuration::get('TWOCHECKOUT_ADMINAPI_PASS'));
		// To use your sandbox account set sandbox to true
		if (Configuration::get('TWOCHECKOUT_SANDBOX'))
			Twocheckout::sandbox(true);
	}

	public function processPayment($token)
	{
		$order_process = Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order';
		$cart = $this->context->cart;
		$user = $this->context->customer;
		if (!Validate::isLoadedObject($cart) || !Validate::isLoadedObject($user))
		{
			$this->setSessionMessage('2co_message', $this->l('Payment Authorization Failed: seems like your shopping cart or user is not valid'));
			Tools::redirect($this->context->link->getPageLink($order_process));
		}
		$delivery = new Address((int)$cart->id_address_delivery);
		$invoice = new Address((int)$cart->id_address_invoice);
		if (!Validate::isLoadedObject($delivery) || !Validate::isLoadedObject($invoice))
		{
			$this->setSessionMessage('2co_message', $this->l('Payment Authorization Failed: seems like your delivery or invoice address is not valid'));
			Tools::redirect($this->context->link->getPageLink($order_process));
		}
		$currencies = Currency::getCurrencies();
		$authorized_currencies = array_flip(explode(',', $this->currencies));
		$currencies_used = array();
		foreach ($currencies as $key => $currency)
		{
			if (isset($authorized_currencies[$currency['id_currency']]))
				$currencies_used[] = $currencies[$key];
		}
		foreach ($currencies_used as $currency)
		{
			if ($currency['id_currency'] == $cart->id_currency)
				$order_currency = $currency['iso_code'];
		}

		try {
			$params = array(
				'sellerId' => Configuration::get('TWOCHECKOUT_SID'),
				'merchantOrderId' => 'brinksprestashop--'.$cart->id,
				'token' => $token,
				'currency' => $order_currency,
				'total' => number_format($cart->getOrderTotal(true, 3), 2, '.', ''),
				'billingAddr' => array(
					'name' => $invoice->firstname.' '.$invoice->lastname,
					'addrLine1' => $invoice->address1,
					'addrLine2' => $invoice->address2,
					'city' => $invoice->city,
					'state' => ($invoice->country == 'United States' || $invoice->country == 'Canada') ? State::getNameById($invoice->id_state) : 'XX',
					'zipCode' => $invoice->postcode,
					'country' => $invoice->country,
					'email' => $user->email,
					'phoneNumber' => $invoice->phone
				)
			);

			if ($delivery)
			{
				$shipping_addr = array(
					'name' => $delivery->firstname.' '.$delivery->lastname,
					'addrLine1' => $delivery->address1,
					'addrLine2' => $delivery->address2,
					'city' => $delivery->city,
					'state' => (Validate::isLoadedObject($delivery) && $delivery->id_state) ? new State((int)$delivery->id_state) : 'XX',
					'zipCode' => $delivery->postcode,
					'country' => $delivery->country
				);
				array_merge($shipping_addr, $params);
			}

			$this->prepareCredentials();
			$charge = Twocheckout_Charge::auth($params);

		} catch (Twocheckout_Error $e) {
			$this->setSessionMessage('2co_message', $this->l('Payment Authorization Failed: Please verify your Credit Card details 
				are entered correctly and try again, or try another payment method. Original error message: ').$e);

			Tools::redirect($this->context->link->getPageLink($order_process));
		}

		if (isset($charge['response']['responseCode']))
		{
			//$order_status = (int)Configuration::get('TWOCHECKOUT_ORDER_STATUS');
			$message = $charge['response']['responseMsg'];
			$this->validateOrder((int)$this->context->cart->id, _PS_OS_PAYMENT_, $charge['response']['total'],
				$this->displayName, $message, array(), null, false, $this->context->customer->secure_key);

			$order_obj = new Order($this->currentOrder);
			TwocheckoutOrder::saveCharge($order_obj->reference, $charge);

			$link_params = array(
				'key' => $user->secure_key,
				'id_cart' => (int)$cart->id,
				'id_module' => (int)$this->id,
				'id_order' => (int)$this->currentOrder,
			);
			Tools::redirect($this->context->link->getPageLink('order-confirmation', null, null, $link_params));
		}
		else
		{
			$this->setSessionMessage('2co_message', $this->l('Payment Authorization Failed: Please verify your Credit Card details 
				are entered correctly and try again, or try another payment method.'));

			Tools::redirect($this->context->link->getPageLink($order_process));
		}
	}

	public function hookOrderConfirmation($params)
	{
		return $this->hookPaymentReturn($params);
	}

	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return;

		if ($params['objOrder']->module != $this->name)
			return;

		$state = $params['objOrder']->getCurrentState();
		if ($state == _PS_OS_OUTOFSTOCK_ || $state == _PS_OS_PAYMENT_)
		{
			$this->context->smarty->assign(array(
				'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj']),
				'status' => 'ok',
				'id_order' => $params['objOrder']->id
			));
			if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
				$this->smarty->assign('reference', $params['objOrder']->reference);
		}
		else
			$this->context->smarty->assign('status', 'failed');

		return $this->display(__FILE__, (Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? '1.6/':'1.5/').'payment_return.tpl');
	}

	public function hookAdminOrder()
	{
		if (!$this->active)
			return;

		$this->prepareCredentials();
		$twocheckout_errors = array();
		$twocheckout_success = array();
		if (Tools::isSubmit('twocheckout_refund_transaction'))
		{
			$twocheckout_sale_id = Tools::getValue('twocheckout_sale_id');
			$comment = Tools::getValue('comment');
			$category = Tools::getValue('category');

			$args = array(
				'sale_id' => $twocheckout_sale_id,
				'category' => $category,
				'comment' => $comment
			);

			try {
				$result = Twocheckout_Sale::refund($args);
				if (isset($result['response_message']) && isset($result['response_code']) && $result['response_code'] == 'OK')
					$twocheckout_success[] = $result['response_message'];
			} catch (Twocheckout_Error $e) {
				$twocheckout_errors[] = $e->getMessage();
			}
		}

		if (Tools::isSubmit('id_order'))
		{
			$order_obj = new Order(Tools::getValue('id_order'));
			$twocheckout_info = TwocheckoutOrder::getByOrderReference($order_obj->reference);
			if (!empty($twocheckout_info['order_number']))
			{
				if (Configuration::get('TWOCHECKOUT_SANDBOX'))
					Twocheckout::sandbox(true);

				$args = array(
					'sale_id' => $twocheckout_info['order_number'],
					'invoice_id' => $twocheckout_info['transaction_id']
				);
				try {
					$result = Twocheckout_Sale::retrieve($args);
					$link_params = array(
						'id_order' => Tools::getValue('id_order'),
						'vieworder' => 1,
						'token' => Tools::getAdminTokenLite('AdminOrders'),
						'twocheckout_refund_transaction' => $result['sale']['sale_id'],
					);

					$this->context->smarty->assign(array(
						'twocheckout_sale_info' => $result,
						'twocheckout_sale_id' => $result['sale']['sale_id'],
						'twocheckout_refund_transaction_link' => Dispatcher::getInstance()->createUrl('AdminOrders', $this->context->language->id, $link_params, false),
					));

				} catch (Twocheckout_Error $e) {
					$twocheckout_errors[] = $e->getMessage();
				}

				$this->context->smarty->assign(array(
					'twocheckout_errors' => $twocheckout_errors,
					'twocheckout_success' => $twocheckout_success,
				));

				return $this->display(__FILE__, (Tools::version_compare(_PS_VERSION_, '1.5.9.9', '>') ? '1.6/':'1.5/').'order.tpl');
			}
		}
	}

}

?>