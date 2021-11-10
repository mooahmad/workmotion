<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Deposit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ecom_deposit_subsidy';

    /**
     * @var array
     */
    protected $fillable = ['item_id', 'deposit', 'subsidy', 'status', 'item_comment', 'workshop_id', 'last_update_date', 'status_reason', 'dc_status', 'location_inside_dc', 'status_sub_reason'];

}
