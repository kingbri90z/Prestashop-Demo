<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayPaymentModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->display_column_left  = false;
        $this->display_column_right = false;

        parent::initContent();

        $control = (int) Tools::getValue('control');
        $cart    = $this->context->cart;

        if (!empty($control)) {
            $cart = new Cart($control);
        }

        if ($cart->id_customer == 0
            || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0
            || !$this->module->active
        ) {
            G2APayHelper::redirectBackToCart();
        }

        $token = $this->module->getSession()->generateSubmitToken();

        $this->context->smarty->assign(array(
            'g2apay_path'     => $this->module->getPathUri(),
            'nbProducts'      => $cart->nbProducts(),
            'total'           => $cart->getOrderTotal(true, Cart::BOTH),
            'controller_link' => G2APayHelper::controllerLink('submit'),
            'submit_token'    => $token,
        ));

        $this->setTemplate('payment.tpl');
    }
}
