<?php

namespace App\Models;

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

    public function create($params): int
    {
        return $this->query()->upsert(
            $params,
            [
                'link',
                'kilometers',
                'color',
            ],
            [
                'car_name',
                'link',
                'link_image',
                'year',
                'fuel',
                'doors',
                'kilometers',
                'gearbox',
                'color',
                'price',
            ]
        );
    }

    public function findByName($param)
    {
        return $this->where('car_name', 'like', '%' . $param . '%')->get();
    }
}
