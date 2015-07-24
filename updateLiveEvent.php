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

	public function updateEvent($user,$event,$updatedDistance) {
		//LiveMileUpdates needs a ID column to tie back to LiveMile table

		$con = DBConnect::get();
		$stmt = $con->prepare("UPDATE LiveMileUpdates SET actualDistance = :updatedDistance WHERE ID = :id");
		$stmt->bindParam(':updatedDistance',$updatedDistance);
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':eventName',$event);
		$stmt->execute();
	}
}