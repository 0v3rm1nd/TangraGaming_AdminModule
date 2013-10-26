<?php 
require_once('../../includes/session_timeout_db.inc.php');
if (isset($_POST['create'])) {
$email = trim($_POST['email']);
$nickname = trim($_POST['nickname']);
$password = trim($_POST['pwd']);
$retyped  = trim($_POST['conf_pwd']);
require_once('../../includes/register_user_mysqli.inc.php');
}?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Create User</title>
<link rel="stylesheet" type="text/css" href="../../styles/style.css" />
</head>

<body>
<div id="pagesearch">
<h1>Create User</h1>
<a href="admin_home.php">&middotAdmin Home</a>
<?php
if (isset($success)) {
echo "<p>$success</p>";
} elseif (isset($errors) && !empty($errors)) {
echo '<ul>';
foreach ($errors as $error) {
echo "<li>$error</li>";
}
echo '</ul>';
}
?>
<form id="form1" method="post" action="">
  <p>
    <label for="email">Email:</label>
    <input type="text" name="email" id="email" required>
  </p>
    <p>
    <label for="nickname">Nickname:</label>
    <input type="text" name="nickname" id="nickname" required>
  </p>
 
  <p>
    <label for="pwd">Password:</label>
    <input type="password" name="pwd" id="pwd" required>
  </p>
  <p>
    <label for="conf_pwd">Confirm password:</label>
    <input type="password" name="conf_pwd" id="conf_pwd" required>
  </p>    
  <p>
    <input name="create" type="submit" id="register" value="Create">
  </p> 
</form>
</div>
</body>
</html>
