<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models\Main;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

/**
 * Class SalesOrder
 */
class SalesOrder extends Model
{
	protected $table = 'sales_order';
	protected $primaryKey = 'entity_id';

	protected $casts = [
		'is_virtual' => 'int',
		'store_id' => 'int',
		'customer_id' => 'int',
		'base_discount_amount' => 'float',
		'base_discount_canceled' => 'float',
		'base_discount_invoiced' => 'float',
		'base_discount_refunded' => 'float',
		'base_grand_total' => 'float',
		'base_shipping_amount' => 'float',
		'base_shipping_canceled' => 'float',
		'base_shipping_invoiced' => 'float',
		'base_shipping_refunded' => 'float',
		'base_shipping_tax_amount' => 'float',
		'base_shipping_tax_refunded' => 'float',
		'base_subtotal' => 'float',
		'base_subtotal_canceled' => 'float',
		'base_subtotal_invoiced' => 'float',
		'base_subtotal_refunded' => 'float',
		'base_tax_amount' => 'float',
		'base_tax_canceled' => 'float',
		'base_tax_invoiced' => 'float',
		'base_tax_refunded' => 'float',
		'base_to_global_rate' => 'float',
		'base_to_order_rate' => 'float',
		'base_total_canceled' => 'float',
		'base_total_invoiced' => 'float',
		'base_total_invoiced_cost' => 'float',
		'base_total_offline_refunded' => 'float',
		'base_total_online_refunded' => 'float',
		'base_total_paid' => 'float',
		'base_total_qty_ordered' => 'float',
		'base_total_refunded' => 'float',
		'discount_amount' => 'float',
		'discount_canceled' => 'float',
		'discount_invoiced' => 'float',
		'discount_refunded' => 'float',
		'grand_total' => 'float',
		'shipping_amount' => 'float',
		'shipping_canceled' => 'float',
		'shipping_invoiced' => 'float',
		'shipping_refunded' => 'float',
		'shipping_tax_amount' => 'float',
		'shipping_tax_refunded' => 'float',
		'store_to_base_rate' => 'float',
		'store_to_order_rate' => 'float',
		'subtotal' => 'float',
		'subtotal_canceled' => 'float',
		'subtotal_invoiced' => 'float',
		'subtotal_refunded' => 'float',
		'tax_amount' => 'float',
		'tax_canceled' => 'float',
		'tax_invoiced' => 'float',
		'tax_refunded' => 'float',
		'total_canceled' => 'float',
		'total_invoiced' => 'float',
		'total_offline_refunded' => 'float',
		'total_online_refunded' => 'float',
		'total_paid' => 'float',
		'total_qty_ordered' => 'float',
		'total_refunded' => 'float',
		'can_ship_partially' => 'int',
		'can_ship_partially_item' => 'int',
		'customer_is_guest' => 'int',
		'customer_note_notify' => 'int',
		'billing_address_id' => 'int',
		'customer_group_id' => 'int',
		'edit_increment' => 'int',
		'email_sent' => 'int',
		'send_email' => 'int',
		'forced_shipment_with_invoice' => 'int',
		'payment_auth_expiration' => 'int',
		'quote_address_id' => 'int',
		'quote_id' => 'int',
		'shipping_address_id' => 'int',
		'adjustment_negative' => 'float',
		'adjustment_positive' => 'float',
		'base_adjustment_negative' => 'float',
		'base_adjustment_positive' => 'float',
		'base_shipping_discount_amount' => 'float',
		'base_subtotal_incl_tax' => 'float',
		'base_total_due' => 'float',
		'payment_authorization_amount' => 'float',
		'shipping_discount_amount' => 'float',
		'subtotal_incl_tax' => 'float',
		'total_due' => 'float',
		'weight' => 'float',
		'total_item_count' => 'int',
		'customer_gender' => 'int',
		'discount_tax_compensation_amount' => 'float',
		'base_discount_tax_compensation_amount' => 'float',
		'shipping_discount_tax_compensation_amount' => 'float',
		'base_shipping_discount_tax_compensation_amnt' => 'float',
		'discount_tax_compensation_invoiced' => 'float',
		'base_discount_tax_compensation_invoiced' => 'float',
		'discount_tax_compensation_refunded' => 'float',
		'base_discount_tax_compensation_refunded' => 'float',
		'shipping_incl_tax' => 'float',
		'base_shipping_incl_tax' => 'float',
		'gift_message_id' => 'int',
		'paypal_ipn_customer_notified' => 'int'
	];

	protected $dates = [
		'customer_dob'
	];

