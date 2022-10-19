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
            foreach($response['list'] as $index => $forecast) {

                // Convert Temperature Parameter
                [$celcius, $fahrenheit] = $this->convert_kelvin($forecast['main']['temp']);

                // Pass Converted Data as Extra Parameters
                $forecast['main']['temp'] = array(

                    'kelvin' => $forecast['main']['temp'],
                    'celcius' => $celcius,
                    'fahrenheit' => $fahrenheit,

                );

                // Convert Feels Like Parameter
                [$celcius, $fahrenheit] = $this->convert_kelvin($forecast['main']['feels_like']);

                // Pass Converted Data as Extra Parameters
                $forecast['main']['feels_like'] = array(

                    'kelvin' => $forecast['main']['feels_like'],
                    'celcius' => $celcius,
                    'fahrenheit' => $fahrenheit,

                );

                // Convert Minimum Temperature Parameter
                [$celcius, $fahrenheit] = $this->convert_kelvin($forecast['main']['temp_min']);

                // Pass Converted Data as Extra Parameters
                $forecast['main']['temp_min'] = array(

                    'kelvin' => $forecast['main']['temp_min'],
                    'celcius' => $celcius,
                    'fahrenheit' => $fahrenheit,

                );
                
                // Convert Maximum Temperature Parameter
                [$celcius, $fahrenheit] = $this->convert_kelvin($forecast['main']['temp_max']);

                // Pass Converted Data as Extra Parameters
                $forecast['main']['temp_max'] = array(

                    'kelvin' => $forecast['main']['temp_max'],
                    'celcius' => $celcius,
                    'fahrenheit' => $fahrenheit,

                );
                
                $results['forecast_' . $index] = array( 
                    'datetime' => $forecast['dt_txt'],
                    'weather_status' => $forecast['weather'][0]['main'],
                    'weather_description' => $forecast['weather'][0]['description'],
                    'main' => $forecast['main'],
                    'clouds' => $forecast['clouds'],
                    'wind' => $forecast['wind'],
                    'visibility' => $forecast['visibility'],
                );

            }

            // Location Information
            $results['sunset'] = $this->convert_unix_to_datetime($response['city']['sunset'], $response['city']['timezone']);
            $results['sunrise'] = $this->convert_unix_to_datetime($response['city']['sunrise'], $response['city']['timezone']);

            return $results;

        }

        // Format Unix Time to Human-Readable Format, & optionally add a Unix Timezone Shift
        private function convert_unix_to_datetime($unix_time, $timezone_shift = 0) {

            $unix_time += $timezone_shift - 7200;

            return date("d/m/y H:i:s", $unix_time);

        }

        // Convert Temperature From Kelvin to Celcius & Fahrenheit
        private function convert_kelvin($kelvin) {

            $celcius = $kelvin - 273.15;
            $fahrenheit = 1.8 * $celcius + 32;

            // Convert precision to 2 Decimal Numbers
            $celcius = floor($celcius*100)/100;
            $fahrenheit = floor($fahrenheit*100)/100;

            return [$celcius, $fahrenheit];
        }

    }

?>