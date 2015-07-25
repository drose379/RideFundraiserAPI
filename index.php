<?php

require 'router.php';

$router = new Router();

$route = $_SERVER["PATH_INFO"] . "/";

$router->run($route);