<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Main\QuoteItem;

/**
 * Class QuoteItemOption
 */
class QuoteItemOption extends Model
{
	protected $table = 'quote_item_option';
	protected $primaryKey = 'option_id';
	public $timestamps = false;

	protected $casts = [
		'item_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'item_id',
		'product_id',
		'code',
		'value'
	];

	public function quote_item()
	{
		return $this->belongsTo(QuoteItem::class, 'item_id');
	}
}
