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
class G2APaySuccessModuleFrontController extends ModuleFrontController
{
    /**
     * @var G2APayGateway
     */
    protected $gateway;

    /**
     * @var G2APayConfirmation
     */
    protected $confirmation;

    public function __construct()
    {
        parent::__construct();

        $this->gateway      = new G2APayGateway($this->module->getConfig(), $this->module->getSession());
        $this->confirmation = new G2APayConfirmation($this->module->getSession());
    }

    public function postProcess()
    {
        $data = array(
            'order_id' => Tools::getValue('order_id'),
            'token'    => Tools::getValue('token'),
        );

        $order = $this->module->getOrderById($data['order_id']);
        try {
            $this->gateway->processSuccessCallback($order, $data);
        } catch (G2APayException $e) {
            G2APayHelper::redirect($this->context->link->getPageLink('history.php', true));
        }

        $this->confirmation->reset();

        $module_dir = $this->module->getPathUri();
        $this->context->smarty->assign(array(
            'g2apay_path' => $module_dir,
            'order_id'    => $order->getId(),
            'status_link' => G2APayHelper::controllerLink('status'),
        ));

        $this->addJquery();
        $this->addJS($module_dir . 'views/js/success.js');
        $this->addCSS($module_dir . 'views/css/success.css');

        $this->setTemplate('success.tpl');
    }
}
