<?php

    namespace WeatherAPI;

    class Forecast {

        private static $base_url = 'api.openweathermap.org/data/2.5/forecast?';

        private static $api_key;

        private static $response_limit = '2';

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

            // Decode JSON Response to Associative Array
            $response = json_decode($response, true);

            // If there was an error in the Request
            if ($error != "") {

                // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/502
                $results['code'] = 502;

                $results['success'] = false;
                $results['message'] = $error;

                return $results;

                exit();

            }

            // If the recourse was not found
            if ($response['cod'] == '404') {

                $results['code'] = 404;
                $results['success'] = false;
                $results['message'] = $response['message'];

                return $results;

                exit();

            }

            // Response Information
            $results['code'] = $response['cod'];
            $results['success'] = true;

            // For each item in the list of Time-stamped Forecasts returned
            foreach($response['list'] as $index => $timestamp) {
                
                $results['timestamp_' . $index] = array( 
                    'datetime' => $timestamp['dt_txt'],
                    'forecast_weather_status' => $timestamp['weather'][0]['main'],
                    'forecast_weather_description' => $timestamp['weather'][0]['description'],
                    'forecast_main' => $timestamp['main'],
                    'forecast_clouds' => $timestamp['clouds'],
                    'forecast_wind' => $timestamp['wind'],
                    'forecast_visibility' => $timestamp['visibility'],
                );

            }

            // Location Information
            $results['sunset'] = $this->convert_unix_to_datetime($response['city']['sunset'], $response['city']['timezone']);
            $results['sunrise'] = $this->convert_unix_to_datetime($response['city']['sunrise'], $response['city']['timezone']);

            return $results;

            var_dump($response,$error);

        }

        // Format Unix Time to Human-Readable Format, & optionally add a Unix Timezone Shift
        private function convert_unix_to_datetime($unix_time, $timezone_shift = 0) {

            $unix_time += $timezone_shift; 

            return date("d/m/y H:i:s", $unix_time);

        }

    }

?>