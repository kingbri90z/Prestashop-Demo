<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayRest
{
    /**
     * @var G2APayConfig
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param G2APayOrderInterface $order
     * @param $amount
     * @return bool
     */
    public function refundOrder($order, $amount)
    {
        $transaction = $order->getTransaction();
        if ($transaction->isValid()) {
            $transaction_id = $transaction->getTransactionId();
            $amount         = G2APayHelper::round($amount);

            $data = array(
                'action' => 'refund',
                'amount' => $amount,
                'hash'   => $this->generateRefundHash($order, $amount),
            );

            $path   = sprintf('transactions/%s', $transaction_id);
            $url    = $this->config->getRestUrl($path);
            $client = $this->createRestClient($url, G2APayClient::METHOD_PUT);

            $result = $client->request($data);

            return is_array($result) && isset($result['status']) && strcasecmp($result['status'], 'ok') === 0;
        }

        return false;
    }

    /**
     * @param $url
     * @param $method
     * @return G2APayClient
     */
    protected function createRestClient($url, $method)
    {
        $client = new G2APayClient($url);
        $client->setMethod($method);
        $client->addHeader('Authorization', $this->config->getApiHash() . ';' . $this->config->getAuthorizationHash());

        return $client;
    }

    /**
     * @param G2APayOrderInterface $order
     * @param $amount
     * @return string
     */
    protected function generateRefundHash($order, $amount)
    {
        $transaction = $order->getTransaction();
        $string      = $transaction->getTransactionId()
            . $order->getId()
            . $order->getAmount()
            . $amount
            . $this->config->getApiSecret();

        return G2APayHelper::hash($string);
    }
}
