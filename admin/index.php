<?php
	require_once('app.php');
?>
<!DOCTYPE html>
<html>
<?php include 'pageparts/head.php'; ?>
<body>
	<?php
		if (isset($_SESSION['user'])) {
			include 'pageparts/sidemenu.php';
			echo '<div id="page-wrapper">';
			echo '<div class="alert-wrapper">';
			list_messages();
			echo '</div>';

			if(isset($_GET['p']))
				include "pages/" . $_GET['p'] . ".php";
			else
				include "pages/dashboard.php";
			echo '</div>';
		} else {
			header("Location: https://login.tankernn.eu?redirect=https://tankernn.eu/admin");
		}
	?>
	</body>
</html>
