<?php
require_once('../../includes/session_timeout_db.inc.php');
require_once('../../includes/connection.inc.php');
$conn = dbConnect('write');
// initialize flags
$OK = false;
$deleted = false;
// initialize statement
$stmt = $conn->stmt_init();

// if confirm deletion button has been clicked, delete record
if (isset($_POST['delete'])) {
    $sql = 'DELETE FROM friends WHERE user1 = ? AND user2 = ?';
    if ($stmt->prepare($sql)) {
        $stmt->bind_param('ss', $_POST['user1'], $_POST['user2']);
        $stmt->execute();
        // if there's an error affected_rows is -1
        if ($stmt->affected_rows > 0) {
            $deleted = true;
        } else {
            $error = 'There was a problem deleting this friend record. ';
        }
    }
}
// redirect the page if deletion is successful, 
// cancel button clicked, or $_GET['user1/2'] not defined
if ($deleted || isset($_POST['cancel_delete']) || !isset($_GET['user1']) || !isset($_GET['user2'])) {
    header('Location: ../../authenticate/admin/view_friendlist.php');
    exit;
}
// if any SQL query fails, display error message
if (isset($stmt) && !$OK && !$deleted) {
    $error = '';
    $error .= $stmt->error;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Delete Friend Record</title>
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

            <!-- DeleteFriendRecordForm -->
            <div class="container">

                <section>				
                    <div id="container_demo" >

                        <div id="wrapper">

                            <div id="login" class="animate form">
                                <h1>Delete Friend Record </h1>
                                <?php
                                if (isset($error) && !empty($error)) {
                                    echo "<p class='warning'>Error: $error</p>";
                                }
                                ?>
                                <p>Please confirm that you want to delete this record. This action cannot be undone.</p>
                                <p id="email"><?php echo "Friend1:" . htmlentities($_GET['user1'], ENT_COMPAT, 'utf-8') . " is a friend of Friend2:" . htmlentities($_GET['user2'], ENT_COMPAT, 'utf-8'); ?></p>
                                <form id="form1" method="post" action="">
                                    <p class="login button">
                                        <?php if (isset($_GET['user1']) && isset($_GET['user2'])) { ?>
                                            <input type="submit" name="delete" id= "go1"value="Confirm Deletion">
                                        <?php } ?>
                                        <input name="cancel_delete" type="submit" id="go1" value="Cancel">
                                        <?php if (isset($_GET['user1']) && isset($_GET['user2'])) { ?>
                                            <input name="user1" type="hidden" value="<?php echo $_GET['user1']; ?>">
                                            <input name="user2" type="hidden" value="<?php echo $_GET['user2']; ?>">
                                        <?php } ?>
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
