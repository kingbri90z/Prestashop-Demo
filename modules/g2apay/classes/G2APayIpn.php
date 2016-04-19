<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayIpn
{
    protected static $VALID_STATUSES = array(
        'complete',
        'rejected',
        'canceled',
        'partial_refunded',
        'refunded',
        'pending',
    );

    /**
     * @var G2APayConfig
     */
    protected $config;

    /**
     * @var G2APay
     */
    protected $module;

    public function __construct($config, $module)
    {
        $this->config = $config;
        $this->module = $module;
    }

    public function validateIpnSecret($secret)
    {
        if ($this->config->hasIpnSecret() && $secret !== $this->config->getIpnSecret()) {
            throw new G2APayException('Invalid IPN secret');
        }
    }

    public function processData($order, $data)
    {
        $this->validateOrder($order);
        $this->validateHash($order, $data);
        $this->validateData($order, $data);

        $this->updateOrderState($order, $data);
    }

    protected function validateOrder($order)
    {
        if (is_null($order)) {
            throw new G2APayException('Order not found');
        }
    }

    protected function validateHash($order, $data)
    {
        $validHash = $this->generateIpnHash($order, $data['transactionId']);
        if (empty($data['hash']) || $validHash !== $data['hash']) {
            throw new G2APayException('Invalid IPN hash');
        }
    }

    /**
     * @param G2APayOrder $order
     * @param $data
     * @throws Exception
     */
    protected function validateData($order, $data)
    {
        if ($order->getId() != $data['userOrderId']) {
            throw new G2APayException('Order id does not match');
        }

        if (empty($data['transactionId']) || Tools::strlen(trim($data['transactionId'])) == 0) {
            throw new G2APayException('Invalid transaction id');
        }

        if ($order->getAmount() != $data['amount']) {
            throw new G2APayException('Invalid amount');
        }

        if ($order->getCurrency() !== $data['currency']) {
            throw new G2APayException('Invalid currency');
        }

        if (!in_array(Tools::strtolower((string) $data['status']), self::$VALID_STATUSES)) {
            throw new G2APayException('Unknown status');
        }
    }

    /**
     * @param G2APayOrder $order
     * @param $data
     */
    protected function updateOrderState($order, $data)
    {
        $transaction_id = $data['transactionId'];
        $state          = Tools::strtolower($data['status']);
        $transaction    = $order->getTransaction();
        $transaction->setTransactionId($transaction_id);
        $transaction->setStatus($state);
        if ('complete' === $state) {
            $order->complete();
            $message = $this->module->l('G2A Pay IPN update: payment complete. Transaction id: ') . $transaction_id;
            $order->addMessage($message);
        } elseif ('rejected' === $state) {
            // Reject cancels order
            $order->cancel();
            $message = $this->module->l('G2A Pay IPN update: payment rejected. Transaction id: ') . $transaction_id;
            $order->addMessage($message);
        } elseif ('canceled' === $state) {
            $order->cancel();
            $message = $this->module->l('G2A Pay IPN update: payment cancelled. Transaction id: ') . $transaction_id;
            $order->addMessage($message);
        } elseif ('refunded' === $state || 'partial_refunded' === $state) {
            $refund = $data['refundedAmount'];
            $transaction->addRefundedAmount($refund);
            $order->refund();
            $message = $this->module->l('G2A Pay IPN update: payment refunded. Transaction id: ') . $transaction_id;
            $message .=  ' ' . $this->module->l('Refunded amount: ') . $refund;
            $order->addMessage($message);
        }
        $transaction->save();
    }

    /**
     * @param G2APayOrder $order
     * @param $transaction_id
     * @return string
     */
    protected function generateIpnHash($order, $transaction_id)
    {
        $string = $transaction_id . $order->getId() . $order->getAmount() . $this->config->getApiSecret();

        return G2APayHelper::hash($string);
    }
}
