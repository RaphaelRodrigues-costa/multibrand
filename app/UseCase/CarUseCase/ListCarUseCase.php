<?php

namespace App\UseCase\CarUseCase;

use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListCarUseCase
{
    public function __construct(protected Car $model)
    {

    }

    public function execute(?string $name): LengthAwarePaginator
    {
        return $this->model->paginate($name);
    }
}
