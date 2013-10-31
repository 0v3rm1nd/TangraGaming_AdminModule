<?php
require_once('../../includes/session_timeout_db.inc.php');
if (isset($_POST['create'])) {
    $roomname = trim($_POST['roomname']);
    $mainroomname = trim($_POST['mainroom']);
    $public = trim($_POST['public']);
    $owner = trim($_SESSION['authenticated']);
    require_once('../../includes/admin/room/create_room_mysqli.inc.php');
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Create Room</title>
        <link rel="stylesheet" type="text/css" href="../../style.css" />
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

            <!-- CreateRoomForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <form id="form1" method="post" action="">

                                    <h1>Create Room</h1>
                                    <?php
                                    if (isset($success)) {
                                        echo "<p id='email'>$success</p>";
                                    } elseif (isset($errors) && !empty($errors)) {
                                        echo '<p><ul>';
                                        foreach ($errors as $error) {
                                            echo "<li>$error</li>";
                                        }
                                        echo '</ul></p>';
                                    }
                                    ?>
                                    <p>
                                        <label for="roomname" class="roomname" > Room Name</label>
                                        <input id="roomanme" name="roomname" required type="text" placeholder="Fill in room name">
                                    </p>

                                    <!-- Get mainroom names from the mysql db and populate the select -->

                                    <?php
                                    require_once('../../includes/connection.inc.php');
                                    // connect to MySQL
                                    $conn = dbConnect('write');
                                    // prepare the SQL query
                                    $sql = "SELECT name FROM mainroom";
                                    // submit the query and capture the result
                                    $result = $conn->query($sql) or die($conn->error);
                                    echo "<label for='mainroom' class='mainroom' > Main Room</label></br>
                                        <select name='mainroom'>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                    }
                                    echo "</select>";
                                    ?>


                                    <p>
                                        <label for="public" class="public" > Public/Private </label>
                                        <input type="text" name="public" id="pwd" required placeholder="Fill in 1 or 0">
                                    </p>  

                                    <p class="login button">
                                        <input name="create" type="submit"  value="Create Room">
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
        </div>
    </body>
</html>
