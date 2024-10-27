<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('dashboard', 'TagController');
Routing::get('todo', 'ToDoController');
Routing::post('login', 'SecurityController');
Routing::post('register', 'SecurityController');
Routing::post('import', 'ToDoController');
Routing::post('addD', 'ToDoController');
Routing::post('deleteD', 'ToDoController');
Routing::post('addG', 'TagController');
Routing::post('deleteG', 'TagController');
Routing::post('mark', 'TagController');
Routing::post('unmark', 'TagController');

Routing::run($path);