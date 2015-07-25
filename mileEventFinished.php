<?php


		/**
		  * Grab ID from LiveMile table for event
		  * Move data from LiveMileUpdates table to CompleteMileEvent table
		  * Remove Item from LiveMile table
		  * Remove Item from LiveMileUpdates table
		  * Pull data from LiveEventDonations table and form a JSONArray of donation summary, echo as string back to application 
		  */


require_once 'connect.php';

class MileEventFinished {

	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);

		$user = $post[0];
		$event = $post[1];

		$eventID = $this->grabEventId($user,$event);
		$this->moveFromLiveToComplete($eventID);
	}

	public function grabEventId($user,$event) {
		$eventId = null;

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT ID FROM LiveMile WHERE user = :user AND eventName = :event");
		$stmt->bindParam(':user',$user);
		$stmt->bindParam(':event',$event);
		$stmt->execute();
		while($result = $stmt->fetch()) {
			$eventId = $result["ID"];
		}
		return $eventId;
	}

	public function moveFromLiveToComplete($eventId) {
		//grab data from Live table
		//insert into completed table

		$eventInfo = [];

		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT * FROM LiveMileUpdates WHERE ID = :eventId");
		$stmt->bindParam(':eventId',$eventId);
		$stmt->execute();
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$eventInfo[] = $result;
		}
		echo json_encode($eventInfo);
	}


}