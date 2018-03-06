<?php
require 'app.php';

if (isset($_GET['uid']) and isset($_GET['type'])) {
		$uid = $_GET['uid'];
		$type = $_GET['type'];
		if (!hasPermission("delete.$type")) {
			die("Not enough permissions.");
		}

		$sql = "DELETE FROM $type WHERE UID='$uid'";
		if ($conn->query($sql)) {
			echo "Successfully deleted $type.";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
		echo $conn->error;
} else {
	echo 'Something went wrong! (No type or no UID provided.)';
}
?>
