<?php

$roomnameMinChars = 2;
$errors = array();

if (strlen($roomname) < $roomnameMinChars) {
    $errors[] = "Room Name must be at least $roomnameMinChars characters.";
}
//generate the timestamp to update the dateupdated field in the mysql database via the prepared statement
$date = new DateTime();
$dateupdated = $date->format('Y-m-d H:i:s');

if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    // prepare SQL statement
    $sql = "UPDATE room  SET name = ?,parentroom = ?, public = ?, dateupdated = ? WHERE name = ?";
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bind_param('ssiss', $roomname,$parentroom, $public, $dateupdated,$oldroomname );
    $done = $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "$roomname has been successfully updated";
    } elseif ($stmt->errno == 1062) {
        $errors[] = "Room:$roomname is already in use.";
    } else {
        $errors[] = "Sorry, there was a problem with the database.";
    }
}