<?php
require_once('..\..\classes\CheckPassword.php');
$nicknameMinChars = 4;
$emailMinChars = 5;
$errors = array();

if (strlen($email) < $emailMinChars) {
  $errors[] = "Email must be at least $emailMinChars characters.";
}
if (preg_match('/\s/', $email)) {
  $errors[] = 'Email should not contain spaces.';
}
if (strlen($nickname) < $nicknameMinChars) {
  $errors[] = "Nickname must be at least $nicknameMinChars characters.";
}
if (preg_match('/\s/', $nickname)) {
  $errors[] = 'Nickname should not contain spaces.';
}

$checkPwd = new Ps2_CheckPassword($password, 6);
$checkPwd->requireMixedCase();
$checkPwd->requireNumbers(1);
$checkPwd->requireSymbols();
$passwordOK = $checkPwd->check();
if (!$passwordOK) {
  $errors = array_merge($errors, $checkPwd->getErrors());
}
if ($password != $retyped) {
  $errors[] = "Your passwords don't match.";
}
if (!$errors) {
  // include the connection file
  require_once('../../includes/connection.inc.php');
  $conn = dbConnect('write');
  // create a salt using the current timestamp
  $salt = time();
  // encrypt the password and salt with SHA1
  $pwd = sha1($password . $salt);
  //generate the timestamp to update the dateupdated field in the mysql database via the prepared statement
$date = new DateTime();
$datecreated = $date->format('Y-m-d H:i:s');
  // prepare SQL statement
  $sql = 'INSERT INTO user ( email, nickname, salt, password, datecreated)
          VALUES (?, ?, ?, ?, ?)';
  $stmt = $conn->stmt_init();
  $stmt = $conn->prepare($sql);
  // bind parameters and insert the details into the database
  $stmt->bind_param('ssiss',$email, $nickname, $salt, $pwd, $datecreated);
  $stmt->execute();
  if ($stmt->affected_rows == 1) {
	$success = "$nickname has been registered and it is now usable";
  } elseif ($stmt->errno == 1062) {
	$errors[] = "Email:$email or Nickname:$nickname  is already in use.";
  } else {
	$errors[] = 'Sorry, there was a problem with the database.';
  }
}