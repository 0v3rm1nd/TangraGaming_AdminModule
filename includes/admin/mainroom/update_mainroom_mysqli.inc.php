<?php

$mainroomnameMinChars = 2;
$errors = array();

if (strlen($mainroomname) < $mainroomnameMinChars) {
    $errors[] = "Main Room Name must be at least $mainroomnameMinChars characters.";
}

if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    // prepare SQL statement
    $sql = "UPDATE mainroom  SET name = ? WHERE name = ?";
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bind_param('ss', $mainroomname,$oldmainroomname );
    $done = $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "$mainroomname has been successfully updated";
    } elseif ($stmt->errno == 1062) {
        $errors[] = "Main Room:$mainroomname is already in use.";
    } else {
        $errors[] = 'Sorry, there was a problem with the database.';
    }
}