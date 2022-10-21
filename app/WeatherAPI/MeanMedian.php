<?php 

namespace WeatherAPI;

use DateTime;

class MeanMedian extends Base {

    // Calculates the Mean & Median Temperature for the past 10 days given a City Name
    public function calculate_mean_median($city) {

        $_10_days_ago = new DateTime('10 days ago');

        $parameters = [
            ':city' => $city,
            ':current_date' => date("Y-m-d"),
            ':10_days_ago' => $_10_days_ago->format('Y-m-d'),
        ];

        // Construct SQL Query
        $query = 'SELECT temp_kelvin, temp_celcius, temp_fahrenheit 
                  FROM forecast 
                  WHERE (city_name_given = :city OR official_city_name = :city) 
                  AND date
                  BETWEEN :10_days_ago AND :current_date';

        $temperatures = $this->fetchALL($query, $parameters);

        $number_of_results = count($temperatures);

        if ($number_of_results < 2) {

            $response['code'] = 404;
            $response['success'] = false;
            $response['message'] = 'Not enough Data found for that particular City to calculate Mean & Median Temperature Values';
            
            return $response;

        }

        $response['code'] = 200;
        $response['success'] = true;

        // Calculate Mean Temperature
        $sum_kelvin = 0;
        $sum_celcius = 0;
        $sum_fahrenheit = 0;

        for ($i = 0; $i < $number_of_results; $i++) {

            $sum_kelvin += $temperatures[$i]['temp_kelvin'];
            $sum_celcius += $temperatures[$i]['temp_celcius'];
            $sum_fahrenheit += $temperatures[$i]['temp_fahrenheit'];

        }

        $response['mean_kelvin'] = $sum_kelvin / $number_of_results;
        $response['mean_celcius'] = $sum_celcius / $number_of_results;
        $response['mean_fahrenheit'] = $sum_fahrenheit / $number_of_results;

        // Calculate Median Temperature
        $results_kelvin = [];
        $results_celcius = [];
        $results_fahrenheit = [];

        foreach ($temperatures as $temperature) {

            array_push($results_kelvin, $temperature['temp_kelvin']);
            array_push($results_celcius, $temperature['temp_celcius']);
            array_push($results_fahrenheit, $temperature['temp_fahrenheit']);

        }

        sort($results_kelvin);
        sort($results_celcius);
        sort($results_fahrenheit);

        // Check if the number of observations is odd or even
        if (!$this->even($number_of_results)) {
            
            // Median Formula when the number is odd: ((n+1)/2)th Number in Sorted List (Ascending)
            $response['median_kelvin'] = $results_kelvin[($number_of_results + 1) / 2];
            $response['median_celcius'] = $results_celcius[($number_of_results + 1) / 2];
            $response['median_fahrenheit'] = $results_fahrenheit[($number_of_results + 1) / 2];

        } else {
            
            // Median Formula when the number is even: average of ((n+1)/2)th Number in Sorted List (Ascending) + Next Number
            $kelvin_even = $results_kelvin[intval(($number_of_results + 1) / 2)];
            $response['median_kelvin'] = $kelvin_even + $results_kelvin[intval(($number_of_results + 1) / 2) + 1];

            $celcius_even = $results_celcius[intval(($number_of_results + 1) / 2)];
            $response['median_celcius'] = $celcius_even + $results_celcius[intval(($number_of_results + 1) / 2) + 1];

            $fahrenheit_even = $results_fahrenheit[intval(($number_of_results + 1) / 2)];
            $response['median_fahrenheit'] = $fahrenheit_even + $results_fahrenheit[intval(($number_of_results + 1) / 2) + 1];

        }

        return $response;

    }

    private function even($number){
        
        if ($number % 2 == 0) {

            return true;

        } else {

            return false;

        }

    }


}

?>