<?php
  require("app.php");

  if (!hasPermission("edit.User")) {
		die("Not enough permissions.");
	}

  $uid = $_GET['uid'];

  $custom = $_POST['custom'];
  $level = $_POST['level'];

  $level = intval($level);

  $permissions = new StdClass();

  $permissions->permission_level = $level;
  $permissions->custom_permissions = json_decode($custom);

  $permissionString = json_encode($permissions);

  if ($conn->query("UPDATE Users SET Permissions='$permissionString' WHERE UID='$uid'")) {
    echo "Successfully updated permissions.";
  } else {
    echo "Error updating database: " . $conn->error;
  }

?>
