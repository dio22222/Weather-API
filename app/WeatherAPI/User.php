<?php

namespace WeatherAPI;

use MessageFormatter;
use WeatherAPI\Base;

class User extends Base {

    public function register($username, $email, $password, $password_repeat) {

        $response['code'] = 200;
        $response['success'] = false;

        $user_doesnt_exist = $this->fetch('SELECT id FROM user WHERE email = :email OR username = :username', [':email' => $email, ':username' => $username]);

        if ($user_doesnt_exist != false) {

            $response['message'] = 'User with that E-mail or Username Already Exists';

            return $response;

        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $response['message'] = 'Not a Valid E-mail';

            return $response;

        }

        if ($password !== $password_repeat)  {

            $response['message'] = 'Passwords don\'t match';

            return $response;

        }

        // Generate Password Hash
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $parameters = [

            'username' => $username,
            'email' => $email,
            'password' => $password_hash,

        ];

        $success = $this->insert('user', $parameters);

        if(!$success) {

            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/500
            $response['code'] = 500;
            $response['message'] = 'Something went wrong';

            return $response;

        }

        $response['success'] = true;
        $response['message'] = 'Successfuly Registered a new User';

        return $response;

    }



}