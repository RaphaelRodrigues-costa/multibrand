<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Task\GetCarsQuestMultibrandsTask;
use App\UseCase\CarUseCase\CreateCarUseCase;
use App\UseCase\CarUseCase\DeleteCarUseCase;
use App\UseCase\CarUseCase\ListCarUseCase;
use App\UseCase\CarUseCase\ShowCarUseCase;
use App\ValueObjects\Car\ListAllCarsVO;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected function parameters(Car $car): ListAllCarsVO
    {
        $carsListVo = new ListAllCarsVO();

        $carsListVo->id = $car->getAttributes()['id'];
        $carsListVo->carName = $car->getAttributes()['car_name'];
        $carsListVo->link = $car->getAttributes()['link'];
        $carsListVo->linkImage = $car->getAttributes()['link_image'];
        $carsListVo->year = $car->getAttributes()['year'];
        $carsListVo->fuel = $car->getAttributes()['fuel'];
        $carsListVo->doors = $car->getAttributes()['doors'];
        $carsListVo->kilometers = $car->getAttributes()['kilometers'];
        $carsListVo->gearbox = $car->getAttributes()['gearbox'];
        $carsListVo->color = $car->getAttributes()['color'];
        $carsListVo->price = $car->getAttributes()['price'];

        return $carsListVo;
    }

    public function index(ListCarUseCase $useCase): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cars = $useCase->execute();

        $data = [];

        foreach ($cars->items() as $car) {
            $data[] = $this->parameters($car);
        }

        return view('list-cars', ['cars' => $data]);
    }

    public function findByName(Request $request, ShowCarUseCase $useCase): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'brand' => 'string|required|regex:/^[^0-9]*$/'
        ], [
            'brand.string' => 'O campo nome deve ser uma string.',
            'brand.regex' => 'O campo nome não deve conter números.',
        ]);

        $cars = $useCase->execute($request->input('brand'));

        $data = [];

        foreach ($cars->all() as $car) {
            $data[] = $this->parameters($car);
        }

        return view('list-cars', ['cars' => $data]);
    }

    public function store(Request $request, CreateCarUseCase $useCase): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $request->validate([
            'brand' => 'string|required|regex:/^[^0-9]*$/'
        ], [
            'brand.string' => 'O campo nome deve ser uma string.',
            'brand.regex' => 'O campo nome não deve conter números.',
        ]);

        $brand = $request->input('brand');

        $cars = app(GetCarsQuestMultibrandsTask::class)->execute($brand);

        if (blank($cars)) {
            return view('dashboard')->with('error', 'Item não encontrado');
        }

        $useCase->execute($cars);

        return redirect()->route('cars-list');
    }

    protected function destroy(int $id, DeleteCarUseCase $useCase): RedirectResponse
    {
        $useCase->execute($id);
        return redirect()->route('cars-list');
    }
}
