<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ProjectConnection = "localhost";
$database_ProjectConnection = "ProjectSite";
$username_ProjectConnection = "root";
$password_ProjectConnection = "12345";
$ProjectConnection = mysql_pconnect($hostname_ProjectConnection, $username_ProjectConnection, $password_ProjectConnection) or trigger_error(mysql_error(),E_USER_ERROR); 
?>