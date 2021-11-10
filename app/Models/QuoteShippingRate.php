<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\QuoteAddress;

/**
 * Class QuoteShippingRate
 */
class QuoteShippingRate extends Model
{
	protected $table = 'quote_shipping_rate';
	protected $primaryKey = 'rate_id';

	protected $casts = [
		'address_id' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'address_id',
		'carrier',
		'carrier_title',
		'code',
		'method',
		'method_description',
		'price',
		'error_message',
		'method_title'
	];

	public function quote_address()
	{
		return $this->belongsTo(QuoteAddress::class, 'address_id');
	}
}
