<?php 

require '../boot/boot.php';
$log_path = __DIR__.'/log/data_collection.log';

use WeatherAPI\DataCollector;

$data_collector = new DataCollector();

$cities = array(

    'athens',
    'thessaloniki',
    'patras',
    'heraklion',
    'ioannina',
    'larissa',
    'volos',

);

foreach ($cities as $city) {

    $response = $data_collector->get_weather_data($city);

    // Turn Array into a Delimited String
    $log = implode(" - ", $response);

    // Add a new line at the end
    $log .= PHP_EOL;

    // Log Results
    file_put_contents($log_path, $log, FILE_APPEND);

}

?>