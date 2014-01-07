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

$colname_rs_detail = "-1";
if (isset($_GET['id'])) {
  $colname_rs_detail = $_GET['id'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_detail = sprintf("SELECT * FROM shops WHERE ID = %s", GetSQLValueString($colname_rs_detail, "int"));
$rs_detail = mysql_query($query_rs_detail, $publish_conn) or die(mysql_error());
$row_rs_detail = mysql_fetch_assoc($rs_detail);
$totalRows_rs_detail = mysql_num_rows($rs_detail);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>



<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<style type="text/css">
#ShopName {
	font-size: x-large;
	font-weight: bold;
}
#left {
	float: left;
}
</style>

<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
 
</head>

<body>

<div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup" >
      <li class="TabbedPanelsTab" tabindex="0" >簡介</li>
      <li class="TabbedPanelsTab" tabindex="0">菜單</li>
      <li class="TabbedPanelsTab" tabindex="0">評價</li>
      <li class="TabbedPanelsTab" tabindex="0">好康優惠</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent" ><span id="ShopName" ><?php echo $row_rs_detail['name']; ?></span><br /><div id='left'><img src='images/<?php echo $row_rs_detail['ID']; ?>.png' width='683 height='316 /></div><div><iframe id'map' src='<?php echo $row_rs_detail['Google map']; ?>' width='600' height='450' frameborder='0' style='border:0'></iframe></div></div>
      <div class="TabbedPanelsContent" id="menu">尚無內容</div>
      <div class="TabbedPanelsContent">尚無內容</div>
      <div class="TabbedPanelsContent">尚無內容</div>
     </div>
</div>
 
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>
<?php
mysql_free_result($rs_detail);
?>
