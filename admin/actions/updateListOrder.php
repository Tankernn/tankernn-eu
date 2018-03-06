<?php
  require "app.php";

  $type = "";
  if (isset($_GET['type']))
    $type = $_GET['type'];
  else
    die("No type specified.");

  if (!hasPermission("list.$type")) {
		die("Not enough permissions.");
	}

  $updateRecordsArray = $_POST['Item'];

  $listingCounter = 1;
  foreach ($updateRecordsArray as $recordIDValue) {
  	$query = "UPDATE $type SET listId='$listingCounter' WHERE UID='$recordIDValue'";
  	$conn->query($query) or die('Error, insert query failed');
  	$listingCounter = $listingCounter + 1;
  }

  echo "Successfully saved order!";
?>
