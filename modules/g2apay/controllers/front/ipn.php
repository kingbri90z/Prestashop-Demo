<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once dirname(__FILE__) . '/../../classes/G2APayIpn.php';

/**
 * @property G2APay $module
 */
class G2APayIpnModuleFrontController extends ModuleFrontController
{
    /**
     * @var G2APayIpn
     */
    protected $ipn;

    public function __construct()
    {
        parent::__construct();

        $this->ipn = new G2APayIpn($this->module->getConfig(), $this->module);
    }

    public function postProcess()
    {
        $data = [
            'transactionId'   => Tools::getValue('transactionId'),
            'userOrderId'     => Tools::getValue('userOrderId'),
            'amount'          => Tools::getValue('amount'),
            'status'          => Tools::getValue('status'),
            'currency'        => Tools::getValue('currency'),
            'orderCreatedAt'  => Tools::getValue('orderCreatedAt'),
            'orderCompleteAt' => Tools::getValue('orderCompleteAt'),
            'refundedAmount'  => Tools::getValue('refundedAmount'),
            'hash'            => Tools::getValue('hash'),
        ];

        try {
            $this->ipn->validateIpnSecret(Tools::getValue('secret'));
            $order = $this->module->getOrderById($data['userOrderId']);
            $this->ipn->processData($order, $data);
            die('ok');
        } catch (G2APayException $e) {
            $this->logError($e->getMessage(), $data);
            die($this->module->l('Something went wrong'));
        }
    }

    /**
     * @param $message
     * @param $data
     */
    protected function logError($message, $data)
    {
        $info = [
            'Exception' => $this->module->l($message),
            'Time'      => date('Y-m-d H:i:s'),
            'Data'      => $data,
        ];
        $log_dir = _PS_MODULE_DIR_ . 'g2apay/log/';

        $logger = new FileLogger();
        $logger->setFilename($log_dir . date('Ymd') . '_g2apay.log');
        $logger->logError(Tools::jsonEncode($info));
    }
}
