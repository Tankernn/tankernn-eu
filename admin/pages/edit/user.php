<?php
  $permissions = json_decode($row['Permissions']);

  $available = array("edit.Page", "edit.Users", "edit.Section", "edit.Menu", "edit.CSS",
                      "new.Page", "new.Users", "new.Section", "new.Menu",
                      "delete.Page", "delete.Users", "delete.Section", "delete.Menu",
                      "list.Page", "list.Users", "list.Section", "list.Menu", "rsps");
  $forbidden = array_diff($available, $permissions->custom_permissions);

?>

Permission level: <input id="level" value="<?php echo $permissions->permission_level ?>">

<br />

<div class="sort permlist" id="forbid">
  <h3>Forbidden</h3>
  <ul class="permlist">
    <?php
      foreach ($forbidden as $permission) {
        echo "<li id='$permission'>$permission</li>";
      }
    ?>
  </ul>
</div>
<div class="sort" id="allow">
  <h3>Allowed</h3>
  <ul class="permlist">
    <?php
      foreach ($permissions->custom_permissions as $permission) {
        echo "<li id='$permission'>$permission</li>";
      }
    ?>
  </ul>
</div>

<script>
function updatePermissions() {
  var allowed = $('#allow ul').sortable("toArray");

  console.log($("#level").val());

  $.post("actions/updatePermissions.php?uid=<?php echo $uid ?>", {level: $("#level").val(), custom: JSON.stringify(allowed)}, function(theResponse){
    display_message(theResponse);
  });
}

$(document).ready(function() {
  $('div.sort li').disableSelection();

  $('#forbid ul').sortable({
      revert: 'invalid',
      connectWith: "#allow ul",
      cursor: 'move'
  });

  $('#allow ul').sortable({
      revert: 'invalid',
      connectWith: "#forbid ul",
      cursor: 'move',
      update: updatePermissions
  });

  $('#level').spinner().change(updatePermissions);
});
</script>
