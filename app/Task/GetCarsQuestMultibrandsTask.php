<?php

namespace App\Task;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GetCarsQuestMultibrandsTask
{
    protected string $baseUrl;
    protected string $name;
    protected string $linkImage;
    protected string $price;
    protected string $fetchParagraphs;

    public function __construct()
    {
        $this->baseUrl = 'https://www.questmultimarcas.com.br/estoque?termo=';

        $this->name = '/<div class="title">(.*?)<h2>(.*?)<span class="fw-normal">(.*?)<\/span>(.*?)<\/h2>(.*?)<h3>(.*?)<\/h3>(.*?)<\/div>/s';
        $this->linkImage = '/<div class="main-img">(.*?)<img(.*?) src="(.*?)"(.*?)>(.*?)<\/div>/s';
        $this->fetchParagraphs = '/<div class="col-6 col-md-4 d-flex align-items-stretch tech-specs-item">(.*?)<p>(.*?)<\/p>(.*?)<\/div>/s';
        $this->price = '/<div class="col-md-auto col-12 price">(.*?)<strong>(.*?)<span class="fs-6 price-solo">(.*?)<\/span>(.*?)<\/strong>(.*?)<\/div>/s';
    }

    public function execute($parameter): ?array
    {
        $brand = Str::lower($parameter);

        $pattern = '/<div class="card card-car">(.*?)<a href="(.*?)" title="(.*?)">(.*?)<\/div>/s';

        $matches = $this->getContent(url: $this->baseUrl . $brand, pattern: $pattern);

        $linkToTheVehicle = $matches[2];

        if (blank($linkToTheVehicle)) {
           return null;
        }

        $data = [];
        foreach ($linkToTheVehicle as $link) {
            $data[] = [
                'user_id' => Auth::id(),
                'link_image' => $this->getContent(url: $link, pattern: $this->linkImage)[3][0] ?? null,
                'car_name' => Str::lower($this->findNameCar($this->getContent(url: $link, pattern: $this->name))) ?? null,
                'link' => $link ?? null,
                'year' => trim($this->getContent(url: $link, pattern: $this->fetchParagraphs)[2][1]) ?? null,
                'fuel' => $this->getFoul(link: $link) ?? null,
                'doors' => $this->numberDoors($this->findNameCar($this->getContent(url: $link, pattern: $this->name))) ?? null,
                'kilometers' => trim($this->getContent(url: $link, pattern: $this->fetchParagraphs)[2][2]) ?? null,
                'gearbox' => trim($this->getContent(url: $link, pattern: $this->fetchParagraphs)[2][0]) ?? null,
                'color' => trim($this->getContent(url: $link, pattern: $this->fetchParagraphs)[2][3]) ?? null,
                'price' => $this->findPrice($this->getContent(url: $link, pattern: $this->price)) ?? null,
            ];
        }

        return $data;
    }

    public function getContent(string $url, $pattern): array
    {

        $html = file_get_contents($url);

        preg_match_all($pattern, $html, $matches);

        return $matches;
    }

    protected function findNameCar(array $carName): string
    {
        $carName = array_merge($carName[3], $carName[4], $carName[6]);

        return $carName[0] . $carName[1] . $carName[2];
    }

    protected function findPrice(array $price): string
    {
        $price = array_merge($price[3], $price[4]);

        return $price[0] . $price[1];
    }

    protected function getFoul(string $link): ?string
    {
        $items = $this->getContent(url: $link, pattern: $this->fetchParagraphs);

        $foul = [];

        foreach ($items[2] as $item) {
            $foul[] = $item;
        }

        if (count($foul) <= 4) {
            return null;
        }

        return match (true) {
            str_contains(trim($foul[4]), 'Flex') => 'Flex',
            str_contains(trim($foul[4]), 'Gasolina') => 'Gasolina',
            default => null,
        };
    }

    protected function numberDoors(string $doors): string
    {
        return match (true) {
            str_contains($doors, '4p') => '4 portas',
            str_contains($doors, '5p') => '5 portas',
            default => '',
        };
    }
}
