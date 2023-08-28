<?php

namespace App\UseCase\CarUseCase;

use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DeleteCarUseCase
{
    public function __construct(protected Car $model)
    {

    }

    public function execute($id): void
    {
        $this->model->remove($id);
    }
}
