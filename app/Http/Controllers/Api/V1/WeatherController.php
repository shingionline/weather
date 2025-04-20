<?php

namespace App\Http\Controllers\Api\V1;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class WeatherController extends Controller
{
    protected $api_key;
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = env('WEATHER_API_KEY');
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

    public function forecast(Request $request)
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

            $endpoint = 'https://api.openweathermap.org/data/2.5/forecast?q='.$city.'&APPID=' . $this->api_key;
            
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

    public function history(Request $request)
    {
        try {

            $longitude = $request->longitude ?? null;
            $latitude = $request->latitude ?? null;
            $datestring = $request->datestring ?? null;

            if (!$datestring || !$longitude || !$latitude) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide longitude, latitude, date and time'
                ]);
            }

            // convert datestring to timestamp eg: 2025-04-20T19:32
            $date = DateTime::createFromFormat('Y-m-d\TH:i', $datestring);
            if ($date) {
                $timestamp = $date->getTimestamp();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date format'
                ]);
            }

            $endpoint = 'https://api.openweathermap.org/data/3.0/onecall/timemachine?lat='.$latitude.'&lon='.$longitude.'&dt='.$timestamp.'&appid=' . $this->api_key;
            
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

    public function direct(Request $request)
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

            $endpoint = 'https://api.openweathermap.org/data/2.5/forecast?q='.$city.'&APPID=' . $this->api_key;
            
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
