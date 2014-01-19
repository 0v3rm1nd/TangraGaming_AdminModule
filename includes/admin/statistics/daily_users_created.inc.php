<?php

require_once('../../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$sql = "SELECT * from user ";
$result = $conn->query($sql) or die($conn->error);
while ($row = $result->fetch_assoc()) {
    echo $row['email'] . "\t" . $row['datecreated'] . "\n";
}