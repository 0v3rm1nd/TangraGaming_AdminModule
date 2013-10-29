<?php

$roomnameMinChars = 2;
$errors = array();

if (strlen($roomname) < $roomnameMinChars) {
    $errors[] = "Room name must be at least $roomnameMinChars characters.";
}

if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    // prepare SQL statement
    $sql = 'INSERT INTO room (name,owner,parentroom,public,datecreated)
          VALUES (?,?,?,?,?)';
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    //generate the timestamp to update the dateupdated field in the mysql database via the prepared statement
    $date = new DateTime();
    $datecreated = $date->format('Y-m-d H:i:s');
    // bind parameters and insert the details into the database
    $stmt->bind_param('sssis', $roomname, $owner, $mainroomname, $public, $datecreated);
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "Room:$roomname has been successfully created!";
    } elseif ($stmt->errno == 1062) {
        $errors[] = "Room:$roomname already exists!";
    } else {
        $errors[] = 'Sorry, there was a problem with the database.';
    }
}