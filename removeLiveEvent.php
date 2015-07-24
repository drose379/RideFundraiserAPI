<?php

require_once 'connect.php';

class RemoveLiveEvent {
	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);
		$user = $post[0];
		$event = $post[1];

		$this->removeEventUpdates($user,$event);
		$this->removeEvent($user,$event);
	}

	public function removeEvent($user,$event) {
		$con = DBConnect::get();
		$stmt = $con->prepare("DELETE FROM LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
	}

	public function removeEventUpdates($user,$event) {
		$eventID = null;

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT ID from LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
		while ($result = $stmt->fetch()) {
			$eventID = $result["ID"];
		}

		$stmt2 = $con->prepare("DELETE FROM LiveMileUpdates WHERE ID = :id");
		$stmt2->bindParam(':id',$eventID);
		$stmt2->execute();
	}
}