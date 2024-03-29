<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'datecreated';
$dir = 'DESC';
// create arrays of permitted values
$columns = array('email', 'nickname', 'lastlogin', 'datecreated', 'disabled');
$direction = array('ASC', 'DESC');
// if the form has been submitted, use only expected values
if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
    $col = $_GET['column'];
}
if (isset($_GET['direction']) && in_array($_GET['direction'], $direction)) {
    $dir = $_GET['direction'];
}

if (isset($_GET['go'])) {
//prepare search term for the search functionality
    $searchterm = '%' . $conn->real_escape_string($_GET['search']) . '%';
    $sql2 = "SELECT email, nickname, lastlogin, datecreated, disabled FROM user WHERE email LIKE '$searchterm' OR nickname LIKE '$searchterm' ORDER BY email ASC";
    $result2 = $conn->query($sql2) or die($conn->error);
    $numRows = $result2->num_rows;
}
// prepare the SQL query for the order by functionality
$sql = "SELECT email, nickname, lastlogin, datecreated, disabled FROM user
        ORDER BY $col $dir LIMIT 100";
// submit the query and capture the result
$result = $conn->query($sql) or die($conn->error);
?>

<form id="form1" method="get" action="">
    <label for="column">Order by:</label>
    <select name="column" id="column">
        <option value="email" <?php if ($col == 'email') echo 'selected'; ?>>Email</option>
        <option value="nickname" <?php if ($col == 'nickname') echo 'selected'; ?>>Nickname</option>
        <option value="lastlogin" <?php if ($col == 'lastlogin') echo 'selected'; ?>>Last Login</option>
        <option value="datecreated" <?php if ($col == 'datecreated') echo 'selected'; ?>>Date Created</option>
        <option value="disabled" <?php if ($col == 'disabled') echo 'selected'; ?>>Disabled</option>
    </select>
    <select name="direction" id="direction">
        <option value="ASC" <?php if ($dir == 'ASC') echo 'selected'; ?>>Ascending</option>
        <option value="DESC" <?php if ($dir == 'DESC') echo 'selected'; ?>>Descending</option>
    </select>
    <input type="submit" name="change" id="go1" value="Search">
</form>
</br>
<!--Search for a user based on an email/nickname-->
<h3>
    Otherwise specify the email/username to search for: 
</h3>

<form id="form1" method="get" action="">
    <input type="text" name="search" id="search"> 
    <input type="submit" name="go" id="go" value="Search">
</form>

<?php if (isset($_GET['go'])) { ?>
    <p>Number of results for <b><?php echo htmlentities($_GET['search'], ENT_COMPAT, 'utf-8'); ?></b>: <?php echo $numRows; ?></p>
<?php } ?>
<div class="CSSTableGenerator" >
    <table>
        <tr>
            <th>Email</th>
            <th>Nickname</th>
            <th>Last Login</th>
            <th>Date Created</th>
            <th>Disabled</th>
            <th></th>
            <th></th>
        </tr>

        <?php
        if (isset($_GET['go'])) {

            while ($row = $result2->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nickname']; ?></td>    
                    <td><?php echo $row['lastlogin']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['disabled']; ?></td>
                    <td><a href="../../authenticate/admin/update_user_mysqli.php?email=<?php echo $row['email']; ?>">EDIT INFO</a></td>
                    <td><a href="../../authenticate/admin/reset_user_password.php?email=<?php echo $row['email']; ?>">RESET PASS</a></td>
                </tr>
                <?php
            }
        } elseif (isset($_GET['column'])) {

            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nickname']; ?></td>    
                    <td><?php echo $row['lastlogin']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['disabled']; ?></td>
                    <td><a href="../../authenticate/admin/update_user_mysqli.php?email=<?php echo $row['email']; ?>">EDIT INFO</a></td>
                    <td><a href="../../authenticate/admin/reset_user_password.php?email=<?php echo $row['email']; ?>">RESET PASS</a></td>
                </tr>
                <?php
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['nickname']; ?></td>    
                    <td><?php echo $row['lastlogin']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['disabled']; ?></td>
                    <td><a href="../../authenticate/admin/update_user_mysqli.php?email=<?php echo $row['email']; ?>">EDIT INFO</a></td>
                    <td><a href="../../authenticate/admin/reset_user_password.php?email=<?php echo $row['email']; ?>">RESET PASS</a></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>
</div>