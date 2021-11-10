<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\CustomerEntity;

/**
 * Class CatalogCompareList
 */
class CatalogCompareList extends Model
{
	protected $table = 'catalog_compare_list';
	protected $primaryKey = 'list_id';
	public $timestamps = false;

	protected $casts = [
		'customer_id' => 'int'
	];

	protected $fillable = [
		'list_id_mask',
		'customer_id'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function catalog_compare_items()
	{
		return $this->hasMany(CatalogCompareItem::class, 'list_id');
	}
}
