<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>