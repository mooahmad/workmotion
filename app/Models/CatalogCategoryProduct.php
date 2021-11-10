<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogCategoryProduct
 */
class CatalogCategoryProduct extends Model
{
	protected $table = 'catalog_category_product';
    protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'category_id' => 'int',
		'product_id' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'position'
	];

	public function catalog_category_entity()
	{
		return $this->belongsTo(CatalogCategoryEntity::class, 'category_id');
	}

	public function catalog_product_entity()
	{
		return $this->belongsTo(CatalogProductEntity::class, 'product_id');
	}
}
