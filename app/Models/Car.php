<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $string, string $string1, string $string2)
 */
class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $casts = [
        'id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_id' => 'int',
        'car_name' => 'string',
        'link' => 'string',
        'link_image' => 'string',
        'year' => 'string',
        'fuel' => 'string',
        'doors' => 'string',
        'kilometers' => 'string',
        'gearbox' => 'string',
        'color' => 'string',
        'price' => 'string',
    ];

    protected $guarded = [];

    /**
     * @param $id
     * @return void
     */
    public function remove($id): void
    {
        $this->query()->where('id', $id)->delete();
    }

    public function createOrUpdate($params): void
    {
        $links = array_map(fn($item) => $item['link'], $params);
        $existOneCarWithLink = $this->newQuery()->whereIn('link', $links)->get();

        $existOneCarWithLink->each(function (Car $item) use ($params) {
            $car = collect($params)->first(function ($value) use ($item) {
                return $value['link'] === $item['link'];
            });
            $item->update($car);
        });

        $cars = collect($params)->filter(function ($value) use ($existOneCarWithLink) {

            return $existOneCarWithLink->whereIn('link', $value['link'])->isEmpty();
        })->values()->toArray();

        if (!blank($cars)) {
            $this->newQuery()->insert($cars);
        }
    }

    public function findByName($param)
    {
        return $this->where('car_name', 'like', '%' . $param . '%')->get();
    }

    public function paginate(?string $name): LengthAwarePaginator
    {
        $queryPaginate = $this->newQuery();

        if (!blank($name)) {
            $queryPaginate->where('car_name', 'like', '%' . $name . '%');
        }

        return $queryPaginate->paginate();
    }
}
