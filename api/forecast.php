<?php

    require '../boot/boot.php';

    use WeatherAPI\Forecast;

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

    $city = $_GET['city'];

    // Check if optional parameter 'limit' exists in the Request, or else set Default Limit to 9
    isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = '9';

    $forecast = new Forecast();

    $results = $forecast->get_forecast($city, $limit);

    http_response_code($results['code']);

    unset($results['code']);

    $response = json_encode($results);

    print_r(json_encode($results));

?>