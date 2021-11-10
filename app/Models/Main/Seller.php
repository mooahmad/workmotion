<?php

namespace App\Models\Main;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ecom_sellers_magento';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name_en', 'name_ar', 'phone_number', 'email', 'password', 'commission', 'active', 'seller_image', 'shipping', 'seller_owner', 'offline_reason'];

}
