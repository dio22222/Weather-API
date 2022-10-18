<?php

namespace WeatherAPI;

use WeatherAPI\Base;

class User extends Base {

    public function get_all_users() {

        return $this->fetch('SELECT * FROM user');

    }

}