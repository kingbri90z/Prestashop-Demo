<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *         DISCLAIMER   *
 * ***************************************
 * Do not edit or add to this file if you wish to upgrade Prestashop to newer
 * versions in the future.
 * ****************************************************
 *
 * @category    Belvg
 * @package    Belvg_Twocheckout
 * @author    Alexander Simonchik <support@belvg.com>
 * @copyright Copyright (c) 2010 - 2014 BelVG LLC. (http://www.belvg.com)
 * @license   http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

class TwocheckoutOrder extends ObjectModel
{
	public $id_twocheckout_order;
	public $reference;
	public $order_number;
	public $transaction_id;
	public $merchant_order_id;
	public $date_add;
	public $date_upd;

	public static $definition = array(
		'table' => 'twocheckout_order',
		'primary' => 'id_twocheckout_order',
		'fields' => array(
			'reference' => 			array('type' => self::TYPE_STRING),
			'order_number' => 		array('type' => self::TYPE_INT),
			'transaction_id' => 		array('type' => self::TYPE_INT),
			'merchant_order_id' => 	array('type' => self::TYPE_STRING),
			'date_add' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => 			array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
		),
	);

	public static function saveCharge($reference, $charge)
	{
		$twocheckout_order = new self();
		$twocheckout_order->reference = $reference;
		$twocheckout_order->order_number = $charge['response']['orderNumber'];
		$twocheckout_order->transaction_id = $charge['response']['transactionId'];
		$twocheckout_order->merchant_order_id = $charge['response']['merchantOrderId'];

		$twocheckout_order->add();
	}

	public static function getByOrderReference($reference)
	{
		return Db::getInstance()->getRow(
			'SELECT * FROM `'._DB_PREFIX_.'twocheckout_order`
			WHERE reference = "'.pSQL($reference).'"'
		);
	}
}