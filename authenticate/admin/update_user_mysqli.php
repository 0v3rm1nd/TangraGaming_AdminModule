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
if (isset($_GET['email']) && !$_POST) {
// prepare SQL query
    $sql = 'SELECT email, nickname, name, signature, hobby, disabled, dateupdated FROM user WHERE email = ?';
    if ($stmt->prepare($sql)) {
// bind the query parameter
        $stmt->bind_param('s', $_GET['email']);
// bind the results to variables
        $stmt->bind_result($email, $nickname, $name, $signature, $hobby, $disabled, $dateupdated);
// execute the query, and fetch the result
        $OK = $stmt->execute();
        $stmt->fetch();
    }
}
// if form has been submitted, update record
if (isset($_POST['update'])) {
    $email = trim($_GET['email']);
    $nickname = trim($_POST['nickname']);
    $name = trim($_POST['name']);
    $signature = trim($_POST['signature']);
    $hobby = trim($_POST['hobby']);
    $disabled = trim($_POST['disabled']);
    require_once('../../includes/admin/user/update_user_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Update User</title>
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

            <!-- UpdateUserForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <h1>Update User</h1>
                                <?php
                                if (isset($success)) {
                                    header('Location: ../admin/alter_user.php');
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
                                        Email can not be changed:<?php echo htmlentities($email, ENT_COMPAT, 'utf-8'); ?></br>
                                        Last Update: <?php echo "$dateupdated"; ?>
                                    </p>
                                    <p>
                                        <label for="nickname" class="uname" data-icon="u" > Update user nickname </label>
                                        <input type="text" name="nickname" id="nickname" value="<?php echo htmlentities($nickname, ENT_COMPAT, 'utf-8'); ?>" required>
                                    </p>
                                    <p>
                                        <label for="name" class="uname" > Update name </label>
                                        <input type="text" name="name" id="name" value="<?php echo htmlentities($name, ENT_COMPAT, 'utf-8'); ?>">
                                    </p>

                                    <p>
                                        <label for="signature" class="uname" > Update signature </label>
                                        <input type="text" name="signature" id="signature" value="<?php echo htmlentities($signature, ENT_COMPAT, 'utf-8'); ?>">
                                    </p>
                                    <p>
                                        <label for="hobby" class="uname" > Update hobby </label>
                                        <input type="text" name="hobby" id="hobby" value="<?php echo htmlentities($hobby, ENT_COMPAT, 'utf-8'); ?>">
                                    </p>

                                    <p>
                                        <label for="disabled"> Disabled </label>
                                        <input type="text" name="disabled" id="disabled" value="<?php echo htmlentities($disabled, ENT_COMPAT, 'utf-8'); ?>"required>
                                    </p> 
                                    <p class="login button">
                                        <input type="submit" name="update" value="Update User" id="update">
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