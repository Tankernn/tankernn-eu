<?php
  require 'app.php';

  $type = "";
  if (isset($_GET['type']))
    $type = $_GET['type'];
  else
    die("No type specified.");

  if (!hasPermission("list.$type")) {
		die("Not enough permissions.");
	}
?>
    <?php
    $result = $conn->query("SELECT * FROM $type ORDER BY listId");

    if ($result === FALSE) {
      $result = $conn->query("SELECT * FROM $type ORDER BY UID");
    }

    while($row = $result->fetch_array()) {
      if (isset($row['name'])) {
        $name = $row['name'];
      } else {
        $name = $row['User'];
      }
    	?>
    	<tr id="<?php echo "Item_" . $row['UID'] ?>">
    		<td><?php echo $name ?></td>
    		<td>
    			<!--Delete button-->
    			<form>
    				<input type="hidden" class="uid" name="uid" value="<?php echo $row['UID'] ?>"/>
    				<button class="btn delete btn-danger" data-target="#delete-modal-<?php echo $row['UID'] ?>" data-toggle="modal" type="button"><i class="fa fa-trash-o"></i> Delete</button>
            <!-- Modal -->
            <div id="delete-modal-<?php echo $row['UID'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-<?php echo $row['UID'] ?>">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="delete-modal-<?php echo $row['UID'] ?>">Confirm deletion</h4>
                  </div>
                  <div class="modal-body">
                    Clicking 'Delete' will permanently delete the <?php echo strtolower($type) . " '$name'" ?>. Are you sure you want to do this?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button data="<?php echo $row['UID'] ?>" data-dismiss="modal" type="button" class="delete-confirm btn btn-danger">Delete</button>
                  </div>
                </div>
              </div>
            </div>
    			</form>
    			<!--Edit button-->
    			<form action="" method="get">
    				<input type="hidden" name="p" value="edit"/>
    				<input type="hidden" name="type" value="<?php echo $type; ?>"/>
    				<input type="hidden" name="uid" value="<?php echo $row['UID'] ?>"/>
    				<button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i> Edit</button>
    			</form>
    		</td>
    	</tr>
    	<?php
    }
?>
