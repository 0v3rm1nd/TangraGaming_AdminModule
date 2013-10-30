<?php
require_once('../../includes/session_timeout_db.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tangra Logout</title>
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
            <!-- Logout -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <form id="form1" method="post" action="">


                                    <h1>
                                        Logout
                                    </h1>
                                    <h3>
                                        Are you sure you want to logout ?
                                    </h3>
                                    <?php include('../../includes/logout_db.inc.php'); ?>
                                    <p class="login button">
                                        <input name="logout" type="submit" id="logout" value="Logout">
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