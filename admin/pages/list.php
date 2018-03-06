<?php
	if (!hasPermission("list")) {
		die("Not enough permissions.");
	}

	$type = "";
	if (isset($_GET['type']))
		$type = $_GET['type'];
	else
		die("No type specified.");
?>

<div class="row">
	<div class="col-lg-12">
      <h1 class="page-header"><?php echo "List $type"; ?></h1>
  </div>
  <!-- /.col-lg-12 -->
</div>

<form id="new">
	<div class="input-group">
		<span class="input-group-addon" id="name-addon">Name</span>
		<input name="name" id="name" type="text" class="form-control" placeholder="New entry name" aria-describedby="name-addon">
		<span class="input-group-btn">
      <button class="btn btn-primary" type="button">Add new entry <span class="fa fa-plus"></span></button>
    </span>
	</div>
</form>

<div class="panel panel-default">
	<div class="panel-heading">List of entries</div>
	<div class="panel-body table-panel">
		<table class="list table table-striped table-bordered table-hover dataTable no-footer"><thead><tr><th>Name</th><th>Actions</th></tr></thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">

function refreshTable() {
	$.get("actions/getList.php?type=<?php echo $type ?>", function(data) {
	 $(".list tbody").html(data);
	});

	$(".list tbody").sortable({ opacity: 0.6, cursor: 'move', update: function() {
		var order = $(this).sortable("serialize");
		$.post("actions/updateListOrder.php?type=<?php echo $type ?>", order, function(theResponse){
			display_message(theResponse);
		});
	}}).disableSelection();
}

$(document).ready(function(){
	refreshTable();
	$(function() {
		$("#new button").click(function(){
			$.post("actions/new.php?type=<?php echo $type ?>", $("#new").serialize(), function(theResponse){
				display_message(theResponse);
				refreshTable();
			});
			refreshTable();
		});
		$(".list").on('click', '.delete-confirm', function(){
			var deleteUID = parseInt($(this).attr("data"), 10);
			$('#delete-modal-' + deleteUID).modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			$.get("actions/delete.php?type=<?php echo $type ?>", {uid: deleteUID}, function(theResponse) {
				display_message(theResponse);
			});
			refreshTable();
		});
 });
});
</script>
