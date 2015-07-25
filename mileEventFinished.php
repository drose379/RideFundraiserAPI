<?php


		/**
		  * Grab ID from LiveMile table for event
		  * Move data from LiveMileUpdates table to CompleteMileEvent table
		  * Pull data from LiveEventDonations table and form a JSONArray of donation summary, echo as string back to application 
		  * Remove Item from LiveMile table
		  * Remove Item from LiveMileUpdates table
		  */


require_once 'connect.php';

class MileEventFinished {

	public function run() {
		$post = json_decode(file_get_contents("php://input"),true);

		$user = $post[0];
		$event = $post[1];

		$eventID = $this->grabEventId($user,$event);
		$this->moveFromLiveToComplete($eventID,$user,$event);
		$this->generateDonationSummary($eventID);
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

	public function moveFromLiveToComplete($eventId,$user,$eventName) {
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

		echo $eventInfo[0]["ID"];
		
		//use eventInfo to insert record into CompleteMileEvent table
		$stmt2 = $con->prepare("INSERT INTO CompleteMileEvent (ID,user,eventName,distance,time,averageSpeed,goalReached) VALUES 
			(:id,:user,:event,:distance,:time,:averageSpeed,:goalReached)");
		$stmt2->bindParam(':id',$eventId);
		$stmt2->bindParam(':user',$user);
		$stmt2->bindParam(':event',$eventName);
		$stmt2->bindParam(':distance',$eventInfo["distance"]);
		$stmt2->bindParam(':time',$eventInfo["time"]);
		$stmt2->bindParam(':averageSpeed',$eventInfo["averageSpeed"]);
		$stmt2->bindParam(':goalReached',$eventInfo["percentReached"]);
	}

	//generate donation summary and insert it into CompleteMileEvent record where id = $eventId, use UPDATE
	public function generateDonationSummary($eventId) {
		$donationParent = [];
		
		$con = DBConnect::get();
		$stmt = $con->prepare("SELECT * FROM LiveEventDonations WHERE eventId = :id");
		$stmt->bindParam(':id',$eventId);
		$stmt->execute();
		while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$donationParent[] = $result;
		}

		//echo json_encode($donationParent);

	}

	//cleanup, remove from LiveEvent,LiveEventUpdates and LiveEventDonations

}