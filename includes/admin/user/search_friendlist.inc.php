<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'user1';
$dir = 'ASC';
// create arrays of permitted values
$columns = array('user1', 'user2', 'datecreated');
$direction = array('ASC', 'DESC');
// if the form has been submitted, use only expected values
if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
    $col = $_GET['column'];
}
if (isset($_GET['direction']) && in_array($_GET['direction'], $direction)) {
    $dir = $_GET['direction'];
}
// prepare the SQL query
$sql = "SELECT user1, user2, datecreated FROM friends
        ORDER BY $col $dir";
// submit the query and capture the result
$result = $conn->query($sql) or die($conn->error);
?>

<form id="form1" method="get" action="">
    <label for="column">Order by:</label>
    <select name="column" id="column">
        <option value="user1" <?php if ($col == 'user1') echo 'selected'; ?>>User1</option>
        <option value="user2" <?php if ($col == 'user2') echo 'selected'; ?>>User2</option>
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
            <th>User1</th>
            <th>User2</th>
            <th>Date Created</th>
            <th></th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['user1']; ?></td>
                <td><?php echo $row['user2']; ?></td>    
                <td><?php echo $row['datecreated']; ?></td>
                <td><a href="../../authenticate/admin/delete_friendrecord_mysqli.php?user1=<?php echo $row['user1']. "&user2=".$row['user2']; ?>">Delete Record</a></td>
            </tr>
        <?php } ?>
    </table>
</div>