<?php

namespace App\Repositories\Main;
use App\Models\Main\Quote;
use App\Domain\Repositories\Repository;

class QuoteRepository extends Repository
{
    protected $model;

    public function __construct(Quote $model)
    {
        $this->model = $model;
    }
}
