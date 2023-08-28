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
        $car = $car->toArray();

        $carsListVo = new ListAllCarsVO();

        $carsListVo->id = $car['id'];
        $carsListVo->carName = $car['car_name'];
        $carsListVo->link = $car['link'];
        $carsListVo->linkImage = $car['link_image'];
        $carsListVo->year = $car['year'];
        $carsListVo->fuel = $car['fuel'];
        $carsListVo->doors = $car['doors'];
        $carsListVo->kilometers = $car['kilometers'];
        $carsListVo->gearbox = $car['gearbox'];
        $carsListVo->color = $car['color'];
        $carsListVo->price = $car['price'];

        return $carsListVo;
    }

    public function index(Request $request, ListCarUseCase $useCase): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cars = $useCase->execute($request->get('name'));

        $data = [];

        foreach ($cars->items() as $car) {
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

        $cars = app(GetCarsQuestMultibrandsTask::class)->execute($request->input('brand'));

        if (blank($cars)) {
            return view('dashboard')->with('error', 'A marca: ' . $request->input('brand') . ' que você procura não foi encontrada');
        }

        $useCase->execute($cars);

        return redirect()->route('cars.index');
    }

    protected function destroy(int $id, DeleteCarUseCase $useCase): RedirectResponse
    {
        $useCase->execute($id);
        return redirect()->route('cars.index');
    }
}
