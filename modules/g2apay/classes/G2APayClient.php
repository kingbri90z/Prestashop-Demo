<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayClient
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';
    const METHOD_PATCH  = 'PATCH';
    const METHOD_DELETE = 'DELETE';

    protected $url;
    protected $method;
    protected $headers;

    public function __construct($url)
    {
        $this->url     = $url;
        $this->method  = self::METHOD_GET;
        $this->headers = array();
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function addHeader($name, $value)
    {
        $this->headers[] = $name . ': ' . $value;
    }

    public function request($data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

        if (strcasecmp($this->method, self::METHOD_GET) !== 0) {
            if (strcasecmp($this->method, self::METHOD_POST) === 0) {
                curl_setopt($curl, CURLOPT_POST, true);
            } else {
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
            }
        }

        if (!empty($data)) {
            $fields = is_array($data) ? http_build_query($data) : (string) $data;
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        }
        if (!empty($this->headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        }

        $response = curl_exec($curl);

        if (function_exists('json_decode')) {
            $result =  Tools::jsonDecode($response, true);
        } else {
            $result = Tools::jsonDecode($response, true);
        }

        return $result;
    }
}
