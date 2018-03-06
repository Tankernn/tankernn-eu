<?php
  require 'app.php';

  if (isset($_SESSION['user'])) { // Update account info
    $username = $_SESSION['user'];
    $userid = $_SESSION['userid'];
    if (isset($_POST['newPass'])) {
      changePassword($userid, $_POST['newPass'], $_POST['repeatNewPass'], $_POST['oldPass']);
    } else if (isset($_POST['email'])) {
      $mail = $_POST['email'];
      if ($mail === $_POST['repeatEmail']) {
        new_activation($username, "Email", $mail);
      } else {
        queue_message(new Message("Addresses do not match.", "danger"));
      }
    }
    // TODO Admin can edit other users' permissions
    if (isset($_POST['permissions'])) {
      $object = (object) ['property' => 'Here we go'];
    }

    header("Location: ../account_settings");
  } else {
    echo "Not logged in.";
  }

?>
