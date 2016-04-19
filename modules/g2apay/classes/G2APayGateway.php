<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayGateway
{
    /**
     * @var G2APayConfig
     */
    protected $config;

    /**
     * @var G2APaySession
     */
    protected $session;

    public function __construct($config, $session)
    {
        $this->config  = $config;
        $this->session = $session;
    }

    /**
     * @param G2APayOrderInterface $order
     * @throws G2APayException
     * @return string
     */
    public function getGatewayRedirectUrlForOrder($order)
    {
        if (is_null($order)) {
            throw new G2APayException('Order not found');
        }

        $token = $this->getCreateQuoteTokenForOrder($order);

        return $token ? $this->config->getGatewayUrl($token) : null;
    }

    /**
     * @param G2APayOrderInterface $order
     * @return mixed
     */
    protected function getCreateQuoteTokenForOrder($order)
    {
        $items   = [];
        $link    = new Link();

        /** @var G2APayOrderItemInterface $item */
        foreach ($order->getItems() as $item) {
            $product = new Product(Tools::getValue($item->getId()));

            $items[] = [
                'sku'    => $item->getSku(),
                'name'   => $item->getName(),
                'amount' => G2APayHelper::round($item->getPrice() * $item->getQty()),
                'qty'    => $item->getQty(),
                'type'   => $item->getType(),
                'extra'  => $item->getExtra(),
                'price'  => G2APayHelper::round($item->getPrice()),
                'url'    => $link->getProductLink($product),
                'id'     => $item->getId(),
            ];
        }

        $order_token = $this->session->storeOrderSecureData($order);
        $url_params  = [
            'order_id' => $order->getId(),
            'token'    => $order_token,
        ];

        $data = [
            'api_hash'    => $this->config->getApiHash(),
            'hash'        => $this->generateCreateQuoteHash($order),
            'order_id'    => $order->getId(),
            'amount'      => G2APayHelper::round($order->getAmount()),
            'currency'    => $order->getCurrency(),
            'description' => $order->getDescription(),
            'email'       => $order->getCustomerEmail(),
            'url_failure' => G2APayHelper::controllerLink('failure', $url_params),
            'url_ok'      => G2APayHelper::controllerLink('success', $url_params),
            'items'       => $items,
        ];

        $client = new G2APayClient($this->config->getCreateQuoteUrl());
        $client->setMethod(G2APayClient::METHOD_POST);
        $response = $client->request($data);

        return isset($response['token']) ? $response['token'] : null;
    }

    /**
     * @param G2APayOrderInterface $order
     * @return string
     */
    protected function generateCreateQuoteHash($order)
    {
        $string = $order->getId() . $order->getAmount() . $order->getCurrency() . $this->config->getApiSecret();

        return G2APayHelper::hash($string);
    }

    /**
     * @param G2APayOrder $order
     * @param $data
     * @throws Exception
     */
    public function processSuccessCallback($order, $data)
    {
        $this->validateCallbackData($order, $data);
        $this->session->clearOrderSecureData();
    }

    /**
     * @param G2APayOrder $order
     * @param $data
     * @throws Exception
     */
    public function processFailureCallback($order, $data)
    {
        $this->validateCallbackData($order, $data);
        $order->cancel();
        $this->session->clearOrderSecureData();
    }

    /**
     * @param G2APayOrder $order
     * @param $data
     * @throws Exception
     */
    protected function validateCallbackData($order, $data)
    {
        if (is_null($order)) {
            throw new G2APayException('Order not found');
        }
        $this->session->validateOrderSecureData($data);
    }
}
