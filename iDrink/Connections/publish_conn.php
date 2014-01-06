<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_publish_conn = "mysql5.000webhost.com";
$database_publish_conn = "a9825883_iDrink";
$username_publish_conn = "a9825883_Billy";
$password_publish_conn = "nccu1007030";
$publish_conn = mysql_pconnect($hostname_publish_conn, $username_publish_conn, $password_publish_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES utf8");
?>