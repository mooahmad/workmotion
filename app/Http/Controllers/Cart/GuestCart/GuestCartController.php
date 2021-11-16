<?php

namespace App\Http\Controllers\Cart\GuestCart;

use App\Http\Controllers\Controller;
use App\Repositories\Main\QuoteRepository;
use App\Servicess\GuestCart\GuestCartService;
use ClassPreloader\ClassLoader\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GuestCartController extends Controller
{

    protected $cartService;

    /* Create a new controller instance.
    *
    * @return void
    */
    public function __construct(GuestCartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createEmptyCart()
    {
        return $this->cartService->createGuestCart();
    }

}
