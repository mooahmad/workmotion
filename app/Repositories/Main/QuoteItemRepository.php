<?php

namespace App\Repositories\Main;
use App\Models\Main\QuoteItem;
use App\Domain\Repositories\Repository;

class QuoteItemRepository extends Repository
{
    protected $model;

    public function __construct(QuoteItem $model)
    {
        $this->model = $model;
    }
}
