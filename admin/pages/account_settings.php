<?php
if (!isset($_SESSION['user'])) {
  die("Not logged in");
}
?>

<div class="row">
	<div class="col-lg-12">
      <h1 class="page-header">Account Settings</h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-default">
    	<div class="panel-heading"><i class="fa fa-lock"></i> Change password</div>
      <form action="actions/edit_user.php" method="post">
      	<div class="panel-body">
            <div class="input-group">
          		<span class="input-group-addon" id="old-addon">Old password</span>
          		<input name="oldPass" type="password" class="form-control" placeholder="Your current password" aria-describedby="old-addon">
          	</div>
            <div class="input-group">
          		<span class="input-group-addon" id="new-addon">New password</span>
          		<input name="newPass" type="password" class="form-control" placeholder="Your desired new password" aria-describedby="new-addon">
          	</div>
            <div class="input-group">
          		<span class="input-group-addon" id="repeat-new-addon">Repeat new password</span>
          		<input name="repeatNewPass" type="password" class="form-control" placeholder="Repeat your new password" aria-describedby="repeat-new-addon">
          	</div>
        </div>
        <div class="panel-footer"><input class="btn btn-primary" type="submit"/></div>
      </form>
    </div>
  </div>
  <!-- /.col-lg-6 -->
  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-envelope"></i> Change E-mail</div>
      <form action="actions/edit_user.php" method="post">
        <div class="panel-body">
            <div class="input-group">
              <span class="input-group-addon" id="mail-addon">New E-mail address</span>
              <input name="email" type="email" class="form-control" placeholder="Your new E-mail" aria-describedby="mail-addon">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="repeat-mail-addon">Repeat new E-mail</span>
              <input name="repeatEmail" type="email" class="form-control" placeholder="Repeat your new Email" aria-describedby="repeat-mail-addon">
            </div>
        </div>
        <div class="panel-footer">
          <input class="btn btn-primary" type="submit"/>
        </div>
      </form>
    </div>
  </div>
  <!-- /.col-lg-6 -->
</div>
