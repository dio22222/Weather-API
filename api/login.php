<?php

require '../boot/boot.php';
require '../vendor/autoload.php';
require '../scripts/helper_functions.php';

use WeatherAPI\User;
use Firebase\JWT\JWT;

// Response Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$response = [
    'success' => false,
    'message' => '',
];

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

if (!isset($request_decoded['username']) || !is_string($request_decoded['username']) || !isset($request_decoded['password']) || !is_string($request_decoded['password']) ) {

    $response['message'] = 'Invalid Request';

    $response = json_encode($response);

    print_r($response);

    exit();

}

// Make User Object
$user = new User();

// Check if Username and Password are Correct
$user_id = $user->login($request_decoded['username'], $request_decoded['password']);

if (!$user_id) {

    $response['message'] = 'Incorect Credentials';

    $response = json_encode($response);

    print_r($response);

    exit();

}

// Generate Token
$key = get_secret_key();

$payload = [
    'iss' => 'localhost',
    'aud' => 'localhost',
    'iat' => time(),
    'exp' => time() + 60 * 15,
    'user_id' => $user_id,
];

$jwt = JWT::encode($payload, $key, 'HS512');

// Generate Successful Response
$response['success'] = true;

$response['message'] = 'Successful Login';

$response['token'] = $jwt;

$response = json_encode($response);

print_r($response);

// Functions
function isValidJSON($request) {

    json_decode($request, true);

    return json_last_error() == JSON_ERROR_NONE;

}

?>