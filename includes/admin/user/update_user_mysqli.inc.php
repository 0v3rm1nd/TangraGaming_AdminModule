<?php 
require_once('../includes/session_timeout_db.inc.php');
require_once('../includes/connection.inc.php');
// initialize flags
$OK = false;
$done = false;
// create database connection
$conn = dbConnect('write');
// initialize statement
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['email']) && !$_POST) {
// prepare SQL query
$sql = 'SELECT email, nickname FROM user WHERE email = ?';
if ($stmt->prepare($sql)) {
// bind the query parameter
$stmt->bind_param('s', $_GET['email']);
// bind the results to variables
$stmt->bind_result($email, $nickname);
// execute the query, and fetch the result
$OK = $stmt->execute();
$stmt->fetch();
}
}
// if form has been submitted, update record
if (isset($_POST ['update'])) {
// prepare update query
$sql = 'UPDATE user SET  email = ?, nickname = ? WHERE email = "$email"';
if ($stmt->prepare($sql)) {
$stmt->bind_param('ss', $_POST['email'], $_POST['nickname']);
$done = $stmt->execute();
}
}
// redirect on success if $_GET['article_id'] not defined
if ($done || !isset($_GET['email'])) {
header('Location: ../authenticate/admin/alter_user.php');
exit;
}
// display error message if query fails
if (isset($stmt) && !$OK && !$done) {
$error = $stmt->error;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Update User</title>
<link href="../styles/admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<h1>Update User</h1>
<p><a href="courtdate_list_mysqli.php">List all existing groups </a></p>
<?php if (isset($error)) {
echo "<p class='warning'>Error: $error</p>";
}?>
<p class="warning">Invalid request: group does not exist.</p>
<form id="form1" method="post" action="">
 
  <p>
    <label for="email">Email:</label>
    <input type="text" name="email" id="email" value="<?php echo htmlentities($email, ENT_COMPAT, 'utf-8'); ?>" required>
  </p>
  
  <p>
    <label for="username">Nickname:</label>
    <input type="text" name="nickname" id="nickname" value="<?php echo htmlentities($nickname, ENT_COMPAT, 'utf-8'); ?>" required>
  
    <label for="pwd">Password:</label>
    <input type="password" name="pwd" id="pwd" required>
  </p>
  <p>
    <label for="conf_pwd">Confirm password:</label>
    <input type="password" name="conf_pwd" id="conf_pwd" required>
  </p> 
    <p>
    <input type="submit" name="update" value="Update User" id="update">
  </p>
  <input name="email" type="hidden" value="<?php echo $email; ?>">   
  <p><a href="../authenticate/admin/admin_home.php">Back</a>
</form>
</body>
</html>