<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'datecreated';
$dir = 'ASC';
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
</br>
<div class="CSSTableGenerator" >
    <table>
        <tr>
            <th>User</th>
            <th>Room</th>
            <th>Post</th>
            <th>Date Created</th>
            <th></th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['user']; ?></td>
                <td><?php echo $row['room']; ?></td>    
                <td><?php echo $row['post']; ?></td>
                <td><?php echo $row['datecreated']; ?></td>
                <td><a href="../../authenticate/admin/delete_friendreqrecord_mysqli.inc.php?user1=<?php echo $row['user1'] . "&user2=" . $row['user2']; ?>">Update/Delete Record</a></td>
            </tr>
        <?php } ?>
    </table>
</div>