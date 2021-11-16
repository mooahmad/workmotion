<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models\Main;

use Illuminate\Database\Eloquent\Model;
use App\Models\Main\Quote;

/**
 * Class QuoteIdMask
 */
class QuoteIdMask extends Model
{
	protected $table = 'quote_id_mask';
    protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'quote_id' => 'int'
	];

	protected $fillable = [
		'quote_id',
        'masked_id'
	];

	public function quote()
	{
		return $this->belongsTo(Quote::class,'quote_id');
	}
}
