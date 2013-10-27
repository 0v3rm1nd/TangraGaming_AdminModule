<?php
$error = '';
if (isset($_POST['login'])) {
    session_start();
    $email = trim($_POST['email']);
    $password = trim($_POST['pwd']);
// location to redirect on success
    $redirectadmin = './authenticate/admin/admin_home.php';
    require_once('./includes/authenticate_mysqli.inc.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tangra Gaming Login</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" type="text/css" href="./css/formcss/style.css" />
        <link rel="stylesheet" type="text/css" href="./css/formcss/demo.css" />
    </head>

    <body>
        <div id="allcontent">

            <div id="header">
                <img src="images/banner.png" alt="Tangra Gaming"/>
            </div>

            <!-- LoginForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">

                                <form  id="form1" action="" method="post"> 
                                    <h1>Admin Log in</h1> 
                                    <?php
                                    if ($error) {
                                        echo "<p>$error</p>";
                                    } elseif (isset($_GET['expired'])) {
                                        ?>
                                        <p>Your session has expired. Please log in again.</p>
                                    <?php } ?>
                                    <p> 
                                        <label for="email" class="uname" data-icon="u" > Your email</label>
                                        <input id="username" name="email" required type="text" placeholder="Fill in admin email"/>
                                    </p>
                                    <p> 
                                        <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                        <input id="password" name="pwd" required type="password" placeholder="Fill in admin password" /> 
                                    </p>

                                    <p class="login button"> 
                                        <input type="submit" name="login" value="Login" /> 
                                    </p>

                                </form>
                            </div>
                        </div>
                    </div>  
                </section>
            </div>
            <!-- Login Form End -->

            <div id="footer">
                <?php include('./includes/footer.inc.php'); ?>
            </div>

        </div>

    </body>
</html>