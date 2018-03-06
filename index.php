<?php
  require "app.php";
  $site = new App();
?>

<!DOCTYPE html>
<html lang="en" charset="utf-8">
    <head>
      <?php
        echo $site->components['Head'];
        echo "<style>".$site->pageRow['CSS']."</style>";
        echo $site->styles;
        echo "<title>".Config::$sitename."</title>";
      ?>
    </head>
    <body>
        <?php echo $site->components['Navbar']; ?>
        <main>
        	<?php
            $site->printPage();
          ?>
        </main>
        <footer>
          <?php echo $site->components['Footer']; ?>
        </footer>
        <?php
          echo $site->scripts;
        ?>
    </body>
</html>
