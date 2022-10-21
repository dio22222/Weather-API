<?php

    require '../boot/boot.php';
    require '../vendor/autoload.php';
    require '../scripts/helper_functions.php';

    use WeatherAPI\Forecast;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    // Response Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $key = get_secret_key();

    // Only Accept GET Request Methon
    if (strtolower($_SERVER['REQUEST_METHOD'] != 'GET')) {

        $response['success'] = false;
        $response['message'] = 'Invalid Request Method';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    // Get Request Headers
    $headers = getallheaders();

    // Check if Bearer Token is passed in Authorization Header 
    if (!isset($headers['Authorization'])) {

        $response['message'] = 'Invalid Token';

        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401
        http_response_code(401);

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    // Get Token
    $jwt = str_replace('Bearer ', '', $headers['Authorization']);

    // Validate Token
    try {

        $jwt_decoded = JWT::decode($jwt, new Key($key, 'HS512'));

    }

    catch (Exception $e) {

        $response['message'] = 'Invalid Token';

        // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401
        http_response_code(401);

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    // Authenticated

    if (!isset($_GET['city'])) {

        $response['success'] = false;
        $response['message'] = 'City parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    $forecast = new Forecast();

    // Check if optional parameter 'limit' exists in the Request
    if (isset($_GET['limit'])) {

        $results = $forecast->get_forecast($_GET['city'], $_GET['limit']);

    } else {

        $results = $forecast->get_forecast($_GET['city']);

    }

    http_response_code($results['code']);

    unset($results['code']);

    $response = json_encode($results);

    print_r(json_encode($results));

?>