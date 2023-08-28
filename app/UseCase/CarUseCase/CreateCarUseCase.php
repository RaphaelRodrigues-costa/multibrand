<?php

namespace App\UseCase\CarUseCase;

use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CreateCarUseCase
{
    public function __construct(protected Car $model)
    {

    }

    public function execute(array $params): int
    {

        return $this->model->create($params);
    }
}
