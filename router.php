<?php

require 'newLiveEvent.php';
require 'updateLiveEvent.php';
require 'removeLiveEvent.php';
require 'mileEventFinished.php';

class router {

	private $routes = [];

	public function __construct() {
		$this->loadRoutes();
	}

	public function loadRoutes() {
		$this->routes = [
			"/newLiveEvent" => [new LiveEvent,"run"],
			"/updateLiveEvent" => [new UpdateLiveEvent,"run"],
			"/removeLiveEvent" => [new RemoveLiveEvent,"run"],
			"/liveEventFinished" => [new MileEventFinished,"run"]
		];
	}

	public function match($path) {
		foreach ($this->routes as $route => $action) {
			if (preg_match("#^$route/?$#i",$path,$params)) {
      			return [$action,$params];
    		}
		}
	}

	public function run($path) {
		list($action,$params) = $this->match($path);
    	$action($params);
	}
}