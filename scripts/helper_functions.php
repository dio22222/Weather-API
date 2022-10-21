<?php

function get_secret_key() {

    $path = __DIR__.'/../config/SECRET_KEY.json';

    $secret_key = file_get_contents($path);

    ['SECRET_KEY' => $secret_key] = json_decode($secret_key, true);

    return $secret_key;

}

?>