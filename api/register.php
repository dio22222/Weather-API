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

    if (!isset($_GET['username'])) {

        $response['message'] = 'Username parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($_GET['email'])) {

        $response['message'] = 'Email parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($_GET['password'])) {

        $response['message'] = 'Password parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    if (!isset($_GET['password-repeat'])) {

        $response['message'] = 'Password-repeat parameter missing.';

        $response = json_encode($response);

        print_r($response);

        exit();

    }

    $user = new User();

    $response = $user->register($_GET['username'], $_GET['email'], $_GET['password'], $_GET['password-repeat']);

    http_response_code($response['code']);
    unset($response['code']);

    $response = json_encode($response);

    print_r($response);

?>