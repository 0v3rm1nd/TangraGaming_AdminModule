<?php
require_once('../../includes/session_timeout_db.inc.php');
if (isset($_POST['change_pwd'])) {
    $password = trim($_POST['new_pwd']);
    $retyped = trim($_POST['confnew_pwd']);
    $email = $_GET['email'];
    require_once('../../includes/admin/user/reset_password_mysqli.inc.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tangra User Password Reset</title>
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

            <!-- ResetPassForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">
                            <div id="login" class="animate form">
                                <h1>
                                    Reset Password
                                </h1>

                                <?php
                                 $email = $_GET['email'];
                                echo "<p id='email'>You are about to reset the password for $email</p>"
                                ?> 
                                <?php
                                if (isset($success)) {
                                    echo "<p>$success</p>";
                                } elseif (isset($errors) && !empty($errors)) {
                                    echo '<ul>';
                                    foreach ($errors as $error) {
                                        echo "<li>$error</li>";
                                    }
                                    echo '</ul>';
                                }
                                ?>
                                <form id="formreset" method="post" action="">
                                    <label for="newpwd" data-icon="p" >New password:</label>
                                    <input type="password" name="new_pwd" id="new_pwd" required placeholder="Type new password" required>
                                        </p>
                                        <p>
                                            <label for="conf_newpwd" data-icon="p">Retype password:</label>
                                            <input type="password" name="confnew_pwd" id="confnew_pwd" required placeholder="Retype new password" required>
                                        </p>      
                                        <p class="login button">
                                            <input name="change_pwd" type="submit" id="change_pwd" value="Change">
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
