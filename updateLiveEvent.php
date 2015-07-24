<?php

require_once 'connect.php';

class UpdateLiveEvent {
	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);
		//need updated distance
		//also need event name and user name to grab unique live event to UPDATE

		$user = $post[0];
		$eventName = $post[1];
		$updatedDistance = $post[2];
		$updatedTime = $post[3];
		$updatedPercentReached = $post[4];
		$updatedAvgSpeed = $post[5];
		$baseRaised = $post[6];

		$this->updateEvent($user,$eventName,$updatedDistance);
	}

	public function updateEvent($user,$event,$distance,$speed,$time,$percent,$raised) {
		$eventID = null;

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT ID FROM LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event');
		$stmt->execute();
		while ($result = $stmt->fetch()) {
			$eventID = $result["ID"];
		}

		$stmt2 = $con->prepare("UPDATE LiveMileUpdates SET distance = :distance, averageSpeed = :averageSpeed, time = :time, percentReached = :percent, amountRaised = :raised 
			WHERE ID = :id");
		$stmt2->bindParam(':distance',$distance);
		$stmt2->bindParam(':averageSpeed',$speed);
		$stmt2->bindParam(':time',$time);
		$stmt2->bindParam(':percent',$percent);
		$stmt2->bindParam(':raised',$raised);
		$stmt2->bindParam(':id',$eventID);
		$stmt2->execute();
	}
}