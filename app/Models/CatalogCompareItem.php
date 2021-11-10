<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Main\CustomerEntity;

/**
 * Class CatalogCompareItem
 */
class CatalogCompareItem extends Model
{
	protected $table = 'catalog_compare_item';
	protected $primaryKey = 'catalog_compare_item_id';
	public $timestamps = false;

	protected $casts = [
		'visitor_id' => 'int',
		'customer_id' => 'int',
		'product_id' => 'int',
		'store_id' => 'int',
		'list_id' => 'int'
	];

	protected $fillable = [
		'visitor_id',
		'customer_id',
		'product_id',
		'store_id',
		'list_id'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function catalog_compare_list()
	{
		return $this->belongsTo(CatalogCompareList::class, 'list_id');
	}

	public function catalog_product_entity()
	{
		return $this->belongsTo(CatalogProductEntity::class, 'product_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class,'store_id');
	}
}
