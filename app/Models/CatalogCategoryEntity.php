<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogCategoryEntity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_category_entity';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'entity_id';

    /**
     * @var array
     */
    protected $fillable = ['attribute_set_id', 'parent_id', 'created_at', 'updated_at', 'path', 'position', 'level', 'children_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryEntityDatetimes()
    {
        return $this->hasMany(CatalogCategoryEntityDatetime::class, 'entity_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryEntityDecimals()
    {
        return $this->hasMany(CatalogCategoryEntityDecimal::class, 'entity_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryEntityInts()
    {
        return $this->hasMany(CatalogCategoryEntityInt::class, 'entity_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryEntityTexts()
    {
        return $this->hasMany(CatalogCategoryEntityText::class, 'entity_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryEntityVarchars()
    {
        return $this->hasMany(CatalogCategoryEntityVarchar::class, 'entity_id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogCategoryProducts()
    {
        return $this->hasMany(CatalogCategoryProduct::class, 'category_id', 'entity_id');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function catalogUrlRewriteProductCategories()
//    {
//        return $this->hasMany(CatalogUrlRewriteProductCategory::class, 'category_id', 'entity_id');
//    }
}
