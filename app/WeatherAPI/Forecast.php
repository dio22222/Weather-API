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

    }

?>