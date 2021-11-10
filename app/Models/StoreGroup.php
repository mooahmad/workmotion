<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreGroup
 */
class StoreGroup extends Model
{
	protected $table = 'store_group';
	protected $primaryKey = 'group_id';
	public $timestamps = false;

	protected $casts = [
		'website_id' => 'int',
		'root_category_id' => 'int',
		'default_store_id' => 'int'
	];

	protected $fillable = [
		'website_id',
		'name',
		'root_category_id',
		'default_store_id',
		'code'
	];

	public function store_website()
	{
		return $this->belongsTo(StoreWebsite::class, 'website_id');
	}

	public function stores()
	{
		return $this->hasMany(Store::class, 'group_id');
	}
}
