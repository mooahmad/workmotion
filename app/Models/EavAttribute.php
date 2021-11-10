<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EavAttribute
 */
class EavAttribute extends Model
{
	protected $table = 'eav_attribute';
	protected $primaryKey = 'attribute_id';
	public $timestamps = false;

	protected $casts = [
		'entity_type_id' => 'int',
		'is_required' => 'int',
		'is_user_defined' => 'int',
		'is_unique' => 'int'
	];

	protected $fillable = [
		'entity_type_id',
		'attribute_code',
		'attribute_model',
		'backend_model',
		'backend_type',
		'backend_table',
		'frontend_model',
		'frontend_input',
		'frontend_label',
		'frontend_class',
		'source_model',
		'is_required',
		'is_user_defined',
		'default_value',
		'is_unique',
		'note'
	];

//	public function eav_entity_type()
//	{
//		return $this->belongsTo(EavEntityType::class, 'entity_type_id');
//	}

	public function catalog_category_entity_datetimes()
	{
		return $this->hasMany(CatalogCategoryEntityDatetime::class, 'attribute_id');
	}

	public function catalog_category_entity_decimals()
	{
		return $this->hasMany(CatalogCategoryEntityDecimal::class, 'attribute_id');
	}

	public function catalog_category_entity_ints()
	{
		return $this->hasMany(CatalogCategoryEntityInt::class, 'attribute_id');
	}

	public function catalog_category_entity_texts()
	{
		return $this->hasMany(CatalogCategoryEntityText::class, 'attribute_id');
	}

	public function catalog_category_entity_varchars()
	{
		return $this->hasMany(CatalogCategoryEntityVarchar::class, 'attribute_id');
	}

//	public function catalog_eav_attribute()
//	{
//		return $this->hasOne(CatalogEavAttribute::class, 'attribute_id');
//	}

	public function catalog_product_entity_datetimes()
	{
		return $this->hasMany(CatalogProductEntityDatetime::class, 'attribute_id');
	}

	public function catalog_product_entity_decimals()
	{
		return $this->hasMany(CatalogProductEntityDecimal::class, 'attribute_id');
	}

	public function catalog_product_entity_galleries()
	{
		return $this->hasMany(CatalogProductEntityGallery::class, 'attribute_id');
	}

	public function catalog_product_entity_ints()
	{
		return $this->hasMany(CatalogProductEntityInt::class, 'attribute_id');
	}

//	public function catalog_product_entity_media_galleries()
//	{
//		return $this->hasMany(CatalogProductEntityMediaGallery::class, 'attribute_id');
//	}

	public function catalog_product_entity_texts()
	{
		return $this->hasMany(CatalogProductEntityText::class, 'attribute_id');
	}

	public function catalog_product_entity_varchars()
	{
		return $this->hasMany(CatalogProductEntityVarchar::class, 'attribute_id');
	}
//
//	public function customer_address_entity_datetimes()
//	{
//		return $this->hasMany(CustomerAddressEntityDatetime::class, 'attribute_id');
//	}
//
//	public function customer_address_entity_decimals()
//	{
//		return $this->hasMany(CustomerAddressEntityDecimal::class, 'attribute_id');
//	}
//
//	public function customer_address_entity_ints()
//	{
//		return $this->hasMany(CustomerAddressEntityInt::class, 'attribute_id');
//	}
//
//	public function customer_address_entity_texts()
//	{
//		return $this->hasMany(CustomerAddressEntityText::class, 'attribute_id');
//	}
//
//	public function customer_address_entity_varchars()
//	{
//		return $this->hasMany(CustomerAddressEntityVarchar::class, 'attribute_id');
//	}
//
//	public function customer_eav_attribute()
//	{
//		return $this->hasOne(CustomerEavAttribute::class, 'attribute_id');
//	}
//
//	public function customer_eav_attribute_websites()
//	{
//		return $this->hasMany(CustomerEavAttributeWebsite::class, 'attribute_id');
//	}
//
//	public function customer_entity_datetimes()
//	{
//		return $this->hasMany(CustomerEntityDatetime::class, 'attribute_id');
//	}
//
//	public function customer_entity_decimals()
//	{
//		return $this->hasMany(CustomerEntityDecimal::class, 'attribute_id');
//	}
//
//	public function customer_entity_ints()
//	{
//		return $this->hasMany(CustomerEntityInt::class, 'attribute_id');
//	}
//
//	public function customer_entity_texts()
//	{
//		return $this->hasMany(CustomerEntityText::class, 'attribute_id');
//	}
//
//	public function customer_entity_varchars()
//	{
//		return $this->hasMany(CustomerEntityVarchar::class, 'attribute_id');
//	}
//
//	public function customer_form_attributes()
//	{
//		return $this->hasMany(CustomerFormAttribute::class, 'attribute_id');
//	}
//
//	public function eav_attribute_labels()
//	{
//		return $this->hasMany(EavAttributeLabel::class, 'attribute_id');
//	}
//
//	public function eav_attribute_options()
//	{
//		return $this->hasMany(EavAttributeOption::class, 'attribute_id');
//	}
//
//	public function eav_entity_attributes()
//	{
//		return $this->hasMany(EavEntityAttribute::class, 'attribute_id');
//	}
//
//	public function eav_form_elements()
//	{
//		return $this->hasMany(EavFormElement::class, 'attribute_id');
//	}
//
//	public function salesrule_product_attributes()
//	{
//		return $this->hasMany(SalesruleProductAttribute::class, 'attribute_id');
//	}
//
//	public function weee_taxes()
//	{
//		return $this->hasMany(WeeeTax::class, 'attribute_id');
//	}
}
