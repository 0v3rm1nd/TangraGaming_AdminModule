<?php
require_once('../../includes/session_timeout_db.inc.php');
if (isset($_POST['create'])) {
    $email = trim($_POST['email']);
    $nickname = trim($_POST['nickname']);
    $password = trim($_POST['pwd']);
    $retyped = trim($_POST['conf_pwd']);
    require_once('../../includes/admin/user/register_user_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Create User</title>
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

            <!-- RegisterUserForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <form id="form1" method="post" action="">

                                    <h1>Create User</h1>
                                    <?php
                                    if (isset($success)) {
                                        echo "<p>$success</p>";
                                    } elseif (isset($errors) && !empty($errors)) {
                                        echo '<p><ul>';
                                        foreach ($errors as $error) {
                                            echo "<li>$error</li>";
                                        }
                                        echo '</ul></p>';
                                    }
                                    ?>
                                    <p>
                                        <label for="email" class="uname" data-icon="u" > User email</label>
                                        <input id="username" name="email" required type="text" placeholder="Fill in user email">
                                    </p>
                                    <p>
                                        <label for="nickname" class="uname" data-icon="u" > Nickname </label>
                                        <input type="text" name="nickname" id="nickname" required placeholder="Fill in user nickname">
                                    </p>

                                    <p>
                                        <label for="pwd" class="youpasswd" data-icon="p"> User password </label>
                                        <input type="password" name="pwd" id="pwd" required placeholder="Fill in user password">
                                    </p>
                                    <p>
                                        <label for="conf_pwd" class="youpasswd" data-icon="p"> Confirm password </label>
                                        <input type="password" name="conf_pwd" id="conf_pwd" required placeholder="Retype user password">
                                    </p>    

                                    <p class="login button">
                                        <input name="create" type="submit"  value="Create User">
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
