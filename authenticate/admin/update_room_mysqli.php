<?php
require_once('../../includes/session_timeout_db.inc.php');
require_once('../../includes/connection.inc.php');
// initialize flags
$OK = false;
// create database connection
$conn = dbConnect('write');
// initialize statement
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['name']) && !$_POST) {
// prepare SQL query
    $sql = 'SELECT name, owner, parentroom, public, dateupdated FROM room WHERE name = ?';
    if ($stmt->prepare($sql)) {
// bind the query parameter
        $stmt->bind_param('s', $_GET['name']);
// bind the results to variables
        $stmt->bind_result($roomname, $owner, $parentroom, $public, $dateupdated);
// execute the query, and fetch the result
        $OK = $stmt->execute();
        $stmt->fetch();
    }
}
// if form has been submitted, update record
if (isset($_POST['update'])) {
    $roomname = trim($_POST['roomname']);
    $oldroomname =trim($_POST['oldroomname']);
    $owner = trim($_POST['owner']);
    $parentroom = trim($_POST['parentroom']);
    $public = trim($_POST['public']);
    require_once('../../includes/admin/room/update_room_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Update Room</title>
        <link href="../../style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../../css/formcss/style.css" />
        <link rel="stylesheet" type="text/css" href="../../css/formcss/demo.css" />
    </head>

    <body>
        <div id="allcontent">
            <div id="header">
                <img src="../../images/banner.png" alt="Tangra Gaming"/>
            </div>
            <div id="cssmenu">
                <?php include('../../includes/menu.inc.php'); ?>
            </div>

            <!-- UpdateRoomForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <h1>Update Room</h1>
                                <?php
                                if (isset($success)) {
                                    header('Location: ../admin/alter_room.php');
                                } elseif (isset($errors) && !empty($errors)) {
                                    echo '<p><ul>';
                                    foreach ($errors as $error) {
                                        echo "<li>$error</li>";
                                    }
                                    echo '</ul></p>';
                                }
                                ?>
                                <form id="form1" method="post" action="">

                                    <p id="email">
                                        The owner of a room can not be changed: <?php echo "$owner" ; ?></br>
                                        Last Update: <?php echo "$dateupdated"; ?>
                                    </p>

                                    <p>
                                        <input type="hidden" name="oldroomname" id="oldroomname" value="<?php echo htmlentities($roomname, ENT_COMPAT, 'utf-8'); ?>" required>
                                    </p>

                                    <p>
                                        <label for="roomname" class="roomname" > Update room name </label>
                                        <input type="text" name="roomname" id="roomanme" value="<?php echo htmlentities($roomname, ENT_COMPAT, 'utf-8'); ?>" required>
                                    </p>
                                    <p>
                                        <label for="parentroom" class="parentroom" > Update parent room </label>
                                        <input type="text" name="parentroom" id="parentroom" value="<?php echo htmlentities($parentroom, ENT_COMPAT, 'utf-8'); ?>" required>
                                    </p>
                                    <p>
                                        <label for="public" class="public" > Public </label>
                                        <input type="text" name="public" id="public" value="<?php echo htmlentities($public, ENT_COMPAT, 'utf-8'); ?>" required>
                                    </p>

                                    <p class="login button">
                                        <input type="submit" name="update" value="Update" id="update">
                                    </p>
                                </form>

                            </div>
                        </div>
                    </div>  
                </section>
            </div>
            <div id="footer">
                <?php include('../../includes/footer.inc.php'); ?>
            </div>
    </body>
</html>