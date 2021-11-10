<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\QuoteAddress;
use App\Models\Main\QuoteItem;

/**
 * Class QuoteAddressItem
 */
class QuoteAddressItem extends Model
{
	protected $table = 'quote_address_item';
	protected $primaryKey = 'address_item_id';

	protected $casts = [
		'parent_item_id' => 'int',
		'quote_address_id' => 'int',
		'quote_item_id' => 'int',
		'weight' => 'float',
		'qty' => 'float',
		'discount_amount' => 'float',
		'tax_amount' => 'float',
		'row_total' => 'float',
		'base_row_total' => 'float',
		'row_total_with_discount' => 'float',
		'base_discount_amount' => 'float',
		'base_tax_amount' => 'float',
		'row_weight' => 'float',
		'product_id' => 'int',
		'super_product_id' => 'int',
		'parent_product_id' => 'int',
		'store_id' => 'int',
		'is_qty_decimal' => 'int',
		'price' => 'float',
		'discount_percent' => 'float',
		'no_discount' => 'int',
		'tax_percent' => 'float',
		'base_price' => 'float',
		'base_cost' => 'float',
		'price_incl_tax' => 'float',
		'base_price_incl_tax' => 'float',
		'row_total_incl_tax' => 'float',
		'base_row_total_incl_tax' => 'float',
		'discount_tax_compensation_amount' => 'float',
		'base_discount_tax_compensation_amount' => 'float',
		'gift_message_id' => 'int',
		'free_shipping' => 'int'
	];

	protected $fillable = [
		'parent_item_id',
		'quote_address_id',
		'quote_item_id',
		'applied_rule_ids',
		'additional_data',
		'weight',
		'qty',
		'discount_amount',
		'tax_amount',
		'row_total',
		'base_row_total',
		'row_total_with_discount',
		'base_discount_amount',
		'base_tax_amount',
		'row_weight',
		'product_id',
		'super_product_id',
		'parent_product_id',
		'store_id',
		'sku',
		'image',
		'name',
		'description',
		'is_qty_decimal',
		'price',
		'discount_percent',
		'no_discount',
		'tax_percent',
		'base_price',
		'base_cost',
		'price_incl_tax',
		'base_price_incl_tax',
		'row_total_incl_tax',
		'base_row_total_incl_tax',
		'discount_tax_compensation_amount',
		'base_discount_tax_compensation_amount',
		'gift_message_id',
		'free_shipping'
	];

	public function quote_address()
	{
		return $this->belongsTo(QuoteAddress::class,'quote_address_id');
	}

	public function quote_item()
	{
		return $this->belongsTo(QuoteItem::class,'quote_item_id');
	}

	public function quote_address_item()
	{
		return $this->belongsTo(QuoteAddressItem::class, 'parent_item_id');
	}

	public function quote_address_items()
	{
		return $this->hasMany(QuoteAddressItem::class, 'parent_item_id');
	}
}
