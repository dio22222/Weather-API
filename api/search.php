<?php

    require '../boot/boot.php';

    use WeatherAPI\SearchForecast;

    // Response Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Only Accept GET Request Methon
    if (strtolower($_SERVER['REQUEST_METHOD'] != 'GET')) {

        $response['success'] = false;
        $response['message'] = 'Invalid Request Method';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($_GET['city'])) {

        $response['success'] = false;
        $response['message'] = 'City parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($_GET['date'])) {

        $response['success'] = false;
        $response['message'] = 'Date parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    $search_forecast = new SearchForecast();

    $response = $search_forecast->get_historical_data($_GET['city'], $_GET['date']);

    $response = json_encode($response);

    print_r($response);