	protected $fillable = [
		'state',
		'status',
		'coupon_code',
		'protect_code',
		'shipping_description',
		'is_virtual',
		'store_id',
		'customer_id',
		'base_discount_amount',
		'base_discount_canceled',
		'base_discount_invoiced',
		'base_discount_refunded',
		'base_grand_total',
		'base_shipping_amount',
		'base_shipping_canceled',
		'base_shipping_invoiced',
		'base_shipping_refunded',
		'base_shipping_tax_amount',
		'base_shipping_tax_refunded',
		'base_subtotal',
		'base_subtotal_canceled',
		'base_subtotal_invoiced',
		'base_subtotal_refunded',
		'base_tax_amount',
		'base_tax_canceled',
		'base_tax_invoiced',
		'base_tax_refunded',
		'base_to_global_rate',
		'base_to_order_rate',
		'base_total_canceled',
		'base_total_invoiced',
		'base_total_invoiced_cost',
		'base_total_offline_refunded',
		'base_total_online_refunded',
		'base_total_paid',
		'base_total_qty_ordered',
		'base_total_refunded',
		'discount_amount',
		'discount_canceled',
		'discount_invoiced',
		'discount_refunded',
		'grand_total',
		'shipping_amount',
		'shipping_canceled',
		'shipping_invoiced',
		'shipping_refunded',
		'shipping_tax_amount',
		'shipping_tax_refunded',
		'store_to_base_rate',
		'store_to_order_rate',
		'subtotal',
		'subtotal_canceled',
		'subtotal_invoiced',
		'subtotal_refunded',
		'tax_amount',
		'tax_canceled',
		'tax_invoiced',
		'tax_refunded',
		'total_canceled',
		'total_invoiced',
		'total_offline_refunded',
		'total_online_refunded',
		'total_paid',
		'total_qty_ordered',
		'total_refunded',
		'can_ship_partially',
		'can_ship_partially_item',
		'customer_is_guest',
		'customer_note_notify',
		'billing_address_id',
		'customer_group_id',
		'edit_increment',
		'email_sent',
		'send_email',
		'forced_shipment_with_invoice',
		'payment_auth_expiration',
		'quote_address_id',
		'quote_id',
		'shipping_address_id',
		'adjustment_negative',
		'adjustment_positive',
		'base_adjustment_negative',
		'base_adjustment_positive',
		'base_shipping_discount_amount',
		'base_subtotal_incl_tax',
		'base_total_due',
		'payment_authorization_amount',
		'shipping_discount_amount',
		'subtotal_incl_tax',
		'total_due',
		'weight',
		'customer_dob',
		'increment_id',
		'applied_rule_ids',
		'base_currency_code',
		'customer_email',
		'customer_firstname',
		'customer_lastname',
		'customer_middlename',
		'customer_prefix',
		'customer_suffix',
		'customer_taxvat',
		'discount_description',
		'ext_customer_id',
		'ext_order_id',
		'global_currency_code',
		'hold_before_state',
		'hold_before_status',
		'order_currency_code',
		'original_increment_id',
		'relation_child_id',
		'relation_child_real_id',
		'relation_parent_id',
		'relation_parent_real_id',
		'remote_ip',
		'shipping_method',
		'store_currency_code',
		'store_name',
		'x_forwarded_for',
		'customer_note',
		'total_item_count',
		'customer_gender',
		'discount_tax_compensation_amount',
		'base_discount_tax_compensation_amount',
		'shipping_discount_tax_compensation_amount',
		'base_shipping_discount_tax_compensation_amnt',
		'discount_tax_compensation_invoiced',
		'base_discount_tax_compensation_invoiced',
		'discount_tax_compensation_refunded',
		'base_discount_tax_compensation_refunded',
		'shipping_incl_tax',
		'base_shipping_incl_tax',
		'coupon_rule_name',
		'gift_message_id',
		'paypal_ipn_customer_notified'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class,'store_id');
	}
//
//	public function downloadable_link_purchaseds()
//	{
//		return $this->hasMany(DownloadableLinkPurchased::class, 'order_id');
//	}
//
//	public function paypal_billing_agreement_orders()
//	{
//		return $this->hasMany(PaypalBillingAgreementOrder::class, 'order_id');
//	}
//
//	public function sales_creditmemos()
//	{
//		return $this->hasMany(SalesCreditmemo::class, 'order_id');
//	}
//
//	public function sales_invoices()
//	{
//		return $this->hasMany(SalesInvoice::class, 'order_id');
//	}
//
//	public function sales_order_addresses()
//	{
//		return $this->hasMany(SalesOrderAddress::class, 'parent_id');
//	}

	public function sales_order_items()
	{
		return $this->hasMany(SalesOrderItem::class, 'order_id');
	}

//	public function sales_order_payments()
//	{
//		return $this->hasMany(SalesOrderPayment::class, 'parent_id');
//	}
//
//	public function sales_order_status_histories()
//	{
//		return $this->hasMany(SalesOrderStatusHistory::class, 'parent_id');
//	}
//
//	public function sales_payment_transactions()
//	{
//		return $this->hasMany(SalesPaymentTransaction::class, 'order_id');
//	}
//
//	public function sales_shipments()
//	{
//		return $this->hasMany(SalesShipment::class, 'order_id');
//	}
}
