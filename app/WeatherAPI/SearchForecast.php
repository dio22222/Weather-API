<?php

namespace WeatherAPI;

class SearchForecast extends Base {

    public function get_historical_data($city, $date) {

        $query = 'SELECT * from forecast WHERE date = :date AND (official_city_name = :city OR city_name_given = :city)';

        $parameters = [
            ':city' => $city,
            ':date' => $date,
        ];

        $results = $this->fetch($query, $parameters);

        if (!$results) {

            $results = array(
                'message' => 'No Historical Forecast Data were found for that particular City and Date',
            );

            return $results;

        }

        // Delete Row ID
        unset($results['id']);

        return $results;

    }

}

?>