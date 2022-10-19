<?php

    require '../boot/boot.php';

    use WeatherAPI\User;

    // Response Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $user_obj = new User();

    $users = $user_obj->get_all_users();

    $response['message'] = 'Welcome, to Weather-API Project. If a User Object is returned, then your API did NOT face any errors.';
    $response['user'] = $users;

    $response = json_encode($response);

    print_r($response);

?>

