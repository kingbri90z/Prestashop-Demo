<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . 'g2apay/classes/G2APayAutoload.php';
G2APayAutoload::register();

class G2APay extends PaymentModule
{
    const MIN_REFUND_AMOUNT = 0.01;

    /**
     * @var G2APayConfig
     */
    protected $config;

    /**
     * @var G2APaySession
     */
    protected $session;

    protected $context;

    public function __construct()
    {
        $this->name             = 'g2apay';
        $this->tab              = 'payments_gateways';
        $this->version          = '2.0.0';
        $this->author           = 'G2A';
        $this->is_eu_compatible = 1;
        $this->module_key = 'ee8b7a144357c1372f64443f00d33991';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('G2A Pay');
        $this->description = $this->l('Easily integrate 100+ global and local payment methods with all-in-one solution.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->loadConfig();
        $this->session = new G2APaySession($this->context);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getContent()
    {
        if (Tools::isSubmit('submit' . $this->name)) {
            $this->updateConfigurationPost();
            $this->loadConfig();
        }

        $ipn_params = $this->config->getIpnSecret() ? ['secret' => $this->config->getIpnSecret()] : [];
        $data       = [
            'base_url'    => _PS_BASE_URL_ . __PS_BASE_URI__,
            'module_name' => $this->name,
            'ipn_url'     => G2APayHelper::controllerLink('ipn', $ipn_params),
            'form'        => $this->displayForm(),
        ];

        $this->context->controller->addCSS($this->_path . 'views/css/configuration.css');
        $this->context->smarty->assign($data);
        $output = $this->display(__FILE__, 'views/templates/admin/configuration.tpl');

        return $output;
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('adminOrder')
            || !$this->createTables() || !$this->createOrderState()
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }

        Configuration::deleteByName('G2APAY_OS_NEW');
        Configuration::deleteByName('G2APAY_API_HASH');
        Configuration::deleteByName('G2APAY_API_SECRET');
        Configuration::deleteByName('G2APAY_MERCHANT_EMAIL');
        Configuration::deleteByName('G2APAY_ENVIRONMENT');
        Configuration::deleteByName('G2APAY_IPN_SECRET');

        return true;
    }

    public function hookPayment()
    {
        if (!$this->active) {
            return;
        }

        if (!$this->config->checkConfigIsFilled()) {
            return;
        }

        $module_dir = $this->getPathUri();
        $this->context->smarty->assign([
            'g2apay_path'     => $module_dir,
            'controller_link' => G2APayHelper::controllerLink('payment'),
        ]);

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    public function hookAdminOrder($params)
    {
        if (!$this->active) {
            return;
        }

        $order  = $this->getOrderById($params['id_order']);
        $errors = [];

        if (Tools::isSubmit('submitG2APayOnlineRefund')) {
            $amount = G2APayHelper::round((float) Tools::getValue('G2APAY_REFUND_AMOUNT', 0));
            if ($order->canRefundAmount($amount)) {
                $this->refund($order, $amount);
            } else {
                $errors[] = $this->l('This amount cannot be refunded');
            }
        }

        if ($order->canRefundAmount(self::MIN_REFUND_AMOUNT)) {
            $this->context->smarty->assign(
                [
                    'base_url'                 => _PS_BASE_URL_ . __PS_BASE_URI__,
                    'params'                   => $params,
                    'errors'                   => $errors,
                    'max_online_refund_amount' => $order->getMaxRefundAmount(),
                    'module_name'              => $this->name,
                ]
            );

            $html = $this->display(__FILE__, 'views/templates/admin/order/refund.tpl');

            return $html;
        }
    }

    public function getPathUri()
    {
        return parent::getPathUri();
    }

    public function getOrderById($id)
    {
        if (empty($id)) {
            return;
        }

        $order = new Order($id);
        if (Validate::isLoadedObject($order)) {
            return new G2APayOrder($order);
        }
    }

    public function getCurrentOrder()
    {
        if (empty($this->currentOrder)) {
            return;
        }

        return $this->getOrderById($this->currentOrder);
    }

    /**
     * @param G2APayOrder $order
     * @param float $amount
     */
    protected function refund($order, $amount)
    {
        $rest    = new G2APayRest($this->config);
        $success = $rest->refundOrder($order, $amount);
        if ($success) {
            $order->addMessage($this->l('Sent online refund request for amount: ') . $amount);
        } else {
            $order->addMessage($this->l('Online refund request failed for amount: ') . $amount);
        }

        Tools::redirect($_SERVER['HTTP_REFERER']);
    }

    protected function createOrderState()
    {
        if (!Configuration::get('G2APAY_OS_NEW')) {
            $state       = new OrderState();
            $state->name = [];

            foreach (Language::getLanguages() as $language) {
                $state->name[$language['id_lang']] = 'Awaiting G2A Pay payment';
            }

            $state->send_email  = false;
            $state->color       = '#017FBA';
            $state->hidden      = false;
            $state->delivery    = false;
            $state->logable     = false;
            $state->invoice     = false;
            $state->module_name = $this->name;

            if ($state->add()) {
                $dir         = dirname(__FILE__);
                $source      = $dir . '/../../img/os.gif';
                $destination = $dir . '/../../img/os/' . (int) $state->id . '.gif';
                copy($source, $destination);

                Configuration::updateValue('G2APAY_OS_NEW', (int) $state->id);

                return true;
            }
        }

        return false;
    }

    protected function loadConfig()
    {
        $params = [
            'api_hash'       => Configuration::get('G2APAY_API_HASH'),
            'api_secret'     => Configuration::get('G2APAY_API_SECRET'),
            'merchant_email' => Configuration::get('G2APAY_MERCHANT_EMAIL'),
            'environment'    => Configuration::get('G2APAY_ENVIRONMENT'),
            'ipn_secret'     => Configuration::get('G2APAY_IPN_SECRET'),
        ];
        $this->config = new G2APayConfig($params);
    }

    protected function updateConfigurationPost()
    {
        Configuration::updateValue('G2APAY_API_HASH', trim(Tools::getValue('G2APAY_API_HASH')));
        Configuration::updateValue('G2APAY_API_SECRET', trim(Tools::getValue('G2APAY_API_SECRET')));
        Configuration::updateValue('G2APAY_MERCHANT_EMAIL', trim(Tools::getValue('G2APAY_MERCHANT_EMAIL')));
        Configuration::updateValue('G2APAY_ENVIRONMENT', trim(Tools::getValue('G2APAY_ENVIRONMENT')));
        Configuration::updateValue('G2APAY_IPN_SECRET', (trim(Tools::getValue('G2APAY_IPN_SECRET'))));
    }

    protected function createTables()
    {
        if (!Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'g2apay_transaction` (
			`id_order` int(10) unsigned NOT NULL,
			`id_transaction` varchar(255) NOT NULL,
			`status` varchar(50) NOT NULL,
			`refunded_amount` decimal(20,6) NOT NULL DEFAULT \'0.000000\',
			`date_add` datetime NOT NULL,
			`date_upd` datetime NOT NULL,
			PRIMARY KEY (`id_order`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8')
        ) {
            return false;
        }

        return true;
    }

    protected function displayForm()
    {
        $fieldsForm = [];

        $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');

        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Configuration'),
                'icon'  => 'icon-cogs',
            ],
            'input' => [
                [
                    'type'     => 'text',
                    'label'    => $this->l('API Hash'),
                    'name'     => 'G2APAY_API_HASH',
                    'size'     => 20,
                    'required' => true,
                ],
                [
                    'type'     => 'text',
                    'label'    => $this->l('API Secret'),
                    'name'     => 'G2APAY_API_SECRET',
                    'size'     => 20,
                    'required' => true,
                ],
                [
                    'type'     => 'text',
                    'label'    => $this->l('Merchant email'),
                    'name'     => 'G2APAY_MERCHANT_EMAIL',
                    'size'     => 20,
                    'required' => true,
                ],
                [
                    'type'   => 'radio',
                    'label'  => $this->l('Environment'),
                    'name'   => 'G2APAY_ENVIRONMENT',
                    'values' => [
                        [
                            'id'    => 'g2apay_environment_sandbox',
                            'value' => 'sandbox',
                            'label' => $this->l('Sandbox'),
                        ],
                        [
                            'id'    => 'g2apay_environment_production',
                            'value' => 'production',
                            'label' => $this->l('Production'),
                        ],
                    ],
                    'required' => true,
                ],
                [
                    'type'  => 'text',
                    'label' => $this->l('IPN Secret'),
                    'name'  => 'G2APAY_IPN_SECRET',
                    'size'  => 20,
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $index = AdminController::$currentIndex;

        $helper = new HelperForm();

        $helper->module          = $this;
        $helper->name_controller = $this->name;
        $helper->token           = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex    = $index . '&configure=' . $this->name;

        $helper->default_form_language    = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        $helper->title          = $this->displayName;
        $helper->show_toolbar   = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action  = 'submit' . $this->name;

        $helper->toolbar_btn = [
            'save' => [
                    'desc' => $this->l('Save'),
                    'href' => $index . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ],
            'back' => [
                'href' => $index . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list'),
            ],
        ];

        $helper->fields_value['G2APAY_API_HASH']       = $this->config->getApiHash();
        $helper->fields_value['G2APAY_API_SECRET']     = $this->config->getApiSecret();
        $helper->fields_value['G2APAY_MERCHANT_EMAIL'] = $this->config->getMerchantEmail();
        $helper->fields_value['G2APAY_ENVIRONMENT']    = $this->config->getEnvironment();
        $helper->fields_value['G2APAY_IPN_SECRET']     = $this->config->getIpnSecret();

        return $helper->generateForm($fieldsForm);
    }
}
