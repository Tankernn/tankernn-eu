<?php
	$type = "";
	$uid = "";
	if (isset($_GET['uid'])) {
		$uid = $_GET['uid'];
	}
	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		die("Missing arguments.");
	}

	if (!hasPermission("edit.$type")) {
		die("Not enough permissions.");
	}

	//Save to database script:

	if (isset($_POST['name']) and $type !== "CSS") {
		$name = addslashes($_POST['name']);
		$uid = $_POST['uid'];
		$sql = "";

		if (isset($_POST['content']) and ($type === "Section" or $type === "Component")) {
			$content = addslashes($_POST['content']);
			$sql = "UPDATE $type SET name='$name', content='$content' WHERE UID='$uid'";

		} else if (isset($_POST['sections']) and $type === "Page") {
			$css = $_POST['css'];
			$sections = $_POST['sections'];
			$sql = "UPDATE Page SET name='$name', sections='$sections', CSS='$css' WHERE UID='$uid'";
		} else if ($type === "Menu") {
			$value = addslashes($_POST['value']);
			$valuetype = $_POST['type'];

			$sql = "UPDATE Menu SET name='$name', valuetype='$valuetype', value='$value' WHERE UID='$uid'";
		}

		if ($conn->query($sql)) {
			echo "<script>display_message('Successfully saved $type.')</script>";
		} else {
			echo "<script>display_message('Something broke: $conn->error', 'danger')</script>";
		}
	} else if (isset($_POST['css'])) {
		$file = fopen("../stylesheets/StyleSheet.css", "w");
		fwrite($file, $_POST['css']);
		fclose($file);
	}

	//View building script:

	if ($type !== "CSS") {
		$query = $conn->query("SELECT * FROM $type WHERE UID='$uid'");
		$row = $query->fetch_array();
		$name = isset($row['name']) ? $row['name'] : $row['User'];
	}

	$inputs = array();
	switch ($type) {
		case "Section":
		case "Component":
			$content = $row['content'];
			$inputs = array("<label>Section content:</label> <br /> <textarea id='code' name='content'>$content</textarea><div id='editor' style='height: 500px; width: 100%;'></div>");
			break;
		case "Page":
			$sections = $row['sections'];
			$css = $row['CSS'];
			$inputs = array(
				"<div class='input-group'><span class='input-group-addon' id='section-addon'>Page setions</span><input class='form-control' type='text' readonly id='sections' name='sections' value='$sections' aria-describedby='section-addon' data-toggle='tooltip' title='Drag the sections around in the preview to change the order. Use the dropdown below to add sections.'/><div class='input-group-btn'><button class='btn btn-primary' id='clean-json' type='button'>Cleanup JSON <span class='fa fa-code'></span></button></div></div>",
				"<div class='input-group'><span class='input-group-addon' id='add-section-addon'>Add section</span><select class='form-control' id='sectionselect' name='sectionselect' aria-describedby='add-section-addon'/></select><div class='input-group-btn'><button class='btn btn-primary' id='add-section' type='button'>Add <span class='fa fa-plus'></span></button></div></div>",
				"<label>Custom CSS:</label> <br /> <textarea id='code' name='css'>$css</textarea><div id='editor' style='height: 500px; width: 100%;'></div>"
			);
			break;
		case "CSS":
			$name = "StyleSheet.css";
			$filename = "../stylesheets/$name";
			$readfile = fopen($filename, "r");
			$css = fread($readfile, filesize($filename));
			$inputs = array(
				"<label>CSS:</label> <br /> <textarea id='code' name='css'>$css</textarea><div id='editor' style='height: 500px; width: 100%;'></div>"
			);
			break;
		case "Menu":
			$itemtype = $row['valuetype'];
			$isPage = ""; $isLink = "";

			if ($itemtype == "page") {
				$isPage = "selected";
			} else {
				$isLink = "selected";
			}

			$page_options = "";
			$pagequery = $conn->query("SELECT * FROM Page ORDER BY ListId");
			while ($pagerow = $pagequery->fetch_array()) {
				$page_name = $pagerow['name'];
				$page_selected = "";
				if ($row['value'] == $page_name) {
					$page_selected = "selected";
				}
				$page_options .= "<option value='$page_name' $page_selected>$page_name</option>";
			}

			$menu_value = $row['value'];

			$inputs = array("<div class='input-group'><span class='input-group-addon' id='type-addon'>Menuitem type:</span>
								<select class='form-control' name='type' id='typeselect' aria-describedby='type-addon'>
									<option value='page' $isPage>Page</option>
									<option value='link' $isLink>Link</option>
								</select></div>",
								"<div class='input-group' id='pageselect'><span class='input-group-addon' id='value-addon'>Value:</span>
								<select class='form-control' name='value' aria-describedby='value-addon'>
									$page_options
								</select></div>" .
								"<div class='input-group' id='linkselect'><span class='input-group-addon' id='link-addon'>Link:</span><input class='form-control' name='value' type='text' value='$menu_value'/></div>",
								"<script>updateSelect();</script>");
			break;
		case "Users":
			ob_start();
			include "pages/edit/user.php";
			$inputs = array(ob_get_clean());
			break;
	}
