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

        $html = file_get_contents( $this->baseUrl . $brand);

        $pattern = '/<div class="card card-car">(.*?)<a href="(.*?)" title="(.*?)">(.*?)<\/div>/s';

        preg_match_all(pattern: $pattern, subject: $html, matches: $matches);

        $linkToTheVehicle = $matches[2];

        if (blank($linkToTheVehicle)) {
            return null;
        }

        $data = [];

        foreach ($linkToTheVehicle as $link) {
            $html = file_get_contents($link);
            preg_match_all(pattern: $this->linkImage, subject: $html, matches: $linkImages);
            preg_match_all(pattern: $this->name, subject: $html, matches: $carName);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $year);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $fuel);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $doors);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $kilometers);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $gearbox);
            preg_match_all(pattern: $this->fetchParagraphs, subject: $html, matches: $color);
            preg_match_all(pattern: $this->price, subject: $html, matches: $price);

            $data[] = [
                'user_id' => Auth::id(),
                'link_image' => $linkImages[3][0] ?? null,
                'car_name' => Str::lower($this->findNameCar($carName)) ?? null,
                'link' => $link ?? null,
                'year' => trim($year[2][1]) ?? null,
                'fuel' => $this->getFoul($fuel) ?? null,
                'doors' => $this->numberDoors($this->findNameCar($carName)) ?? null,
                'kilometers' => trim($kilometers[2][2]) ?? null,
                'gearbox' => trim($gearbox[2][0]) ?? null,
                'color' => trim($color[2][3]) ?? null,
                'price' => $this->findPrice($price) ?? null,
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

    protected function getFoul(array $items): ?string
    {
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
