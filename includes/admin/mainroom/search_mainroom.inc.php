<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'name';
$dir = 'ASC';
// create arrays of permitted values
$columns = array('name', 'datecreated','dateupdated');
$direction = array('ASC', 'DESC');
// if the form has been submitted, use only expected values
if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
    $col = $_GET['column'];
}
if (isset($_GET['direction']) && in_array($_GET['direction'], $direction)) {
    $dir = $_GET['direction'];
}
// prepare the SQL query
$sql = "SELECT name, datecreated, dateupdated FROM mainroom
        ORDER BY $col $dir";
// submit the query and capture the result
$result = $conn->query($sql) or die($conn->error);
?>

<form id="form1" method="get" action="">
    <label for="column">Order by:</label>
    <select name="column" id="column">
        <option value="name" <?php if ($col == 'name') echo 'selected'; ?>>Name</option>
        <option value="datecreated" <?php if ($col == 'datecreated') echo 'selected'; ?>>Date Created</option>
        <option value="dateupdated" <?php if ($col == 'dateupdated') echo 'selected'; ?>>Date Updated</option>
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
            <th>Name</th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th></th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['datecreated']; ?></td>    
                <td><?php echo $row['dateupdated']; ?></td>
                <td><a href="../../authenticate/admin/update_mainroom_mysqli.php?name=<?php echo $row['name']; ?>">EDIT INFO</a></td>
            </tr>
        <?php } ?>
    </table>
</div>