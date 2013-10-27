<?php
require_once('../../includes/connection.inc.php');
// connect to MySQL
$conn = dbConnect('write');
// set default values
$col = 'email';
$dir = 'ASC';
// create arrays of permitted values
$columns = array('email','nickname','lastlogin', 'datecreated');
$direction = array('ASC', 'DESC');
// if the form has been submitted, use only expected values
if (isset($_GET['column']) && in_array($_GET['column'], $columns)) {
  $col = $_GET['column'];
}
if (isset($_GET['direction']) && in_array($_GET['direction'], $direction)) {
  $dir = $_GET['direction'];
}
// prepare the SQL query
$sql = "SELECT email, nickname, lastlogin, datecreated FROM user
        ORDER BY $col $dir";
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
    <th>Email</th>
    <th>Nickname</th>
    <th>Last Login</th>
    <th>Date Created</th>
    <th></th>
    <th></th>
 </tr>
<?php while ($row = $result->fetch_assoc()) { ?>
  <tr>
	<td><?php echo $row['email']; ?></td>
    <td><?php echo $row['nickname']; ?></td>    
    <td><?php echo $row['lastlogin']; ?></td>
    <td><?php echo $row['datecreated']; ?></td>
    <td><a href="../../includes/update_user_mysqli.inc.php?email=<?php echo $row['email']; ?>">EDIT</a></td>
    <td><a href="../../includes/delete_user_mysqli.inc.php?email=<?php echo $row['email']; ?>">DELETE</a></td>
  </tr>
<?php } ?>
</table>
</div>
