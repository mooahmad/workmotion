<?php

namespace App\Repositories\Main;
use App\Models\Main\CustomerEntity;
use App\Domain\Repositories\Repository;

class CustomerEntityRepository extends Repository
{
    protected $model;

    public function __construct(CustomerEntity $model)
    {
        $this->model = $model;
    }
}
