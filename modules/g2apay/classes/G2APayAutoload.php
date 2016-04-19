<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayAutoload
{
    protected static $instance;
    protected $paths = [
        '',
        '/order',
        '/transaction',
    ];

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function register()
    {
        spl_autoload_register([G2APayAutoload::instance(), 'load']);
    }

    public function load($name)
    {
        if (strpos($name, 'G2APay') === 0) {
            foreach ($this->paths as $path) {
                $full_path = $this->getFullPath($path, $name);
                if (file_exists($full_path)) {
                    require_once $full_path;
                }
            }
        }
    }

    protected function getFullPath($path, $name)
    {
        return $this->getBasePath() . $path . '/' . $name . '.php';
    }

    protected function getBasePath()
    {
        return _PS_MODULE_DIR_ . 'g2apay/classes';
    }

    protected function loadAllClasses()
    {
        $classes = [
            'Client',
            'Config',
            'Confirmation',
            'Exception',
            'Gateway',
            'Helper',
            'Ipn',
            'Rest',
            'Session',
            'OrderInterface',
            'Order',
            'OrderItemInterface',
            'OrderItemProduct',
            'OrderItemShipping',
            'OrderItemDiscount',
            'OrderItemOther',
            'TransactionInterface',
            'Transaction',
        ];

        foreach ($classes as $class) {
            $this->load('G2APay' . $class);
        }
    }
}
