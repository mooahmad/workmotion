<?php

namespace App\Repositories\Main;
use App\Models\Main\SalesOrder;
use App\Domain\Repositories\Repository;

class SalesOrderRepository extends Repository
{
    protected $model;

    public function __construct(SalesOrder $model)
    {
        $this->model = $model;
    }
}
