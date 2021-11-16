<?php


namespace App\Servicess\GuestCart;


use App\Models\Main\Quote;
use App\Repositories\Main\QuoteIdMaskRepository;
use App\Repositories\Main\QuoteRepository;
use App\Utilities\Random;
use Illuminate\Support\Facades\App;

class GuestCartService
{
    protected $quoteRepository;
    protected $idMaskRepository;

    public function __construct(QuoteRepository $quoteRepository, QuoteIdMaskRepository $idMaskRepository)
    {
        $this->quoteRepository = $quoteRepository;
        $this->idMaskRepository = $idMaskRepository;
    }

    public function createGuestCart()
    {

        $newMaskId = (new Random)->getUniqueHash();
        $store = config('app.store')[App::getLocale()];
        $guestCart = $this->quoteRepository->create(['store_id'=>$store,'customer_is_guest'=>1]);
        $guestCart->quote_addresses()->createMany([
            ['address_type'=>'billing'],
            ['address_type'=>'shipping']
        ]);
        $shipping = $guestCart->getQuote_shipping_addresses();
        try {
            $shipping->collect_shipping_rates = true;
            $shipping->save();
        } catch (\Exception $e) {
            return response('The quote can\'t be created');
        }
        $idMaskObject = $this->idMaskRepository->create(['quote_id'=> $guestCart->entity_id ,'masked_id'=>$newMaskId]);
        return response($idMaskObject->masked_id);
    }
}
