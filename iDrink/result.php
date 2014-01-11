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

$colname_rs_search = "-1";
if (isset($_GET['target'])) {
  $colname_rs_search = $_GET['target'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_search = sprintf("SELECT * FROM shops WHERE name LIKE %s", GetSQLValueString("%" . $colname_rs_search . "%", "text"));
$rs_search = mysql_query($query_rs_search, $publish_conn) or die(mysql_error());
$row_rs_search = mysql_fetch_assoc($rs_search);
$totalRows_rs_search = mysql_num_rows($rs_search);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>搜尋結果</title>

</head>

<body background="images/background.jpg">
<h1>搜尋結果：</h1>
<h2><a href="detail.php?id=<?php echo $row_rs_search['ID']; ?>"><?php echo $row_rs_search['name']; ?>  <?php echo $row_rs_search['branch']; ?></a></h2>
</body>
</html>
<?php
mysql_free_result($rs_search);
?>
