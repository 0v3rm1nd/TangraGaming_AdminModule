<?php
require_once('../includes/session_timeout_db.inc.php');
require_once('../includes/connection.inc.php');
$conn = dbConnect('write');
// initialize flags
$OK = false;
$deleted = false;
// initialize statement
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['email']) && !$_POST) {
  // prepare SQL query
  $sql = 'SELECT email FROM user WHERE email = ?';
  if ($stmt->prepare($sql)) {
    // bind the query parameters
    $stmt->bind_param('s', $_GET['email']);
	// bind the result to variables
	$stmt->bind_result($email);
	// execute the query, and fetch the result
	$stmt->execute();
	$stmt->fetch();
  }
}
// if confirm deletion button has been clicked, delete record
if (isset($_POST['delete'])) {
  $sql = 'DELETE FROM user WHERE email = ?';
  if ($stmt->prepare($sql)) {
    $stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// if there's an error affected_rows is -1
	if ($stmt->affected_rows > 0) {
	  $deleted = true;
	} else {
      $error = 'There was a problem deleting this user. '; 
	}
  }
}
// redirect the page if deletion is successful, 
// cancel button clicked, or $_GET['article_id'] not defined
if ($deleted || isset($_POST['cancel_delete']) || !isset($_GET['email']))  {
  header('Location: ../authenticate/admin/alter_user.php');
  exit;
  }
// if any SQL query fails, display error message
if (isset($stmt) && !$OK && !$deleted) {
  $error='';
  $error .= $stmt->error;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete User</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="pagesearch">
<h1>Delete User </h1>
<?php 
if (isset($error)  && !empty($error)) {
  echo "<p class='warning'>Error: $error</p>";
}
if($email === 'administrator@tangra.com') { ?>
<p class="warning">Invalid request: This user can not be deleted!</p>
<?php } else { ?>
<p class="warning">Please confirm that you want to delete the following user. This action cannot be undone.</p>
<p><?php echo "User: " . htmlentities($email, ENT_COMPAT, 'utf-8'); ?></p>
<?php } ?>
<form id="form1" method="post" action="">
    <p>
	<?php if(isset($email) && $email !='administrator@tangra.com' ) { ?>
        <input type="submit" name="delete" id= "go1"value="Confirm Deletion">
	<?php } ?>
		<input name="cancel_delete" type="submit" id="go1" value="Cancel">
	<?php if(isset($email)) { ?>
		<input name="email" type="hidden" value="<?php echo $email; ?>">
	<?php } ?>
    </p>
</form>
</div>
</body>
</html>
