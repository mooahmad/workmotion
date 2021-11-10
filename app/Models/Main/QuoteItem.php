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
use App\Models\QuoteAddressItem;
use App\Models\QuoteItemOption;


/**
 * Class QuoteItem
 */
class QuoteItem extends Model
{
	protected $table = 'quote_item';
	protected $primaryKey = 'item_id';

	protected $casts = [
		'quote_id' => 'int',
		'product_id' => 'int',
		'store_id' => 'int',
		'parent_item_id' => 'int',
		'is_virtual' => 'int',
		'is_qty_decimal' => 'int',
		'no_discount' => 'int',
		'weight' => 'float',
		'qty' => 'float',
		'price' => 'float',
		'base_price' => 'float',
		'custom_price' => 'float',
		'discount_percent' => 'float',
		'discount_amount' => 'float',
		'base_discount_amount' => 'float',
		'tax_percent' => 'float',
		'tax_amount' => 'float',
		'base_tax_amount' => 'float',
		'row_total' => 'float',
		'base_row_total' => 'float',
		'row_total_with_discount' => 'float',
		'row_weight' => 'float',
		'base_tax_before_discount' => 'float',
		'tax_before_discount' => 'float',
		'original_custom_price' => 'float',
		'base_cost' => 'float',
		'price_incl_tax' => 'float',
		'base_price_incl_tax' => 'float',
		'row_total_incl_tax' => 'float',
		'base_row_total_incl_tax' => 'float',
		'discount_tax_compensation_amount' => 'float',
		'base_discount_tax_compensation_amount' => 'float',
		'gift_message_id' => 'int',
		'free_shipping' => 'int',
		'weee_tax_applied_amount' => 'float',
		'weee_tax_applied_row_amount' => 'float',
		'weee_tax_disposition' => 'float',
		'weee_tax_row_disposition' => 'float',
		'base_weee_tax_applied_amount' => 'float',
		'base_weee_tax_applied_row_amnt' => 'float',
		'base_weee_tax_disposition' => 'float',
		'base_weee_tax_row_disposition' => 'float'
	];

	protected $fillable = [
		'quote_id',
		'product_id',
		'store_id',
		'parent_item_id',
		'is_virtual',
		'sku',
		'name',
		'description',
		'applied_rule_ids',
		'additional_data',
		'is_qty_decimal',
		'no_discount',
		'weight',
		'qty',
		'price',
		'base_price',
		'custom_price',
		'discount_percent',
		'discount_amount',
		'base_discount_amount',
		'tax_percent',
		'tax_amount',
		'base_tax_amount',
		'row_total',
		'base_row_total',
		'row_total_with_discount',
		'row_weight',
		'product_type',
		'base_tax_before_discount',
		'tax_before_discount',
		'original_custom_price',
		'redirect_url',
		'base_cost',
		'price_incl_tax',
		'base_price_incl_tax',
		'row_total_incl_tax',
		'base_row_total_incl_tax',
		'discount_tax_compensation_amount',
		'base_discount_tax_compensation_amount',
		'gift_message_id',
		'free_shipping',
		'weee_tax_applied',
		'weee_tax_applied_amount',
		'weee_tax_applied_row_amount',
		'weee_tax_disposition',
		'weee_tax_row_disposition',
		'base_weee_tax_applied_amount',
		'base_weee_tax_applied_row_amnt',
		'base_weee_tax_disposition',
		'base_weee_tax_row_disposition'
	];

	public function quote_item()
	{
		return $this->belongsTo(QuoteItem::class, 'parent_item_id');
	}

	public function quote()
	{
		return $this->belongsTo(Quote::class,'quote_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class,'store_id');
	}

	public function quote_address_items()
	{
		return $this->hasMany(QuoteAddressItem::class,'quote_item_id');
	}

	public function quote_items()
	{
		return $this->hasMany(QuoteItem::class, 'parent_item_id');
	}

	public function quote_item_options()
	{
		return $this->hasMany(QuoteItemOption::class, 'item_id');
	}
}
