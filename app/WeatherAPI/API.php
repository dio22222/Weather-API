<?php

    namespace WeatherAPI;

    enum Endpoint {

        case forecast;
        case weather;

    }

    class API extends Base {

        protected static $api_key;

        public function __construct()
        {
            $this->get_api_key();
        }

        private function get_api_key() {

            // Check if API KEY has already been obtained
            if(!empty($api_key)) {
                return;
            }

            $path = __DIR__.'/../../config/API_KEY.json';
            
            self::$api_key = file_get_contents($path);

            // Decode JSON key to an Associative Array & Destruct to a String
            ['API_KEY' => self::$api_key] = json_decode(self::$api_key, true);

        }

        protected function call_api(Endpoint $e, $parameters) {

            $base_url = 'api.openweathermap.org/data/2.5/';

            switch ($e) {

                case Endpoint::forecast:
                    $query = $base_url . 'forecast?&q=' . $parameters['city'] . '&' . 'cnt=' . $parameters['response_limit'];
                    break;

                case Endpoint::weather:
                    // Invoke Base Constructor to get PDO & Work with Database 
                    parent::__construct();
                    $query = $base_url . 'weather?&q=' . $parameters['city'];
                    break;

            }

            // Add API KEY to Query
            $query .= '&appid=' . self::$api_key;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                // Construct URL
                CURLOPT_URL => $query,
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

            $response['success'] = true;
            $response['code'] = 200;

            return $response;

        }

        // Helper Functions

        // Format Unix Time to Human-Readable Format, & optionally add a Unix Timezone Shift
        protected function convert_unix_to_datetime($unix_time, $timezone_shift = 0) {

            // Time zone shift & UTC time provided by the OpenWeatherMap API need to be subtracted by 7200 to be correct.
            $unix_time -= 7200;

            // If a timezone shift is provided, add the shift to UTC time to convert it to local time.
            if($timezone_shift != 0) $unix_time += $timezone_shift;

            return date("yy-m-d H:i:s", $unix_time);

        }

        // Format Unix Time to Human-Readable Date Format
        protected function convert_unix_to_date($unix_time) {

            // Time zone shift & UTC time provided by the OpenWeatherMap API need to be subtracted by 7200 to be correct.
            $unix_time -= 7200;

            return date("yy-m-d", $unix_time);

        }

        // Convert Temperature From Kelvin to Celcius & Fahrenheit
        protected function convert_kelvin($kelvin) {

            $celcius = $kelvin - 273.15;
            $fahrenheit = 1.8 * $celcius + 32;

            // Convert precision to 2 Decimal Numbers
            $celcius = floor($celcius*100)/100;
            $fahrenheit = floor($fahrenheit*100)/100;

            return [$celcius, $fahrenheit];
        }

    }

?>