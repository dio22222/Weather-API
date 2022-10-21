<?php

    require '../boot/boot.php';

    use WeatherAPI\DataCollector;

    // Response Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data_collector = new DataCollector();
    $response = $data_collector->get_weather_data('thtdhd');
    $response = json_encode($response);
    print_r($response);
?>

