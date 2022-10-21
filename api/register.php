<?php

    require '../boot/boot.php';

    use WeatherAPI\User;

    // Response Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $response['success'] = false;

    // Only Accept POST Request Methon
    if (strtolower($_SERVER['REQUEST_METHOD'] != 'POST')) {

        $response['message'] = 'Invalid Request Method';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    // Get Request
    $request = file_get_contents("php://input");

    // Only Accept Valid JSON formated Requests
    if (!isValidJSON($request)) {

        $response['message'] = 'Invalid JSON';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    // Decode Request
    $request_decoded = json_decode($request, true);

    if (!isset($request_decoded['username'])) {

        $response['message'] = 'Username parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($request_decoded['email'])) {

        $response['message'] = 'Email parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($request_decoded['password'])) {

        $response['message'] = 'Password parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($request_decoded['password-repeat'])) {

        $response['message'] = 'Password-repeat parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    $user = new User();

    $response = $user->register($request_decoded['username'], $request_decoded['email'], $request_decoded['password'], $request_decoded['password-repeat']);

    http_response_code($response['code']);
    unset($response['code']);

    $response = json_encode($response);

    print_r($response);
    
    // Functions
    function isValidJSON($request) {

        json_decode($request, true);

        return json_last_error() == JSON_ERROR_NONE;

    }
?>