<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once dirname(__FILE__) . '/../../classes/G2APayGateway.php';

/**
 * @property G2APay $module
 */
class G2APaySubmitModuleFrontController extends ModuleFrontController
{
    /**
     * @var G2APayGateway
     */
    protected $gateway;

    public function __construct()
    {
        parent::__construct();

        $this->gateway = new G2APayGateway($this->module->getConfig(), $this->module->getSession());
    }

    public function postProcess()
    {
        $cart = $this->context->cart;

        $submit_token       = Tools::getValue('submitToken');
        $submit_token_match = $this->module->getSession()->matchSubmitToken($submit_token);

        if ($cart->id_customer == 0
            || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0
            || !$this->module->active
            || !$submit_token_match
        ) {
            G2APayHelper::redirectBackToCart();
        }

        $customer = new Customer($cart->id_customer);

        if (!Validate::isLoadedObject($customer)) {
            G2APayHelper::redirectBackToCart();
        }

        $currency = $this->context->currency;
        $total    = (float) $cart->getOrderTotal(true, Cart::BOTH);

        $mailVars = [];

        $this->module->validateOrder(
            (int) $cart->id,
            Configuration::get('G2APAY_OS_NEW'),
            $total,
            $this->module->displayName,
            null,
            $mailVars,
            (int) $currency->id,
            false,
            $customer->secure_key
        );

        $redirect = null;
        try {
            $redirect = $this->getCreateQuoteRedirectForCurrentOrder();
        } catch (G2APayException $e) {
            G2APayHelper::redirectBackToCart();
        }

        if (is_null($redirect)) {
            die($this->module->l('Payment processing failed.'));
        }

        G2APayHelper::redirect($redirect);
    }

    protected function getCreateQuoteRedirectForCurrentOrder()
    {
        $order = $this->module->getCurrentOrder();

        return $this->gateway->getGatewayRedirectUrlForOrder($order);
    }
}
