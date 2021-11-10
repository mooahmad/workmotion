<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductEntityMediaGallery
 */
class CatalogProductEntityMediaGallery extends Model
{
	protected $table = 'catalog_product_entity_media_gallery';
	protected $primaryKey = 'value_id';
	public $timestamps = false;

	protected $casts = [
		'attribute_id' => 'int',
		'disabled' => 'int'
	];

	protected $fillable = [
		'attribute_id',
		'value',
		'media_type',
		'disabled'
	];

	public function eav_attribute()
	{
		return $this->belongsTo(EavAttribute::class, 'attribute_id');
	}

	public function catalog_product_entity_media_gallery_values()
	{
		return $this->hasMany(CatalogProductEntityMediaGalleryValue::class, 'value_id');
	}

//	public function catalog_product_entity_media_gallery_value_to_entities()
//	{
//		return $this->hasMany(CatalogProductEntityMediaGalleryValueToEntity::class, 'value_id');
//	}
//
//	public function catalog_product_entity_media_gallery_value_videos()
//	{
//		return $this->hasMany(CatalogProductEntityMediaGalleryValueVideo::class, 'value_id');
//	}
}
