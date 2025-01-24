<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('backup', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('import', 'ImportController');

Routing::run($path);