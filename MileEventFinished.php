<?php

		# Generate donation summary with values from EventDonation table (Put dummy data to test)
			# Once donation summary is created, remove records from EventDonation table
		# Move event record from LiveMile table to CompleteMileEvent table

		# RETURN Json encoded string of donation summary

require 'connection.php';

class MileEventFinished {

	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);

		$user = $post[0];
		$event = $post[1];

		$eventData = $this->grabLiveEvent($user,$event);
		echo json_encode($eventData);
		//move to Complete table
		//generate donation summary (make sure dummy data is there first)
		//echo back

	}

	public function grabLiveEvent($user,$event) {
		$eventData = array();

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT * FROM LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
		while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$eventData[] = $result;
		}
		return $eventData;
	}

}