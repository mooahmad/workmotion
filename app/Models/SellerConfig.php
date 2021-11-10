<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerConfig extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ecom_sellers_magento_config';

    /**
     * @var array
     */
    protected $fillable = ['name', 'active'];

}
