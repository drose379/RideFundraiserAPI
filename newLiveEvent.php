<?php

require 'connect.php';

class LiveEvent {
	public function run() {
		$post = json_decode(file_get_contents('php://input'),true);

		var_dump($post);
	}

	public function createLiveEvent($user,$event,$organization,$donationRate,$distanceGoal) {

	}
}