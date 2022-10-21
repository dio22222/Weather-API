# Weather-API
A RESTful API written in PHP that provides you with Weather Forecast for over 200,000 cities &amp; Historical Weather Data Search for All Major Greek Cities, using the power of Open Weather Map API.

### Dependencies
 - firebase/php-jwt
 
 You can install it with this command: `composer require firebase/php-jwt`

### Build Instructions
Your Project must inlclude:

A "db_config.json" file inside the top-level folder "config" with your database configuration.

ex.
```
{
    "database": {
        "host": "127.0.0.1:3306",
        "dbname": "weather_api_db",
        "username": "yourusername",
        "password": "yourpassword"
    }
}
```

The API key for the Open Weather Map API will be provided in a json file called "API_KEY.json" inside the top-level directory "config".

ex.
```
{
    "API_KEY": "yourapikey"
}
```
A Secret Key will be provided for Encoding & Decoding JWT Tokens, in a json file called "SECRET_KEY.json" inside the top-level directory "config".

ex.
```
{
    "SECRET_KEY": "yoursecretkey"
}
```

# Usage

#### Endpoints (/api/)
- register.php\
  Method: `POST`\
  Description: Register an Account\
  ex. Request
  ```
  {
    {
        "username" : "yourusername",
        "email" : "youremail",
        "password" : "yourpassword",
        "password-repeat" : "yourpassword"
    }
  }
  ```
- login.php\
Method: `POST`\
Description: Acquire an Authentication Token\
ex. Request
```
{
    "username" : "yourusername",
    "password" : "yourpassword"
}
```
- forecast.php `Authentication Required`\
Method: `GET`\
Description: Get Weather Forecast for the specified City\
Parameters:\
`Required` `city`  The city you want to get Weather Forecast for\
`Optional` `limit`  The limit you want to introduce to the Response. Default is 9 and can be up to 40\
ex. Request
```
https://domain-name.com/Weather-API/api/forecast.php?city=athens&limit=3
```
- search.php `Authentication Required`\
Method: `GET`\
Description: Search for historical Weather data saved to the Database\ 
Parameters:\
`Required` `city`  The city you want to get Weather Forecast for\
`Required` `date`  The date of the Forecast you're looking for with the format of yyyy-mm-dd \
ex. Request
```
https://domain-name.com/Weather-API/api/search.php?city=athens&date=2022-10-20
```
- meanmedian.php `Authentication Required`\
Method: `GET`\
Description: Calculate Mean & Meadian Temperature Values for the last 10 days (if the data is available in the Database)\
Parameters:\
`Required` `city`  The city you want to get Mean & Median Temperature Data for\
ex. Request
```
https://domain-name.com/Weather-API/api/meanmedian.php?city=athens
```

#### Data Collection
Data Collection for Historical Weather Data is collected by the `/scripts/collect_data.php` script. That script is built with the intention of creating a CRON command that runs it once a day.
