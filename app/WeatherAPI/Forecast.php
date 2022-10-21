<?php

    namespace WeatherAPI;

    class Forecast extends API{

        public function get_forecast($city, $response_limit = '9') {

            // Contstruct Parameters Array
            $parameters = array(
                'city' => $city,
                'response_limit' => $response_limit,
            );

            // Call OpenWeatherMap API
            $response = $this->call_api(Endpoint::forecast, $parameters);

            if (!$response['success']) {

                return $response;
                exit();

            }

            // Response Information
            $results['code'] = $response['cod'];
            $results['success'] = true;

            // For each item in the list of Time-stamped Forecasts returned
            foreach($response['list'] as $index => $forecast) {

                // Convert Time of Forecast from UTC to Local Time
                $local_time = $this->convert_unix_to_datetime($forecast['dt'], $response['city']['timezone']);

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
                
                // Construct Forecast Results Array
                $results['forecast_' . $index] = array( 
                    'datetime_utc' => $forecast['dt_txt'],
                    'datetime_local' => $local_time,
                    'weather_status' => $forecast['weather'][0]['main'],
                    'weather_description' => $forecast['weather'][0]['description'],
                    'main' => $forecast['main'],
                    'clouds' => $forecast['clouds'],
                    'wind' => $forecast['wind'],
                    'visibility' => $forecast['visibility'],
                );

            }

            // Location Information
            $results['sunset_utc'] = $this->convert_unix_to_datetime($response['city']['sunset']);
            $results['sunrise_utc'] = $this->convert_unix_to_datetime($response['city']['sunrise']);
            $results['sunset_local'] = $this->convert_unix_to_datetime($response['city']['sunset'], $response['city']['timezone']);
            $results['sunrise_local'] = $this->convert_unix_to_datetime($response['city']['sunrise'], $response['city']['timezone']);

            return $results;

        }

        // Format Unix Time to Human-Readable Format, & optionally add a Unix Timezone Shift
        private function convert_unix_to_datetime($unix_time, $timezone_shift = 0) {

            // Time zone shift & UTC time provided by the OpenWeatherMap API need to be subtracted by 7200 to be correct.
            $unix_time -= 7200;

            // If a timezone shift is provided, add the shift to UTC time to convert it to local time.
            if($timezone_shift != 0) $unix_time += $timezone_shift;

            // return date("d/m/y H:i:s", $unix_time);
            return date("yy-m-d H:i:s", $unix_time);

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