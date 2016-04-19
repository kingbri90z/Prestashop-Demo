<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayOrderItemDiscount implements G2APayOrderItemInterface
{
    protected $discount;

    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    public function getSku()
    {
        return $this->discount['id_cart_rule'];
    }

    public function getName()
    {
        return $this->discount['name'];
    }

    public function getAmount()
    {
        $discount = G2APayHelper::round($this->discount['value']);

        return -$discount;
    }

    public function getQty()
    {
        return 1;
    }

    public function getType()
    {
        return 'discount';
    }

    public function getExtra()
    {
        return '';
    }
}
