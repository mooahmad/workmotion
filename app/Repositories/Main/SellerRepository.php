<?php

namespace App\Repositories\Main;
use App\Models\Main\Seller;
use App\Domain\Repositories\Repository;

class SellerRepository extends Repository
{
    protected $model;

    public function __construct(Seller $model)
    {
        $this->model = $model;
    }
}
