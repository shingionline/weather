<?php

namespace App\Http\Controllers\Api\V1;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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

            $cacheKey = 'weather_' . md5($endpoint);

            $dataObject = $this->getDataFromCache($endpoint, $cacheKey);
            
            return response()->json([
                'success' => true,
                'source' => $dataObject->source,
                'data' => $dataObject->data,
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
            
            $cacheKey = 'forecast_' . md5($endpoint);

            $dataObject = $this->getDataFromCache($endpoint, $cacheKey);
            
            return response()->json([
                'success' => true,
                'source' => $dataObject->source,
                'data' => $dataObject->data
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
            
            $cacheKey = 'history_' . md5($endpoint);

            $dataObject = $this->getDataFromCache($endpoint, $cacheKey);
            
            return response()->json([
                'success' => true,
                'source' => $dataObject->source,
                'data' => $dataObject->data,
            ]);

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ]);
        }
    }

    public function search(Request $request)
    {
        try {

            $searchTerm = $request->searchTerm ?? null;
            $limit = 5;

            if (!$searchTerm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a search term'
                ]);
            }

            $endpoint = 'https://api.openweathermap.org/geo/1.0/direct?q='.$searchTerm.'&limit='.$limit.'&appid=' . $this->api_key;
            
            $cacheKey = 'search_' . md5($endpoint);

            $dataObject = $this->getDataFromCache($endpoint, $cacheKey);
            
            return response()->json([
                'success' => true,
                'source' => $dataObject->source,
                'data' => $dataObject->data,
            ]);

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ]);
        }
    }

    public function getDataFromCache($endpoint, $cacheKey)
    {
        // Check if data is cached
        if (Cache::has($cacheKey)) {
            $dataArray = ['data' => Cache::get($cacheKey), 'source' => 'cache'];
            return json_decode(json_encode($dataArray));
        }

        // If not cached, make the API request
        $response = $this->client->get($endpoint);
        $data = json_decode($response->getBody(), true);

        // Cache the data for 1 hour
        Cache::put($cacheKey, $data, 3600);

        $dataArray = ['data' => $data, 'source' => 'api'];
        return json_decode(json_encode($dataArray));
    }
}
