<?php
  require "app.php";

  if (!hasPermission("edit.Page")) {
		die("Not enough permissions.");
	}

  if (isset($_GET['listall'])) {
    $query = $conn->query("SELECT UID, name FROM Section");
    $sectionlist = array();

    while ($row = $query->fetch_array()) {
      $sectionlist[$row['UID']] = $row['name'];
    }

    echo json_encode($sectionlist);
  } else if (isset($_GET['getids'])) {
    $sectionnames = json_decode($_GET['getids']);

    $sectionids = array();

    foreach ($sectionnames as $sectionname)
      array_push($sectionids, $conn->query("SELECT UID FROM Section WHERE name='$sectionname'")->fetch_array()['UID']);

    echo json_encode($sectionids);
  } else {
    $sections = json_decode($_GET['sections']);

    $app = new App(true);
    foreach ($sections as $section) {
      $app->addSection($section);
    }
  }
?>
