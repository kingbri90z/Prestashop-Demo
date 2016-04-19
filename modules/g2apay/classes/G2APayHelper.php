<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayHelper
{
    public static function round($amount)
    {
        return round($amount, 2);
    }

    public static function hash($string)
    {
        return hash('sha256', $string);
    }

    public static function controllerLink($name, array $params = [])
    {
        $context = Context::getContext();
        $link    = $context->link->getModuleLink('g2apay', $name, $params);

        return $link;
    }

    public static function getModuleUri()
    {
        return _MODULE_DIR_ . 'g2apay/';
    }

    public static function getShopDomain()
    {
        if (method_exists('Tools', 'getShopDomainSsl')) {
            return Tools::getShopDomainSsl(true, false);
        } else {
            $domain = Configuration::get('PS_SHOP_DOMAIN_SSL');
            if (!$domain) {
                $domain = Tools::getHttpHost();
            }

            return (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . $domain;
        }
    }

    public static function redirect($redirect)
    {
        Tools::redirect($redirect);
    }

    public static function redirectBackToCart()
    {
        Tools::redirect('index.php?controller=order&step=1');
    }

    public static function hasBackwardCompatibility()
    {
        return version_compare(_PS_VERSION_, '1.5', '<');
    }
}
