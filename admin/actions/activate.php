<?php
  require 'app.php';

  if (isset($_GET['key'])) {
    $key = $_GET['key'];

    $sql = "SELECT * FROM Activations WHERE Activation_key='$key'";
    $query = $conn->query($sql);
    if (!($row = $query->fetch_array())) {
      die("No such key in database.");
    }

    $type = $row['Type'];
    $value = $row['Val'];
    $user = $row['User'];
    if ($type == "Addresses") {
      $values = json_decode($conn->query("SELECT * FROM Users WHERE User='$user'")->fetch_array()['Addresses'], true);
      array_push($values, $value);
      $value = json_encode($values);
    }

    $sql = "UPDATE Users SET $type='$value' WHERE User='$user'";
    if ($conn->query($sql)) {
      queue_message(new Message("Successfully activated $type.", "success"));
      $sql = "DELETE FROM Activations WHERE Activation_key='$key'";
      $conn->query($sql);
      header("Location: ../index.php");
    } else {
      echo "Failed to activate $type. Error: " . $conn->error;
    }
  } else { ?>
    <!DOCTYPE html>
    <html>
      <?php include '../pageparts/head.php'; ?>
      <body>
        <div class="container" style="margin-top: 100px;">
          <div class="row">
            <div class="col-lg-6 col-md-offset-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="glyphicon glyphicon-lock"></i> No key specified
                </div>
                <div class="panel-body">
                  <form role="form" action="" method="get">
                    <div class="input-group" style="margin-bottom: 10px;">
                      <span class="input-group-addon">Key:</span>
                      <input class="form-control" placeholder="Activation key" name="key" autofocus="" type="text">
                    </div>
                    <input class="btn btn-primary btn-block" type="submit" value="Activate"/>
	                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </body>
    </html>
    <?php
  }
?>
