<?php

namespace App\Repositories\Main;
use App\Models\Main\SalesOrderItem;
use App\Domain\Repositories\Repository;

class SalesOrderItemRepository extends Repository
{
    protected $model;

    public function __construct(SalesOrderItem $model)
    {
        $this->model = $model;
    }
}
