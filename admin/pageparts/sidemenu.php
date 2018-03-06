<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Tankernn Administration</a>
  </div>

  <ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
      <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="?p=account_settings"><i class="fa fa-cog"></i> Account Settings</a></li>
        <li class="divider"></li>
        <li><a href="http://login.tankernn.eu/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
      </ul>
    </li>
  </ul>

  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul id="side-menu" class="nav in">
        <li><a href="?p=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li <?php if ($_GET['p'] === "list") echo "class='active'"; ?>>
            <a href="#"><i class="fa fa-edit"></i> Edit<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
              <li><a href="?p=list&type=Menu"><i class="fa fa-bars"></i> Edit Menu</a></li>
              <li><a href="?p=list&type=Component"><i class="fa fa-puzzle-piece"></i> Edit Component</a></li>
              <li><a href="?p=list&type=Page"><i class="fa fa-file"></i> Edit Pages</a></li>
              <li><a href="?p=list&type=Section"><i class="fa fa-file-code-o"></i> Edit Sections</a></li>
              <li><a href="?p=list&type=Users"><i class="fa fa-user"></i> Edit User Permissions</a></li>
            </ul>
            <!-- /.nav-second-level -->
        </li>
        <li><a href="?p=edit&type=CSS"><i class="fa fa-file-text"></i> Edit CSS</a></li>
      </ul>
    </div>
  </div>
</nav>
