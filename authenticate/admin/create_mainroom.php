<?php
require_once('../../includes/session_timeout_db.inc.php');
if (isset($_POST['create'])) {
    $mainroom = trim($_POST['mainroom']);
    require_once('../../includes/admin/mainroom/create_mainroom_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Create Main Room</title>
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

            <!-- CreateMainRoomForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <form id="form1" method="post" action="">

                                    <h1>Create Main Room</h1>
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
                                        <label for="mainroom"> Main Room Name</label>
                                        <input id="mainroom" name="mainroom" required type="text" placeholder="Fill in main room name">
                                    </p>
                      

                                    <p class="login button">
                                        <input name="create" type="submit"  value="Create">
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
