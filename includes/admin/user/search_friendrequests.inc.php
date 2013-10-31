<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'datecreated';
$dir = 'DESC';
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
if (isset($_GET['go'])) {
//prepare search term for the search functionality
    $searchterm = '%' . $conn->real_escape_string($_GET['search']) . '%';
    $sql2 = "SELECT friendreq.from, friendreq.to, status, datecreated, dateupdated FROM friendreq WHERE friendreq.from LIKE '$searchterm' OR friendreq.to LIKE '$searchterm' ORDER BY datecreated DESC";
    $result2 = $conn->query($sql2) or die($conn->error);
    $numRows = $result2->num_rows;
}
// prepare the SQL query
$sql = "SELECT friendreq.from, friendreq.to, status, datecreated, dateupdated FROM friendreq
        ORDER BY friendreq.$col $dir LIMIT 100";
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
<!--Search for a friend request on a from/to user-->
<h3>
    Otherwise specify a user email to search for: 
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
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Date Updated</th>
        </tr>

        <?php
        if (isset($_GET['go'])) {

            while ($row = $result2->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['from']; ?></td>
                    <td><?php echo $row['to']; ?></td>    
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['dateupdated']; ?></td>
                </tr>
                <?php
            }
        } elseif (isset($_GET['column'])) {

            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['from']; ?></td>
                    <td><?php echo $row['to']; ?></td>    
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['dateupdated']; ?></td>
                </tr>
                <?php
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['from']; ?></td>
                    <td><?php echo $row['to']; ?></td>    
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['datecreated']; ?></td>
                    <td><?php echo $row['dateupdated']; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>