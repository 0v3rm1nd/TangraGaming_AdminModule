<?php
require_once('../../includes/session_timeout_db.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tangra Friend List</title>
        <link rel="stylesheet" type="text/css" href="../../style.css" />
    </head>
    <body>
        <div id="allcontent">
            <div id="header">
                <img src="../../images/banner.png" alt="Tangra Gaming"/>
            </div>
            <div id="cssmenu">
                <?php include('../../includes/menu.inc.php'); ?>
            </div>
            <div id="maincontent">
                <h1>
                    Friend List
                </h1>
                <h3>
                   Get the last 100 records based on:
                </h3>
                <?php
                require_once('../../includes/admin/user/search_friendlist.inc.php');
                ?>
            </div>
            <div id="footer">
                <?php include('../../includes/footer.inc.php'); ?>
            </div>

        </div>
    </body>

</html>