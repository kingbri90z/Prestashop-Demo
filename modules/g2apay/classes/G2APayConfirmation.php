<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayConfirmation
{
    const COUNTER_NAME = 'g2apay_confirmation_counter';
    const MAX_ATTEMPTS = 10;

    /**
     * @var G2APaySession
     */
    protected $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @param G2APayOrderInterface $order
     */
    public function isPaymentComplete($order)
    {
        return $order->getTransaction()->isSuccess();
    }

    /**
     * @param G2APayOrderInterface $order
     */
    public function hasValidTransaction($order)
    {
        return $order->getTransaction()->isValid();
    }

    public function canCheck()
    {
        $can_check = $this->checkCounter();
        $this->increaseCounter();

        return $can_check;
    }

    public function reset()
    {
        $this->session->setValue(self::COUNTER_NAME, 0);
    }

    protected function checkCounter()
    {
        $counter = (int) $this->session->getValue(self::COUNTER_NAME, 0);

        return $counter <= self::MAX_ATTEMPTS;
    }

    protected function increaseCounter()
    {
        $counter = (int) $this->session->getValue(self::COUNTER_NAME, 0);
        $this->session->setValue(self::COUNTER_NAME, ++$counter);
    }
}
