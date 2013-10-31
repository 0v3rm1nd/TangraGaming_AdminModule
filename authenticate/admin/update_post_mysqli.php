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
if (isset($_GET['user']) && isset($_GET['room']) && isset($_GET['datecreated']) && !$_POST) {
// prepare SQL query
    $sql = 'SELECT user, room, post, dateupdated FROM post WHERE user = ? AND room = ? AND datecreated = ?';
    if ($stmt->prepare($sql)) {
// bind the query parameter
        $stmt->bind_param('sss', $_GET['user'], $_GET['room'], $_GET['datecreated']);
// bind the results to variables
        $stmt->bind_result($user, $room, $post, $dateupdated);
// execute the query, and fetch the result
        $OK = $stmt->execute();
        $stmt->fetch();
    }
}
// if form has been submitted, update record
if (isset($_POST['update'])) {
    $post = $_POST['post'];
    $user = $_GET['user'];
    $room = $_GET['room'];
    $datecreated = $_GET['datecreated'];
    require_once('../../includes/admin/posts/update_post_mysqli.inc.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tangra Update Posts</title>
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

            <!-- UpdatePosts -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <h1>Update Posts</h1>
                                <?php
                                if (isset($success)) {
                                    header('Location: ../admin/view_posts.php');
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
                                        User:<?php echo "$user"; ?> made this post in room: <?php echo "$room"; ?></br>
                                        Last Update: <?php echo "$dateupdated"; ?>
                                    </p>
                                    <p>
                                        <label for="post" class="post" > Update post content </label>
                                        <input type="text" name="post" id="post" value="<?php echo htmlentities($post, ENT_COMPAT, 'utf-8'); ?>" required>
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