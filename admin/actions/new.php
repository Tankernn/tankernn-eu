<?php
	require 'app.php';

	$type = $_GET['type'];
	$name = $_POST['name'];

	if (!hasPermission("new.$type")) {
		die("Not enough permissions.");
	}

	$sql = "INSERT INTO $type SET name='$name'";
	if($conn->query($sql)) {
		echo "Successfully created new $type!";
	} else {
		echo $conn->error;
	}
?>
