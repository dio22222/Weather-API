<?php

    namespace WeatherAPI;

    class Forecast {

        private static $base_url = 'api.openweathermap.org/data/2.5/forecast?';

        private static $api_key;

        private static $response_limit = '1';

        public function __construct()
        {
            $this->get_api_key();
        }

        private function get_api_key() {

            $path = __DIR__.'/../../config/API_KEY.json';
            
            self::$api_key = file_get_contents($path);

            // Decode JSON key to an Associative Array & Destruct to a String
            ['API_KEY' => self::$api_key] = json_decode(self::$api_key, true);

        }

        public function get_forecast($city) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                // Construct URL
                CURLOPT_URL => self::$base_url . "q=" . $city . '&' . "cnt=" . self::$response_limit . "&" . "appid=" . self::$api_key,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "connection: keep-alive",
                    "accept: application/json",
                ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);

            curl_close($curl);

            // Decode JSON Responses to Associative Arrays
            $response = json_decode($response, true);
            $error = json_decode($error, true);

            if ($response['cod'] == '404') {

                $results['code'] = 404;
                $results['success'] = false;
                $results['message'] = $response['message'];

                return $results;

                exit();

            }

            $results['code'] = $response['cod'];
            $results['success'] = true;
            $results['forecast_weather_status'] = $response['list'][0]['weather'][0]['main'];
            $results['forecast_weather_description'] = $response['list'][0]['weather'][0]['description'];
            $results['forecast_main'] = $response['list'][0]['main'];
            $results['forecast_clouds'] = $response['list'][0]['clouds'];
            $results['forecast_wind'] = $response['list'][0]['wind'];
            $results['forecast_visibility'] = $response['list'][0]['visibility'];

            return $results;

            var_dump($response,$error);

        }

    }

?>