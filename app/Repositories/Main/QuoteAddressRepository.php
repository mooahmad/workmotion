<?php

namespace App\Repositories\Main;
use App\Models\Main\QuoteAddress;
use App\Domain\Repositories\Repository;

class QuoteAddressRepository extends Repository
{
    protected $model;

    public function __construct(QuoteAddress $model)
    {
        $this->model = $model;
    }
}
