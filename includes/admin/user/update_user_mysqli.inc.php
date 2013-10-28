<?php

$nicknameMinChars = 4;
$errors = array();

if (strlen($nickname) < $nicknameMinChars) {
    $errors[] = "Nickname must be at least $nicknameMinChars characters.";
}
if (preg_match('/\s/', $nickname)) {
    $errors[] = 'Nickname should not contain spaces.';
}
if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    // prepare SQL statement
    $sql = "UPDATE user  SET nickname = ?, name=?, signature = ?, hobby = ?,  disabled = ? WHERE email = ?";
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bind_param('ssssis', $nickname, $name, $signature, $hobby, $disabled, $email);
    $done = $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "$nickname has been updated and it is now usable";
    } elseif ($stmt->errno == 1062) {
        $errors[] = "Nickname:$nickname is already in use.";
    } else {
        $errors[] = 'Sorry, there was a problem with the database.';
    }
}