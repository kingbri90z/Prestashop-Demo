<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayConfig
{
    /**
     * Default fallback environment.
     */
    const DEFAULT_ENVIRONMENT = 'production';

    /**
     * @var array allowed environments
     */
    protected static $ENVIRONMENTS = array('production', 'sandbox');

    /**
     * @var array gateway urls grouped by environment
     */
    protected static $GATEWAY_URLS = array(
        'production' => 'https://checkout.pay.g2a.com/index/gateway',
        'sandbox'    => 'https://checkout.test.pay.g2a.com/index/gateway',
    );

    /**
     * @var array create quote urls grouped by environment
     */
    protected static $QUOTE_URLS = array(
        'production' => 'https://checkout.pay.g2a.com/index/createQuote',
        'sandbox'    => 'https://checkout.test.pay.g2a.com/index/createQuote',
    );

    /**
     * @var array REST base urls grouped by environment
     */
    protected static $REST_BASE_URLS = array(
        'production' => 'https://pay.g2a.com/rest',
        'sandbox'    => 'https://www.test.pay.g2a.com/rest',
    );

    protected $api_hash;
    protected $api_secret;
    protected $merchant_email;
    protected $environment;
    protected $ipn_secret;

    public function __construct($params)
    {
        if (array_key_exists('environment', $params) && in_array($params['environment'], self::$ENVIRONMENTS)) {
            $this->environment = $params['environment'];
        } else {
            $this->environment = self::DEFAULT_ENVIRONMENT;
        }

        if (isset($params['ipn_secret'])) {
            $this->ipn_secret = (string) $params['ipn_secret'];
        }

        $this->api_hash       = $params['api_hash'];
        $this->api_secret     = $params['api_secret'];
        $this->merchant_email = $params['merchant_email'];
    }

    public function getApiHash()
    {
        return $this->api_hash;
    }

    public function getApiSecret()
    {
        return $this->api_secret;
    }

    public function getMerchantEmail()
    {
        return $this->merchant_email;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getIpnSecret()
    {
        return $this->ipn_secret;
    }

    public function hasIpnSecret()
    {
        return !empty($this->ipn_secret);
    }

    /**
     * Returns generated authorization hash.
     *
     * @return string
     */
    public function getAuthorizationHash()
    {
        $string = $this->getApiHash() . $this->getMerchantEmail() . $this->getApiSecret();

        return G2APayHelper::hash($string);
    }

    /**
     * Returns Create Quote url dependent on current environment.
     *
     * @return string
     */
    public function getCreateQuoteUrl()
    {
        return self::$QUOTE_URLS[$this->environment];
    }

    /**
     * Returns Gateway url dependent on current environment
     * With additional $token.
     *
     * @param string $token
     * @return string
     */
    public function getGatewayUrl($token)
    {
        $base_url = self::$GATEWAY_URLS[$this->environment];

        return $base_url . '?' . http_build_query(compact('token'));
    }

    public function getRestUrl($path = '')
    {
        $path     = ltrim($path, '/');
        $base_url = self::$REST_BASE_URLS[$this->environment];

        return $base_url . '/' . $path;
    }

    /**
     * Return status of config fields fill status.
     * @return bool
     */
    public function checkConfigIsFilled()
    {
        if (!empty($this->getApiHash()) && !empty($this->getApiSecret()) && !empty($this->getMerchantEmail())) {
            return true;
        }

        return false;
    }
}
