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

                return $response;
                
                exit();

            }

            return $response;

        }

    }

?>