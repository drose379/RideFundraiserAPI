<?php

require 'connect.php';

class RemoveLiveEvent {
	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);
		$user = $post[0];
		$event = $post[1];

		$this->removeEvent($user,$event);
	}

	public function removeEvent($user,$event) {
		$con = DBConnect::get();
		$stmt = $con->prepare("DELETE FROM LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
	}
}