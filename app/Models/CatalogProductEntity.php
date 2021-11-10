<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductEntity
 */
class CatalogProductEntity extends Model
{
	protected $table = 'catalog_product_entity';
	protected $primaryKey = 'entity_id';

	protected $casts = [
		'attribute_set_id' => 'int',
		'has_options' => 'int',
		'required_options' => 'int'
	];

	protected $fillable = [
		'attribute_set_id',
		'type_id',
		'sku',
		'has_options',
		'required_options'
	];

	public function catalog_category_products()
	{
		return $this->hasMany(CatalogCategoryProduct::class, 'product_id');
	}

	public function catalog_compare_items()
	{
		return $this->hasMany(CatalogCompareItem::class, 'product_id');
	}

//	public function catalog_product_bundle_options()
//	{
//		return $this->hasMany(CatalogProductBundleOption::class, 'parent_id');
//	}
//
//	public function catalog_product_bundle_price_indices()
//	{
//		return $this->hasMany(CatalogProductBundlePriceIndex::class, 'entity_id');
//	}
//
//	public function catalog_product_bundle_selections()
//	{
//		return $this->hasMany(CatalogProductBundleSelection::class, 'product_id');
//	}

	public function catalog_product_entity_datetimes()
	{
		return $this->hasMany(CatalogProductEntityDatetime::class, 'entity_id');
	}

	public function catalog_product_entity_decimals()
	{
		return $this->hasMany(CatalogProductEntityDecimal::class, 'entity_id');
	}

	public function catalog_product_entity_galleries()
	{
		return $this->hasMany(CatalogProductEntityGallery::class, 'entity_id');
	}

	public function catalog_product_entity_ints()
	{
		return $this->hasMany(CatalogProductEntityInt::class, 'entity_id');
	}

	public function catalog_product_entity_media_gallery_values()
	{
		return $this->hasMany(CatalogProductEntityMediaGalleryValue::class, 'entity_id');
	}

//	public function catalog_product_entity_media_gallery_value_to_entities()
//	{
//		return $this->hasMany(CatalogProductEntityMediaGalleryValueToEntity::class, 'entity_id');
//	}

	public function catalog_product_entity_texts()
	{
		return $this->hasMany(CatalogProductEntityText::class, 'entity_id');
	}

//	public function catalog_product_entity_tier_prices()
//	{
//		return $this->hasMany(CatalogProductEntityTierPrice::class, 'entity_id');
//	}

	public function catalog_product_entity_varchars()
	{
		return $this->hasMany(CatalogProductEntityVarchar::class, 'entity_id');
	}

//	public function catalog_product_frontend_actions()
//	{
//		return $this->hasMany(CatalogProductFrontendAction::class, 'product_id');
//	}

//	public function catalog_product_index_tier_prices()
//	{
//		return $this->hasMany(CatalogProductIndexTierPrice::class, 'entity_id');
//	}
//
//	public function catalog_product_links()
//	{
//		return $this->hasMany(CatalogProductLink::class, 'linked_product_id');
//	}

//	public function catalog_product_options()
//	{
//		return $this->hasMany(CatalogProductOption::class, 'product_id');
//	}

//	public function catalog_product_relations()
//	{
//		return $this->hasMany(CatalogProductRelation::class, 'parent_id');
//	}

//	public function catalog_product_super_attributes()
//	{
//		return $this->hasMany(CatalogProductSuperAttribute::class, 'product_id');
//	}
//
//	public function catalog_product_super_links()
//	{
//		return $this->hasMany(CatalogProductSuperLink::class, 'product_id');
//	}
//
//	public function catalog_product_websites()
//	{
//		return $this->hasMany(CatalogProductWebsite::class, 'product_id');
//	}
//
//	public function catalog_url_rewrite_product_category()
//	{
//		return $this->hasOne(CatalogUrlRewriteProductCategory::class, 'product_id');
//	}
//
//	public function cataloginventory_stock_items()
//	{
//		return $this->hasMany(CataloginventoryStockItem::class, 'product_id');
//	}
//
//	public function downloadable_links()
//	{
//		return $this->hasMany(DownloadableLink::class, 'product_id');
//	}
//
//	public function downloadable_samples()
//	{
//		return $this->hasMany(DownloadableSample::class, 'product_id');
//	}
//
//	public function product_alert_prices()
//	{
//		return $this->hasMany(ProductAlertPrice::class, 'product_id');
//	}
//
//	public function product_alert_stocks()
//	{
//		return $this->hasMany(ProductAlertStock::class, 'product_id');
//	}
//
//	public function report_compared_product_indices()
//	{
//		return $this->hasMany(ReportComparedProductIndex::class, 'product_id');
//	}
//
//	public function report_viewed_product_aggregated_dailies()
//	{
//		return $this->hasMany(ReportViewedProductAggregatedDaily::class, 'product_id');
//	}
//
//	public function report_viewed_product_aggregated_monthlies()
//	{
//		return $this->hasMany(ReportViewedProductAggregatedMonthly::class, 'product_id');
//	}
//
//	public function report_viewed_product_aggregated_yearlies()
//	{
//		return $this->hasMany(ReportViewedProductAggregatedYearly::class, 'product_id');
//	}
//
//	public function report_viewed_product_indices()
//	{
//		return $this->hasMany(ReportViewedProductIndex::class, 'product_id');
//	}
//
//	public function weee_taxes()
//	{
//		return $this->hasMany(WeeeTax::class, 'entity_id');
//	}
//
//	public function wishlist_items()
//	{
//		return $this->hasMany(WishlistItem::class, 'product_id');
//	}
}
