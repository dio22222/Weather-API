<?php

    namespace WeatherAPI;

    class DataCollector extends API {

        public function get_weather_data($city) {

            // Contstruct Parameters Array
            $parameters = array(

                'city' => $city,

            );

            // Call OpenWeatherMap API
            $response = $this->call_api(Endpoint::weather, $parameters);

            if (!$response['success']) {

                // Construct Resposnse to Log
                $results['date'] = date('yy-m-d');
                $results['city'] = strtolower($city);
                $results['message'] = $response['message'];

                return $results;
                
                exit();

            }

            // Convert Temperature Parameter
            [$celcius, $fahrenheit] = $this->convert_kelvin($response['main']['temp']);

            // Pass Converted Data as Extra Parameters
            $response['main']['temp'] = array(

                'kelvin' => $response['main']['temp'],
                'celcius' => $celcius,
                'fahrenheit' => $fahrenheit,

            );

            // Convert Feels Like Parameter
            [$celcius, $fahrenheit] = $this->convert_kelvin($response['main']['feels_like']);

            // Pass Converted Data as Extra Parameters
            $response['main']['feels_like'] = array(

                'kelvin' => $response['main']['feels_like'],
                'celcius' => $celcius,
                'fahrenheit' => $fahrenheit,

            );

            // Convert Minimum Temperature Parameter
            [$celcius, $fahrenheit] = $this->convert_kelvin($response['main']['temp_min']);

            // Pass Converted Data as Extra Parameters
            $response['main']['temp_min'] = array(

                'kelvin' => $response['main']['temp_min'],
                'celcius' => $celcius,
                'fahrenheit' => $fahrenheit,

            );
            
            // Convert Maximum Temperature Parameter
            [$celcius, $fahrenheit] = $this->convert_kelvin($response['main']['temp_max']);

            // Pass Converted Data as Extra Parameters
            $response['main']['temp_max'] = array(

                'kelvin' => $response['main']['temp_max'],
                'celcius' => $celcius,
                'fahrenheit' => $fahrenheit,

            );

            // Construct Results Array to Be saved in the Database
            $parameters = array(

                'city_name_given' => $city,
                'official_city_name' => $response['name'],
                'date' => $this->convert_unix_to_date($response['dt']),
                'temp_kelvin' => $response['main']['temp']['kelvin'],
                'temp_celcius' => $response['main']['temp']['celcius'],
                'temp_fahrenheit' => $response['main']['temp']['fahrenheit'],
                'feels_like_kelvin' => $response['main']['feels_like']['kelvin'],
                'feels_like_celcius' => $response['main']['feels_like']['celcius'],
                'feels_like_fahrenheit' => $response['main']['feels_like']['fahrenheit'],
                'temp_min_kelvin' => $response['main']['temp_min']['kelvin'],
                'temp_min_celcius' => $response['main']['temp_min']['celcius'],
                'temp_min_fahrenheit' => $response['main']['temp_min']['fahrenheit'],
                'temp_max_kelvin' => $response['main']['temp_max']['kelvin'],
                'temp_max_celcius' => $response['main']['temp_max']['celcius'],
                'temp_max_fahrenheit' => $response['main']['temp_max']['fahrenheit'],
                'pressure' => $response['main']['pressure'],
                'humidity' => $response['main']['humidity'],
                'visibility' => $response['visibility'],
                'wind_speed' => $response['wind']['speed'],
                'wind_deg' => $response['wind']['deg'],
                'clouds' => $response['clouds']['all'],

            );

            // Insert Data into Database
            $success = $this->insert('forecast', $parameters);

            // Construct Resposnse to Log
            $results['date'] = $parameters['date'];
            $results['city'] = strtolower($city);

            $success ? $results['message'] = 'Data were Saved Successufuly' : $results['message'] = 'There was an Error with the Database';

            return $results;

        }

    }

?>