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
use App\Models\Main\QuoteIdMask;
use App\Models\QuotePayment;

/**
 * Class Quote
 */
class Quote extends Model
{
	protected $table = 'quote';
	protected $primaryKey = 'entity_id';

	protected $casts = [
		'store_id' => 'int',
		'is_active' => 'int',
		'is_virtual' => 'int',
		'is_multi_shipping' => 'int',
		'items_count' => 'int',
		'items_qty' => 'float',
		'orig_order_id' => 'int',
		'store_to_base_rate' => 'float',
		'store_to_quote_rate' => 'float',
		'grand_total' => 'float',
		'base_grand_total' => 'float',
		'customer_id' => 'int',
		'customer_tax_class_id' => 'int',
		'customer_group_id' => 'int',
		'customer_note_notify' => 'int',
		'customer_is_guest' => 'int',
		'base_to_global_rate' => 'float',
		'base_to_quote_rate' => 'float',
		'subtotal' => 'float',
		'base_subtotal' => 'float',
		'subtotal_with_discount' => 'float',
		'base_subtotal_with_discount' => 'float',
		'is_changed' => 'int',
		'trigger_recollect' => 'int',
		'gift_message_id' => 'int',
		'is_persistent' => 'int'
	];

	protected $dates = [
		'converted_at',
		'customer_dob'
	];

	protected $fillable = [
		'store_id',
		'converted_at',
		'is_active',
		'is_virtual',
		'is_multi_shipping',
		'items_count',
		'items_qty',
		'orig_order_id',
		'store_to_base_rate',
		'store_to_quote_rate',
		'base_currency_code',
		'store_currency_code',
		'quote_currency_code',
		'grand_total',
		'base_grand_total',
		'checkout_method',
		'customer_id',
		'customer_tax_class_id',
		'customer_group_id',
		'customer_email',
		'customer_prefix',
		'customer_firstname',
		'customer_middlename',
		'customer_lastname',
		'customer_suffix',
		'customer_dob',
		'customer_note',
		'customer_note_notify',
		'customer_is_guest',
		'remote_ip',
		'applied_rule_ids',
		'reserved_order_id',
		'password_hash',
		'coupon_code',
		'global_currency_code',
		'base_to_global_rate',
		'base_to_quote_rate',
		'customer_taxvat',
		'customer_gender',
		'subtotal',
		'base_subtotal',
		'subtotal_with_discount',
		'base_subtotal_with_discount',
		'is_changed',
		'trigger_recollect',
		'ext_shipping_info',
		'gift_message_id',
		'is_persistent'
	];

	public function store()
	{
		return $this->belongsTo(Store::class,'store_id');
	}

	public function quote_addresses()
	{
		return $this->hasMany(QuoteAddress::class,'quote_id');
	}


	public function getQuote_billing_addresses()
	{
		return $this->hasMany(QuoteAddress::class,'quote_id')->where('address_type','=','billing')->first();
	}

	public function getQuote_shipping_addresses()
	{
		return $this->hasMany(QuoteAddress::class,'quote_id')->where('address_type','=','shipping')->first();
	}

	public function quote_id_masks()
	{
		return $this->hasMany(QuoteIdMask::class,'quote_id');
	}

	public function quote_items()
	{
		return $this->hasMany(QuoteItem::class,'quote_id');
	}

	public function quote_payments()
	{
		return $this->hasMany(QuotePayment::class,'quote_id');
	}
}
