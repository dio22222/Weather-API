<?php

    namespace WeatherAPI;

    enum Endpoint {

        case forecast;
        case weather;

    }

    class API {

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

        protected function call_api(Endpoint $e, $city, $response_limit) {

            $base_url = 'api.openweathermap.org/data/2.5/forecast?';

            $query = $base_url . 'appid=' . self::$api_key;

            switch ($e) {

                case Endpoint::forecast:
                    $query .= '&q=' . $city . '&' . 'cnt=' . $response_limit;
                    break;

                case Endpoint::weather:
                    $query .= '&q=' . $city;

            }

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

    }

?>