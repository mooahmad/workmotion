<?php

/**
 * Omar Hendawy
*Homzmart Magento Integration.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main\Quote;

/**
 * Class QuotePayment
 */
class QuotePayment extends Model
{
	protected $table = 'quote_payment';
	protected $primaryKey = 'payment_id';

	protected $casts = [
		'quote_id' => 'int',
		'cc_exp_year' => 'int',
		'cc_ss_start_month' => 'int',
		'cc_ss_start_year' => 'int'
	];

	protected $fillable = [
		'quote_id',
		'method',
		'cc_type',
		'cc_number_enc',
		'cc_last_4',
		'cc_cid_enc',
		'cc_owner',
		'cc_exp_month',
		'cc_exp_year',
		'cc_ss_owner',
		'cc_ss_start_month',
		'cc_ss_start_year',
		'po_number',
		'additional_data',
		'cc_ss_issue',
		'additional_information',
		'paypal_payer_id',
		'paypal_payer_status',
		'paypal_correlation_id'
	];

	public function quote()
	{
		return $this->belongsTo(Quote::class,'quote_id');
	}
}
