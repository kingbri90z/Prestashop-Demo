<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayOrderItemOther implements G2APayOrderItemInterface
{
    protected $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getSku()
    {
        return 'other';
    }

    public function getName()
    {
        return 'Other';
    }

    public function getAmount()
    {
        return G2APayHelper::round($this->amount);
    }

    public function getQty()
    {
        return 1;
    }

    public function getType()
    {
        return 'other';
    }

    public function getExtra()
    {
        return '';
    }
}
