<?php

require_once('../../classes/CheckPassword.php');
$errors = array();
$checkPwd = new Ps2_CheckPassword($password, 6);
$checkPwd->requireMixedCase();
$checkPwd->requireNumbers(1);
$checkPwd->requireSymbols();
$passwordOK = $checkPwd->check();
if (!$passwordOK) {
    $errors = array_merge($errors, $checkPwd->getErrors());
}
if ($password != $retyped) {
    $errors[] = "The new passwords don't match.";
}
if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    // create a salt using the current timestamp
    $salt = time();
    // encrypt the password and salt with SHA1
    $pwd = sha1($password . $salt);
    // prepare SQL statement
    $sql = "UPDATE user SET salt=?, password=? WHERE email = '$email'";
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bind_param('is', $salt, $pwd);
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "The password for $email has been reset!";
    } else {
        $errors[] = 'Sorry, there was a problem with the database.';
    }
}