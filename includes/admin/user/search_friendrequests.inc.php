<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'datecreated';
$dir = 'ASC';
// create arrays of permitted values
$columns = array('from', 'to', 'status', 'datecreated', 'dateupdated');
$direction = array('ASC', 'DESC');
// if the form has been submitted, use only expected values
if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
    $col = $_GET['column'];
}
if (isset($_GET['direction']) && in_array($_GET['direction'], $direction)) {
    $dir = $_GET['direction'];
}
// prepare the SQL query
$sql = "SELECT friendreq.from, friendreq.to, status, datecreated, dateupdated FROM friendreq
        ORDER BY friendreq.$col $dir";
// submit the query and capture the result
$result = $conn->query($sql) or die($conn->error);
?>

<form id="form1" method="get" action="">
    <label for="column">Order by:</label>
    <select name="column" id="column">
        <option value="from" <?php if ($col == 'from') echo 'selected'; ?>>From</option>
        <option value="to" <?php if ($col == 'to') echo 'selected'; ?>>To</option>
        <option value="status" <?php if ($col == 'status') echo 'selected'; ?>>Status</option>
        <option value="datecreated" <?php if ($col == 'datecreated') echo 'selected'; ?>>Date Created</option>
        <option value="dateupadted" <?php if ($col == 'dateupdated') echo 'selected'; ?>>Date Updated</option>
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
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th></th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['from']; ?></td>
                <td><?php echo $row['to']; ?></td>    
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['datecreated']; ?></td>
                <td><?php echo $row['dateupdated']; ?></td>
                <td><a href="../../authenticate/admin/delete_friendreqrecord_mysqli.inc.php?user1=<?php echo $row['user1'] . "&user2=" . $row['user2']; ?>">Delete Record</a></td>
            </tr>
        <?php } ?>
    </table>
</div>