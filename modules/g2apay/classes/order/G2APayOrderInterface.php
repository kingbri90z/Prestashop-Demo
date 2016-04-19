<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

interface G2APayOrderInterface
{
    /**
     * Get order id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get total order amount.
     *
     * @return float
     */
    public function getAmount();

    /**
     * Get currency symbol.
     *
     * @return string
     */
    public function getCurrency();

    /**
     * Get customer id.
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Get customer email.
     *
     * @return string
     */
    public function getCustomerEmail();

    /**
     * Get order description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get order items array.
     *
     * @return array
     */
    public function getItems();

    /**
     * Mark order as complete.
     *
     * @return bool
     */
    public function complete();

    /**
     * Mark order as  canceled.
     *
     * @return bool
     */
    public function cancel();

    /**
     * Mark order as refund.
     *
     * @return bool
     */
    public function refund();

    /**
     * @return G2APayTransactionInterface
     */
    public function getTransaction();

    /**
     * Add order private message.
     *
     * @param $message
     * @return bool
     */
    public function addMessage($message);

    public function canRefundAmount($amount = 0);

    public function getMaxRefundAmount();
}