?>

<div class="row">
	<div class="col-lg-12">
      <h1 class="page-header"><?php echo "Edit $type"; ?></h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-6">
		<form action="" method="POST">
			<input name="uid" type="hidden" value="<?php echo $uid; ?>"/>
			<div class="input-group"><span class="input-group-addon" id="name-addon"><?php echo $type; ?> name:</span><input class="form-control" aria-describedby="name-addon" name="name" type="text" value="<?php echo $name ?>"/></div> <br />
			<?php
				foreach ($inputs as $input) {
					echo $input . "<br />";
				}
				?>
		<button class="btn btn-lg btn-primary" style="float: left;" type="submit"><i class="fa fa-floppy-o"></i> Save</button>
		</form>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<?php
		if (isset($row['CSS']))
			echo "<style>".$row['CSS']."</style>";

		echo "<div id='preview' class='$type'>";
		if ($type === "Page") {
			$sections = json_decode($row['sections']);
			if ($sections === NULL)
				$sections = explode(',', $row['sections']);

			$app = new App(true);
			foreach ($sections as $section) {
				$app->addSection($section);
			}
		} else if ($type === "Section") {
			echo $row['content'];
		}
		echo '</div>';
		?>
	</div>
	<!-- /.col-lg-6 -->
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/ace.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/mode-html.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/mode-css.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/theme-monokai.js'></script>

<script>
	var code = $("#code").hide();
	var editor = ace.edit("editor");
	editor.setTheme("ace/theme/monokai");
	editor.getSession().setMode("ace/mode/html");
	editor.getSession().setUseWrapMode(true);
	if (code.prop('name') === "css") {
		editor.getSession().setMode("ace/mode/css");
	}
	editor.getSession().setValue(code.val());
	editor.getSession().on('change', function() {
		code.val(editor.getSession().getValue());
		refreshPreview(editor.getSession().getValue());
	});

	function makeSortable() {
		$("#preview").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("toArray");
			$("#sections").val(JSON.stringify(order));
		}}).disableSelection();
	}

	function refreshPreview(str) {
		var preview = $("#preview");
		if (preview.hasClass("Section")) {
			$("#preview").html(str);
		} else if (preview.hasClass("Page")) {
			$.get( "actions/get_sections.php", { sections: $("#sections").val() } )
			.done(function( data ) {
				$("#preview").html(data);
			});
		}
	}

	function updateSelectBox() {
		$.get( "actions/get_sections.php", { listall: true } )
		.done(function(data) {
			var allsections = JSON.parse(data);

			var usedsections = JSON.parse($("#sections").val());

			usedsections.forEach( function (element, index, array) {
				delete allsections[element];
			});

			var selectBox = $('#sectionselect');
			selectBox.empty();
			$.each(allsections, function(key, value) {
     		selectBox
         .append($("<option></option>")
                    .attr("value",key)
                    .text(value));
			});
		});
	}

	$(document).ready(function() {
		if ($("#preview").attr('class') == "Page") {
			makeSortable();
			updateSelectBox();
		}
		$("#add-section").click(function() {
			var sections = JSON.parse($("#sections").val());
			sections.push($("#sectionselect").val());
			sections = sections.map(function (uid) {
				return parseInt(uid);
			});
			$("#sections").val(JSON.stringify(sections));
			refreshPreview();
			updateSelectBox();
		});

		$("#clean-json").click(function () {
			var sectionsString = $("#sections").val();
			var sections;
			try {
				sections = JSON.parse(sectionsString);
				sections = sections.map(function (uid) {
					return parseInt(uid);
				});
				$("#sections").val(JSON.stringify(sections));
			} catch (e) {
				sections = sectionsString.split(",");
				$.get( "actions/get_sections.php", { getids: JSON.stringify(sections) } )
				.done(function( data ) {
					console.log(data);
					$("#sections").val(data);
				});
			}
		});
	});

</script>
