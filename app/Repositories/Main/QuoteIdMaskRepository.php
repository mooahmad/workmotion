<?php

namespace App\Repositories\Main;
use App\Models\Main\QuoteIdMask;
use App\Domain\Repositories\Repository;
use App\Utilities\Random;

class QuoteIdMaskRepository extends Repository
{
    protected $model;

    public function __construct(QuoteIdMask $model)
    {
        $this->model = $model;
    }

//    public function createGuestCart(){
//      //  return $this->model->firstOrCreate(['masked_id'=>(new Random)->getUniqueHash()]);
//    }
}
