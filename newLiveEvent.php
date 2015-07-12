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

		$this->createLiveEvent($user,$eventName,$organization,$rate,$goalDistance);
	}

	public function createLiveEvent($user,$event,$organization,$donationRate,$goalDistance) {
		$con = DBConnect::get();

		$stmt = $con->prepare("INSERT INTO LiveMile (user,eventName,organization,perMile,goalDistance) VALUES (:user,:event,:organization,:rate,:goalDistance)");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->bindParam(':organization',$organization);
		$stmt->bindParam(':rate',$donationRate);
		$stmt->bindParam(':goalDistance',$goalDistance);

		$stmt->execute();
	}
}