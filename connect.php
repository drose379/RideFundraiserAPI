<?php

class DBConnect {
	public static function get() {
		return new PDO('mysql:host=localhost;dbname=ride_fundraise','root','HwAlJAgstN');
	}
}