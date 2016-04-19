<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

interface G2APayTransactionInterface
{
    public static function getByOrderId($orderId);

    public function isValid();

    public function getTransactionId();

    public function canBeRefunded();

    public function getRefundedAmount();

    public function isSuccess();

    public function isRefunded();

    public function setTransactionId($transaction_id);

    public function setStatus($status);

    public function addRefundedAmount($refunded_amount);

    public function save();
}
