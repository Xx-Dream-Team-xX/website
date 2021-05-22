<?php
/**
 * Global settings.
 */

 // Branding and URL settings
 define('SETTINGS', array(
     'name' => 'iCar',
     'version' => '0.0.1',
     'url' => 'http://localhost/'
 ));
// Time zone settings, see https://www.php.net/manual/en/timezones.php
 date_default_timezone_set('Europe/Paris');
 // List of possible path were web server files are stored for router to look into
 define('PATH', array(
     'api' => SERVER_ROOT . '/endpoints/',
     'database' => SERVER_ROOT . '/data/',
     'utils' => SERVER_ROOT . '/utils/',
     'logs' => SERVER_ROOT . '/logs/',
     'views' => SERVER_ROOT . '/pages/views/',
     'partials' => SERVER_ROOT . '/pages/partials/',
     'static' => SERVER_ROOT . '/pages/static/',
     'images' => SERVER_ROOT . '/pages/static/images/',
     'css' => SERVER_ROOT . '/pages/static/css/',
     'js' => SERVER_ROOT . '/pages/static/js/',
     'other' => SERVER_ROOT . '/pages/static/other/',
 ));
 ?>
