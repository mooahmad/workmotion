<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductEntityMediaGalleryValue
 */
class CatalogProductEntityMediaGalleryValue extends Model
{
	protected $table = 'catalog_product_entity_media_gallery_value';
	protected $primaryKey = 'record_id';
	public $timestamps = false;

	protected $casts = [
		'value_id' => 'int',
		'store_id' => 'int',
		'entity_id' => 'int',
		'position' => 'int',
		'disabled' => 'int'
	];

	protected $fillable = [
		'value_id',
		'store_id',
		'entity_id',
		'label',
		'position',
		'disabled'
	];

	public function catalog_product_entity()
	{
		return $this->belongsTo(CatalogProductEntity::class, 'entity_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class,'store_id');
	}

	public function catalog_product_entity_media_gallery()
	{
		return $this->belongsTo(CatalogProductEntityMediaGallery::class, 'value_id');
	}
}
