<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

interface G2APayOrderItemInterface
{
    public function getSku();

    public function getName();

    public function getAmount();

    public function getQty();

    public function getType();

    public function getExtra();
}
