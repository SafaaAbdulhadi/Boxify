<html>
<body>
<?php require_once('Connections/ProjectConnection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_search = "-1";
if (isset($_GET['lat'])) {
  $colname_search = $_GET['lat'];
}
mysql_select_db($database_ProjectConnection, $ProjectConnection);
$query_search = sprintf("SELECT * FROM service WHERE lat = %s ORDER BY firstName ASC", GetSQLValueString($colname_search, "double"));
$search = mysql_query($query_search, $ProjectConnection) or die(mysql_error());
$row_search = mysql_fetch_assoc($search);
$totalRows_search = mysql_num_rows($search);
?>
<?php 
require('Connections/ProjectConnection.php');


$lat = $_GET[w1]; 
$lng =$_GET[w2]; 

echo $lng;






?>
<?php
mysql_free_result($userData);

mysql_free_result($search);
?>
</body>
</html>