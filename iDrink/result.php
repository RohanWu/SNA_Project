<?php require_once('Connections/publish_conn.php'); ?>
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

$colname_rs_search = "-1";
if (isset($_GET['target'])&& ($_GET['which']=="shop")) {
  $colname_rs_search = $_GET['target'] ;
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_search = sprintf("SELECT * FROM shops WHERE name LIKE %s", GetSQLValueString("%" . $colname_rs_search . "%", "text"));
$rs_search = mysql_query($query_rs_search, $publish_conn) or die(mysql_error());
$row_rs_search = mysql_fetch_assoc($rs_search);
$totalRows_rs_search = "-1";
if (isset($_GET['target'])&& ($_GET['which']=="shop")) {
  $totalRows_rs_search = $_GET['target'];
}

 
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_search = sprintf("SELECT * FROM shops WHERE name LIKE %s", GetSQLValueString("%" . $colname_rs_search . "%", "text"));
$rs_search = mysql_query($query_rs_search, $publish_conn) or die(mysql_error());
$row_rs_search = mysql_fetch_assoc($rs_search);
$totalRows_rs_search = mysql_num_rows($rs_search);

$colname_rs_searchMenu = "-1";
if (isset($_GET['target'])&& ($_GET['which']=="menu")) {
  $colname_rs_searchMenu = $_GET['target'] ;
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_searchMenu = sprintf("SELECT *  FROM Menu INNER JOIN shops ON Menu.shopID=shops.ID HAVING Menu.name = %s", GetSQLValueString($colname_rs_searchMenu, "text"));
$rs_searchMenu = mysql_query($query_rs_searchMenu, $publish_conn) or die(mysql_error());
$row_rs_searchMenu = mysql_fetch_assoc($rs_searchMenu);
$totalRows_rs_searchMenu = mysql_num_rows($rs_searchMenu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>搜尋結果</title>

</head>

<body background="images/background.jpg">
<h1>搜尋結果：</h1>
<h2>

<?php


if($_GET['which']=="shop")
echo "<a href='detail.php?id=".$row_rs_search['ID']."'>".$row_rs_search['name'].$row_rs_search['branch']."</a>";


else if($_GET['which']=="menu")
echo  "<a href='detail.php?id=".$row_rs_searchMenu['shopID']."'>".$row_rs_searchMenu['name']."</a>";

?>


</h2>
</body>
</html>
<?php
mysql_free_result($rs_search);

mysql_free_result($rs_searchMenu);
?>
