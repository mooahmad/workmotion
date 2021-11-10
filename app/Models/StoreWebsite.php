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
 * Class StoreWebsite
 */
class StoreWebsite extends Model
{
	protected $table = 'store_website';
	protected $primaryKey = 'website_id';
	public $timestamps = false;

	protected $casts = [
		'sort_order' => 'int',
		'default_group_id' => 'int',
		'is_default' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'sort_order',
		'default_group_id',
		'is_default'
	];

//	public function catalog_product_bundle_price_indices()
//	{
//		return $this->hasMany(CatalogProductBundlePriceIndex::class, 'website_id');
//	}
//
//	public function catalog_product_bundle_selection_prices()
//	{
//		return $this->hasMany(CatalogProductBundleSelectionPrice::class, 'website_id');
//	}
//
//	public function catalog_product_entity_tier_prices()
//	{
//		return $this->hasMany(CatalogProductEntityTierPrice::class, 'website_id');
//	}
//
//	public function catalog_product_index_tier_prices()
//	{
//		return $this->hasMany(CatalogProductIndexTierPrice::class, 'website_id');
//	}
//
//	public function catalog_product_index_website()
//	{
//		return $this->hasOne(CatalogProductIndexWebsite::class, 'website_id');
//	}
//
//	public function catalog_product_websites()
//	{
//		return $this->hasMany(CatalogProductWebsite::class, 'website_id');
//	}
//
//	public function catalogrule_websites()
//	{
//		return $this->hasMany(CatalogruleWebsite::class, 'website_id');
//	}
//
//	public function customer_eav_attribute_websites()
//	{
//		return $this->hasMany(CustomerEavAttributeWebsite::class, 'website_id');
//	}

	public function customer_entities()
	{
		return $this->hasMany(CustomerEntity::class, 'website_id');
	}
//
//	public function downloadable_link_prices()
//	{
//		return $this->hasMany(DownloadableLinkPrice::class, 'website_id');
//	}
//
//	public function paypal_certs()
//	{
//		return $this->hasMany(PaypalCert::class, 'website_id');
//	}
//
//	public function persistent_sessions()
//	{
//		return $this->hasMany(PersistentSession::class, 'website_id');
//	}
//
//	public function product_alert_prices()
//	{
//		return $this->hasMany(ProductAlertPrice::class, 'website_id');
//	}
//
//	public function product_alert_stocks()
//	{
//		return $this->hasMany(ProductAlertStock::class, 'website_id');
//	}
//
//	public function salesrule_product_attributes()
//	{
//		return $this->hasMany(SalesruleProductAttribute::class, 'website_id');
//	}
//
//	public function salesrule_websites()
//	{
//		return $this->hasMany(SalesruleWebsite::class, 'website_id');
//	}
//
//	public function search_synonyms()
//	{
//		return $this->hasMany(SearchSynonym::class, 'website_id');
//	}

	public function stores()
	{
		return $this->hasMany(Store::class, 'website_id');
	}

	public function store_groups()
	{
		return $this->hasMany(StoreGroup::class, 'website_id');
	}

//	public function weee_taxes()
//	{
//		return $this->hasMany(WeeeTax::class, 'website_id');
//	}
}
