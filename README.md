# Weather-API
A RESTful API written in PHP that provides you with Weather Forecast &amp; Historical Weather Data Search for the area of Thessaloniki, Greece

# Build Instructions
Your Project must inlclude a "db_config.json" file inside the top-level folder "config" with your database configuration.

ex.
{
    "database": {
        "host": "127.0.0.1:3306",
        "dbname": "weather_api_db",
        "username": "yourusername",
        "password": "yourpassword"
    }
}

Also, the API key for the Open Weather Map API will be provided in a json file called "API_KEY.json" inside the top-level directory "config".