<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class SiteController extends Controller
{
    protected $api_key;
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = env('WEATHER_API_KEY');
    }

    public function index()
    {
        $endpoint = 'https://api.openweathermap.org/data/2.5/weather?q=London,uk&APPID=' . $this->api_key;
        
        $response = $this->client->get($endpoint);
        $data = json_decode($response->getBody(), true);
        return $data;
    }
}
