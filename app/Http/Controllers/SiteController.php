<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        return view('pages.home', compact('user'));
    }

    public function weather(Request $request)
    {
        try {

            $city = $request->city ?? null;
            $longitude = $request->longitude ?? null;
            $latitude = $request->latitude ?? null;

            if (!$city && !$longitude && !$latitude) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide a city or coordinates'
                ]);
            }

            $endpoint = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&APPID=' . $this->api_key;
            
            $response = $this->client->get($endpoint);
            $data = json_decode($response->getBody(), true);
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ]);
        }
    }
}
