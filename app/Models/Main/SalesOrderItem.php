<?php

namespace App\Models\Main;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
class SalesOrderItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_order_item';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'item_id';

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'store_id', 'parent_item_id', 'quote_item_id', 'created_at', 'updated_at', 'product_id', 'product_type', 'product_options', 'weight', 'is_virtual', 'sku', 'name', 'description', 'applied_rule_ids', 'additional_data', 'is_qty_decimal', 'no_discount', 'qty_backordered', 'qty_canceled', 'qty_invoiced', 'qty_ordered', 'qty_refunded', 'qty_shipped', 'base_cost', 'price', 'base_price', 'original_price', 'base_original_price', 'tax_percent', 'tax_amount', 'base_tax_amount', 'tax_invoiced', 'base_tax_invoiced', 'discount_percent', 'discount_amount', 'base_discount_amount', 'discount_invoiced', 'base_discount_invoiced', 'amount_refunded', 'base_amount_refunded', 'row_total', 'base_row_total', 'row_invoiced', 'base_row_invoiced', 'row_weight', 'base_tax_before_discount', 'tax_before_discount', 'ext_order_item_id', 'locked_do_invoice', 'locked_do_ship', 'price_incl_tax', 'base_price_incl_tax', 'row_total_incl_tax', 'base_row_total_incl_tax', 'discount_tax_compensation_amount', 'base_discount_tax_compensation_amount', 'discount_tax_compensation_invoiced', 'base_discount_tax_compensation_invoiced', 'discount_tax_compensation_refunded', 'base_discount_tax_compensation_refunded', 'tax_canceled', 'discount_tax_compensation_canceled', 'tax_refunded', 'base_tax_refunded', 'discount_refunded', 'base_discount_refunded', 'gift_message_id', 'gift_message_available', 'free_shipping', 'weee_tax_applied', 'weee_tax_applied_amount', 'weee_tax_applied_row_amount', 'weee_tax_disposition', 'weee_tax_row_disposition', 'base_weee_tax_applied_amount', 'base_weee_tax_applied_row_amnt', 'base_weee_tax_disposition', 'base_weee_tax_row_disposition', 'shipping_fees', 'original_shipping_fees', 'shipped_by', 'collected_by_homzmart', 'collected_by_seller', 'installment_plan', 'homzmart_subsidy_price', 'seller_subsidy_price', 'homzmart_subsidy_price_difference', 'seller_subsidy_price_difference', 'isBundle', 'os_name', 'os_version', 'device_model', 'app_version', 'cat1', 'cat2', 'cat3', 'campaign_pages', 'product_material', 'Parent_SKU', 'Loginext_ref_id', 'bundle_discount_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'order_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function downloadableLinkPurchasedItems()
//    {
//        return $this->hasMany('App\DownloadableLinkPurchasedItem', 'order_item_id', 'item_id');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function salesOrderTaxItems()
//    {
//        return $this->hasMany('App\SalesOrderTaxItem', 'associated_item_id', 'item_id');
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function salesOrderTaxItems()
//    {
//        return $this->hasMany('App\SalesOrderTaxItem', 'item_id', 'item_id');
//    }
}
