<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class TestController extends Controller
{
    public function test(): void
    {
       dd('TestController');
    }
}
