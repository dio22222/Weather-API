# Weather-API
A RESTful API written in PHP that provides you with Weather Forecast for over 200,000 cities &amp; Historical Weather Data Search for All Major Greek Cities, using the power of Open Weather Map API.

### Dependencies
 - "firebase/php-jwt"
 > You can install it with this command: composer require firebase/php-jwt

### Build Instructions
Your Project must inlclude:
A "db_config.json" file inside the top-level folder "config" with your database configuration.

ex.\
{\
    "database": {\
        "host": "127.0.0.1:3306",\
        "dbname": "weather_api_db",\
        "username": "yourusername",\
        "password": "yourpassword"\
    }\
}\

The API key for the Open Weather Map API will be provided in a json file called "API_KEY.json" inside the top-level directory "config".

ex.
{
    "API_KEY": "yourapikey"
}

A Secret Key will be provided for Encoding & Decoding JWT Tokens, in a json file called "SECRET_KEY.json" inside the top-level directory "config".

ex.
{
    "SECRET_KEY": "yoursecretkey"
}

# Usage

Endpoints (/api/)
- register.php
  > Method: Post
  > Description: Register an Account
  ex. {
    {
        "username" : "yourusername",
        "email" : "youremail",
        "password" : "yourpassword",
        "password-repeat" : "yourpassword"
    }
  }