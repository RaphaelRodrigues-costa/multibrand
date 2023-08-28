<?php

namespace App\UseCase\CarUseCase;

use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class ShowCarUseCase
{
    public function __construct(protected Car $model)
    {

    }

    public function execute($param)
    {
        return $this->model->findByName($param);
    }
}
