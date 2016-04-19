<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APaySession
{
    protected $context;

    public function __construct($context = null)
    {
        $this->context = is_null($context) ? Context::getContext() : $context;
    }

    /**
     * @param G2APayOrderInterface $order
     * @param string|null $token
     * @return string
     */
    public function storeOrderSecureData($order, $token = null)
    {
        if (is_null($token)) {
            $token = G2APayHelper::hash(Tools::passwdGen(32) . time());
        }

        $this->context->cookie->g2apay_order_id    = $order->getId();
        $this->context->cookie->g2apay_order_token = $token;

        return $token;
    }

    public function validateOrderSecureData($data)
    {
        if (!isset($data['order_id'])
            || empty($data['order_id'])
            || $this->context->cookie->g2apay_order_id != $data['order_id']
        ) {
            throw new G2APayException('Invalid order');
        }

        if (!isset($data['token'])
            || empty($data['token'])
            || $this->context->cookie->g2apay_order_token != $data['token']
        ) {
            throw new G2APayException('Invalid token');
        }
    }

    public function clearOrderSecureData()
    {
        unset($this->context->cookie->g2apay_order_id);
        unset($this->context->cookie->g2apay_order_token);
    }

    public function generateSubmitToken()
    {
        $token                                      = Tools::passwdGen(32);
        $this->context->cookie->g2apay_submit_token = $token;

        return $token;
    }

    public function matchSubmitToken($match)
    {
        $result = isset($this->context->cookie->g2apay_submit_token) && $this->context->cookie->g2apay_submit_token === $match;
        unset($this->context->cookie->g2apay_submit_token);

        return $result;
    }

    public function setValue($name, $value)
    {
        $this->context->cookie->__set($name, $value);
    }

    public function getValue($name, $default = null)
    {
        return $this->context->cookie->__isset($name) ? $this->context->cookie->__get($name) : $default;
    }
}
