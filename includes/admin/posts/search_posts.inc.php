<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'datecreated';
$dir = 'DESC';
// create arrays of permitted values
$columns = array('user', 'room', 'post', 'datecreated');
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
    $sql2 = "SELECT user, room, post, datecreated FROM post WHERE user LIKE '$searchterm' OR room LIKE '$searchterm' ORDER BY datecreated DESC";
    $result2 = $conn->query($sql2) or die($conn->error);
    $numRows = $result2->num_rows;
}
// prepare the SQL query
$sql = "SELECT user, room, post, datecreated FROM post
        ORDER BY $col $dir";
// submit the query and capture the result
$result = $conn->query($sql) or die($conn->error);
?>

<form id="form1" method="get" action="">
    <label for="column">Order by:</label>
    <select name="column" id="column">
        <option value="user" <?php if ($col == 'user') echo 'selected'; ?>>User</option>
        <option value="room" <?php if ($col == 'room') echo 'selected'; ?>>Room</option>
        <option value="post" <?php if ($col == 'post') echo 'selected'; ?>>Post</option>
        <option value="datecreated" <?php if ($col == 'datecreated') echo 'selected'; ?>>Date Created</option>
    </select>
    <select name="direction" id="direction">
        <option value="ASC" <?php if ($dir == 'ASC') echo 'selected'; ?>>Ascending</option>
        <option value="DESC" <?php if ($dir == 'DESC') echo 'selected'; ?>>Descending</option>
    </select>
    <input type="submit" name="change" id="go1" value="Search">
</form>
</br>
<!--Search for a post based on a user/room-->
<h3>
    Otherwise specify the user/room to search for: 
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
            <th>User</th>
            <th>Room</th>
            <th>Post</th>
            <th>Date Created</th>
            <th></th>
        </tr>
        <?php
        if (isset($_GET['go'])) {

            while ($row = $result2->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['room']; ?></td>    
                    <td><?php echo $row['post']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><a href="../../authenticate/admin/update_post_mysqli.php?user=<?php echo $row['user'] . "&room=" . $row['room'] . "&datecreated=" . $row['datecreated']; ?>">Update Post</a></td>
                </tr>
                <?php
            }
        } elseif (isset($_GET['column'])) {

            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['room']; ?></td>    
                    <td><?php echo $row['post']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><a href="../../authenticate/admin/update_post_mysqli.php?user=<?php echo $row['user'] . "&room=" . $row['room'] . "&datecreated=" . $row['datecreated']; ?>">Update Post</a></td>
                </tr>
                <?php
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['room']; ?></td>    
                    <td><?php echo $row['post']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><a href="../../authenticate/admin/update_post_mysqli.php?user=<?php echo $row['user'] . "&room=" . $row['room'] . "&datecreated=" . $row['datecreated']; ?>">Update Post</a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>