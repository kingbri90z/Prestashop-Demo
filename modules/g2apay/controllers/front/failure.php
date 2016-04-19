<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @property G2APay $module
 */
class G2APayFailureModuleFrontController extends ModuleFrontController
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
        $data = array(
            'order_id' => Tools::getValue('order_id'),
            'token'    => Tools::getValue('token'),
        );

        $order = $this->module->getOrderById($data['order_id']);
        try {
            $this->gateway->processFailureCallback($order, $data);
        } catch (G2APayException $e) {
            G2APayHelper::redirectBackToCart();
        }

        // Reorder cancelled order
        $opc = (bool) Configuration::get('PS_ORDER_PROCESS_TYPE');
        if ($opc) {
            $link = $this->context->link->getPageLink('order-opc.php', true) . '?submitReorder&id_order=' . $order->getId();
        } else {
            $link = $this->context->link->getPageLink('order.php', true) . '?submitReorder&id_order=' . $order->getId();
        }

        G2APayHelper::redirect($link);
    }
}
