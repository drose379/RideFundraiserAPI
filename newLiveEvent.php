<?php

require 'connect.php';

class LiveEvent {
	public function run() {
		$post = json_decode(file_get_contents('php://input'),true);
		
		$user = $post[0];
		$eventName = $post[1];
		$organization = $post[2];
		$rate = $post[3];
		$goalDistance = $post[4];

		echo $organization + $eventName + $organization + $goalDistance;

		//$this->createLiveEvent($user,$eventName,$organization,$rate,$goalDistance);
	}

	public function createLiveEvent($user,$event,$organization,$donationRate,$distanceGoal) {
		echo "Creating live event called on" + $user;
	}
}