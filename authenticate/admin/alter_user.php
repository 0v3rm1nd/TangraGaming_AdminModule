<?php
require_once('../../includes/session_timeout_db.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update User</title>
<link rel="stylesheet" type="text/css" href="../../styles/style.css" />
</head>
<body>
<div id="pagesearch1">
<h1>
Alter Users
</h1>
<a href="admin_home.php">&middot;Admin Home</a>
<h3>
List of users:
</h3>
<?php
require_once('../../includes/search_user.inc.php');
?>
</div>
</body>
</html>