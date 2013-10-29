<?php

$mainroomMinChars = 2;
$errors = array();

if (strlen($mainroom) < $mainroomMinChars) {
    $errors[] = "Main room name must be at least $mainroomMinChars characters.";
}

if (!$errors) {
    // include the connection file
    require_once('../../includes/connection.inc.php');
    $conn = dbConnect('write');
    //generate the timestamp to update the dateupdated field in the mysql database via the prepared statement
    $date = new DateTime();
    $datecreated = $date->format('Y-m-d H:i:s');
    // prepare SQL statement
    $sql = 'INSERT INTO mainroom ( name, datecreated)
          VALUES (?, ?)';
    $stmt = $conn->stmt_init();
    $stmt = $conn->prepare($sql);
    // bind parameters and insert the details into the database
    $stmt->bind_param('ss', $mainroom, $datecreated);
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $success = "Main room:$mainroom has been successfully created!";
    } elseif ($stmt->errno == 1062) {
        $errors[] = "Main Room:$mainroom already exists!";
    } else {
        $errors[] = 'Sorry, there was a problem with the database.';
    }
}