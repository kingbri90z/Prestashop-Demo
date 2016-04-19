<?php
/**
 * G2APay Submit Controller.
 *
 * @author    G2A Team
 * @copyright Copyright (c) 2015 G2A.COM
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class G2APayOrder implements G2APayOrderInterface
{
    /**
     * @var G2APayOrderInterface
     */
    protected $order;

    protected $customer;
    protected $currency;

    /**
     * @var G2APayTransactionInterface
     */
    protected $transaction;

    /**
     * @param Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get order id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->order->id;
    }

    /**
     * Get total order amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return G2APayHelper::round($this->order->total_paid_tax_incl);
    }

    /**
     * Get currency symbol.
     *
     * @return string
     */
    public function getCurrency()
    {
        $this->initCurrency();

        return $this->currency->iso_code;
    }

    /**
     * Get customer id.
     *
     * @return int
     */
    public function getCustomerId()
    {
        $this->initCustomer();

        return $this->customer->id;
    }

    /**
     * Get customer email.
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        $this->initCustomer();

        return $this->customer->email;
    }

    /**
     * Get order items array.
     *
     * @return array
     */
    public function getItems()
    {
        $items    = array();
        $products = $this->order->getProducts();
        foreach ($products as $product) {
            $item = new G2APayOrderItemProduct($product);
            if ($item->getAmount() != 0) {
                $items[] = $item;
            }
        }

        $shipping = $this->order->getShipping();
        foreach ($shipping as $ship) {
            $item = new G2APayOrderItemShipping($ship);
            if ($item->getAmount() != 0) {
                $items[] = $item;
            }
        }

        $discounts = $this->order->getCartRules();
        foreach ($discounts as $discount) {
            $item = new G2APayOrderItemDiscount($discount);
            if ($item->getAmount() != 0) {
                $items[] = $item;
            }
        }

        $totalsDiff = $this->getAmount() - $this->sumItemsAmount($items);
        if (abs($totalsDiff) > 0.0001) {
            $item = new G2APayOrderItemOther($totalsDiff);
            if ($item->getAmount() != 0) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Get order transaction.
     *
     * @return G2APayTransactionInterface
     */
    public function getTransaction()
    {
        $this->initTransaction();

        return $this->transaction;
    }

    /**
     * Init order transaction.
     */
    protected function initTransaction()
    {
        if (is_null($this->transaction)) {
            $this->transaction = new G2APayTransaction($this->order->id);
        }
    }

    /**
     * Init order currency.
     */
    protected function initCurrency()
    {
        if (is_null($this->currency)) {
            $this->currency = new Currency($this->order->id_currency);
        }
    }

    /**
     * Get order description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->order->reference;
    }

    /**
     * Init order customer.
     */
    protected function initCustomer()
    {
        if (is_null($this->customer)) {
            $this->customer = new Customer($this->order->id_customer);
        }
    }

    /**
     * Mark order as  complete.
     *
     * @return bool
     */
    public function complete()
    {
        if (!$this->order->hasInvoice()) {
            $transaction = $this->getTransaction();
            // complete should be done when full amount is paid
            $this->order->addOrderPayment($this->getAmount(), null, $transaction->getTransactionId());
            $this->order->setInvoice(true);
        }

        $status = Configuration::get('PS_OS_PAYMENT') ? Configuration::get('PS_OS_PAYMENT') : _PS_OS_PAYMENT_;

        return $this->updateState($status);
    }

    /**
     * Mark order as  canceled.
     *
     * @return bool
     */
    public function cancel()
    {
        $status = Configuration::get('PS_OS_CANCELED') ? Configuration::get('PS_OS_CANCELED') : _PS_OS_CANCELED_;

        return $this->updateState($status);
    }

    /**
     * Mark order as refunded.
     *
     * @return bool
     */
    public function refund()
    {
        $status = Configuration::get('PS_OS_REFUND') ? Configuration::get('PS_OS_REFUND') : _PS_OS_REFUND_;

        return $this->updateState($status);
    }

    /**
     * Add order private message.
     *
     * @param $text
     * @return bool
     */
    public function addMessage($text)
    {
        $message = new Message();
        $text    = strip_tags($text, '<br>');

        if (!Validate::isCleanHtml($text)) {
            $text = 'Invalid payment messsage.';
        }

        $message->message  = $text;
        $message->id_order = (int) $this->order->id;
        $message->private  = 1;

        return $message->add();
    }

    /**
     * Update order state.
     *
     * @param $state
     * @param bool $email
     * @return bool
     */
    protected function updateState($state, $email = false)
    {
        $state = new OrderState($state);

        if (!Validate::isLoadedObject($state)) {
            return false;
        }

        $current_state = $this->order->getCurrentOrderState();
        if ($current_state->id != $state->id) {
            $history              = new OrderHistory();
            $history->id_order    = $this->order->id;
            $history->id_employee = 0;
            $history->changeIdOrderState((int) $state->id, $this->order, $this->order->hasInvoice());

            return $email ? $history->addWithemail() : $history->add();
        }

        return true;
    }

    public function canRefundAmount($amount = 0)
    {
        $transaction = $this->getTransaction();

        return $transaction->canBeRefunded() && $amount >= 0 && $this->getMaxRefundAmount() >= $amount;
    }

    public function getMaxRefundAmount()
    {
        $transaction = $this->getTransaction();

        return G2APayHelper::round($this->getAmount() - $transaction->getRefundedAmount());
    }

    protected function sumItemsAmount($items)
    {
        $amount = 0;
        /** @var G2APayOrderItemInterface $item */
        foreach ($items as $item) {
            $amount += $item->getAmount();
        }

        return $amount;
    }
}
