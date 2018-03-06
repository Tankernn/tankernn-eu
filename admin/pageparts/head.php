<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<?php
foreach (glob("css/*.css") as $filename)
     echo "<link rel='Stylesheet' type='text/css' href='$filename'/>";
?>
<link rel="shortcut icon" href="favicon.ico"/>
<meta charset='utf-8'/>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu@2.7.4/dist/metisMenu.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
//Import scripts
foreach (glob("scripts/*.js") as $filename)
{
  echo "<script src='$filename'></script>";
}
?>
<title><?php echo Config::$sitename ?> - Administration</title>
</head>
