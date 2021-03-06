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

		$this->createLiveEventBase($user,$eventName,$organization,$rate,$goalDistance);
		$this->createLiveEventUpdates($user,$eventName);
	}

	public function createLiveEventBase($user,$event,$organization,$donationRate,$goalDistance) {
		$con = DBConnect::get();

		$stmt = $con->prepare("INSERT INTO LiveMile (user,eventName,organization,perMile,goalDistance) VALUES (:user,:event,:organization,:rate,:goalDistance)");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->bindParam(':organization',$organization);
		$stmt->bindParam(':rate',$donationRate);
		$stmt->bindParam(':goalDistance',$goalDistance);

		$stmt->execute();
	}

	public function createLiveEventUpdates($user,$event) {
		$itemID = null;

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT ID from LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
		while ($result = $stmt->fetch()) {
			$itemID = $result["ID"];
		}

		$stmt2 = $con->prepare("INSERT INTO LiveMileUpdates (ID) VALUES (:id)");
		$stmt2->bindParam(':id',$itemID);
		$stmt2->execute();
	}
}