<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models\Main;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuoteAddressItem;
use App\Models\QuoteShippingRate;


/**
 * Class QuoteAddress
 */
class QuoteAddress extends Model
{
	protected $table = 'quote_address';
	protected $primaryKey = 'address_id';

	protected $casts = [
		'quote_id' => 'int',
		'customer_id' => 'int',
		'save_in_address_book' => 'int',
		'customer_address_id' => 'int',
		'region_id' => 'int',
		'same_as_billing' => 'int',
		'collect_shipping_rates' => 'int',
		'weight' => 'float',
		'subtotal' => 'float',
		'base_subtotal' => 'float',
		'subtotal_with_discount' => 'float',
		'base_subtotal_with_discount' => 'float',
		'tax_amount' => 'float',
		'base_tax_amount' => 'float',
		'shipping_amount' => 'float',
		'base_shipping_amount' => 'float',
		'shipping_tax_amount' => 'float',
		'base_shipping_tax_amount' => 'float',
		'discount_amount' => 'float',
		'base_discount_amount' => 'float',
		'grand_total' => 'float',
		'base_grand_total' => 'float',
		'shipping_discount_amount' => 'float',
		'base_shipping_discount_amount' => 'float',
		'subtotal_incl_tax' => 'float',
		'base_subtotal_total_incl_tax' => 'float',
		'discount_tax_compensation_amount' => 'float',
		'base_discount_tax_compensation_amount' => 'float',
		'shipping_discount_tax_compensation_amount' => 'float',
		'base_shipping_discount_tax_compensation_amnt' => 'float',
		'shipping_incl_tax' => 'float',
		'base_shipping_incl_tax' => 'float',
		'vat_is_valid' => 'int',
		'vat_request_success' => 'int',
		'gift_message_id' => 'int',
		'free_shipping' => 'int'
	];

	protected $fillable = [
		'quote_id',
		'customer_id',
		'save_in_address_book',
		'customer_address_id',
		'address_type',
		'email',
		'prefix',
		'firstname',
		'middlename',
		'lastname',
		'suffix',
		'company',
		'street',
		'city',
		'region',
		'region_id',
		'postcode',
		'country_id',
		'telephone',
		'fax',
		'same_as_billing',
		'collect_shipping_rates',
		'shipping_method',
		'shipping_description',
		'weight',
		'subtotal',
		'base_subtotal',
		'subtotal_with_discount',
		'base_subtotal_with_discount',
		'tax_amount',
		'base_tax_amount',
		'shipping_amount',
		'base_shipping_amount',
		'shipping_tax_amount',
		'base_shipping_tax_amount',
		'discount_amount',
		'base_discount_amount',
		'grand_total',
		'base_grand_total',
		'customer_notes',
		'applied_taxes',
		'discount_description',
		'shipping_discount_amount',
		'base_shipping_discount_amount',
		'subtotal_incl_tax',
		'base_subtotal_total_incl_tax',
		'discount_tax_compensation_amount',
		'base_discount_tax_compensation_amount',
		'shipping_discount_tax_compensation_amount',
		'base_shipping_discount_tax_compensation_amnt',
		'shipping_incl_tax',
		'base_shipping_incl_tax',
		'vat_id',
		'vat_is_valid',
		'vat_request_id',
		'vat_request_date',
		'vat_request_success',
		'validated_country_code',
		'validated_vat_number',
		'gift_message_id',
		'free_shipping'
	];

	public function quote()
	{
		return $this->belongsTo(Quote::class,'quote_id');
	}

	public function quote_address_items()
	{
		return $this->hasMany(QuoteAddressItem::class,'quote_address_id');
	}

	public function quote_shipping_rates()
	{
		return $this->hasMany(QuoteShippingRate::class, 'address_id');
	}
}
