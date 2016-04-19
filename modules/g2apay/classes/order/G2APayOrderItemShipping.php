<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayOrderItemShipping implements G2APayOrderItemInterface
{
    protected $shipping;

    public function __construct($shipping)
    {
        $this->shipping = $shipping;
    }

    public function getSku()
    {
        return $this->shipping['id_carrier'];
    }

    public function getName()
    {
        return $this->shipping['carrier_name'];
    }

    public function getAmount()
    {
        return G2APayHelper::round($this->shipping['shipping_cost_tax_incl']);
    }

    public function getQty()
    {
        return 1;
    }

    public function getType()
    {
        return 'shipping';
    }

    public function getExtra()
    {
        return $this->shipping['type'];
    }
}
