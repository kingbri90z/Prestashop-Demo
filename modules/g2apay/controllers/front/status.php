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
class G2APayStatusModuleFrontController extends ModuleFrontController
{
    /**
     * @var G2APayConfirmation
     */
    protected $confirmation;

    public function __construct()
    {
        parent::__construct();

        $this->confirmation = new G2APayConfirmation($this->module->getSession());
    }

    public function postProcess()
    {
        $order = $this->getOrder();

        $success = false;
        $retry   = false;
        $message = '';

        try {
            $this->validateAccess($order);

            if ($this->confirmation->isPaymentComplete($order)) {
                $success = true;
                $message = $this->module->l('Your payment was completed! Please check order history for details.');
            } elseif ($this->confirmation->hasValidTransaction($order)) {
                $message = $this->module->l('Your payment status was updated. Please check order history for details.');
            } else {
                $retry = true;
            }
        } catch (G2APayException $e) {
            $message = $this->module->l($e->getMessage());
        }

        $response = Tools::jsonEncode(array(
            'success' => $success,
            'retry'   => $retry,
            'message' => $message,
        ));

        if (method_exists($this, 'ajaxDie')) {
            $this->ajaxDie($response);
        } else {
            die($response);
        }
    }

    /**
     * @return G2APayOrder|null
     */
    protected function getOrder()
    {
        $order_id = Tools::getValue('order_id');
        $order    = $this->module->getOrderById($order_id);

        return $order;
    }

    /**
     * @param G2APayOrderInterface $order
     * @return bool
     */
    protected function isAccessAllowed($order)
    {
        $customer_id = (int) $this->context->customer->id;

        return !empty($customer_id) && !is_null($order) && $order->getCustomerId() == $customer_id;
    }

    /**
     * @param $order
     * @throws G2APayException
     */
    protected function validateAccess($order)
    {
        if (!$this->isAccessAllowed($order)) {
            throw new G2APayException('Access not allowed');
        }

        if (!$this->confirmation->canCheck()) {
            throw new G2APayException(
                'Your order payment processing is taking longer than usually. Please check later your order history.'
            );
        }
    }
}
