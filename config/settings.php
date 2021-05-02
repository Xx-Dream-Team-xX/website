<?php
/**
 * Global settings.
 */
 define('SETTINGS', array(
     'name' => 'iCar',
     'version' => '0.0.1',
 ));
 // List of possible path were web server files are stored for router to look into
 define('PATH', array(
     'api' => SERVER_ROOT . '/endpoints/',
     'database' => SERVER_ROOT . '/data/',
     'utils' => SERVER_ROOT . '/utils/',
     'views' => SERVER_ROOT . '/pages/views/',
     'partials' => SERVER_ROOT . '/pages/partials/',
     'static' => SERVER_ROOT . '/pages/static/',
     'images' => SERVER_ROOT . '/pages/static/images/',
     'css' => SERVER_ROOT . '/pages/static/css/',
     'js' => SERVER_ROOT . '/pages/static/js/',
     'other' => SERVER_ROOT . '/pages/static/other/',
 ));
 ?>
