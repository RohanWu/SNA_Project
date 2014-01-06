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

$colname_re_search = "-1";
if (isset($_GET['target'])) {
  $colname_re_search = $_GET['target'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_re_search = sprintf("SELECT * FROM shops WHERE name LIKE %s", GetSQLValueString($colname_re_search, "text"));

$re_search = mysql_query($query_re_search, $publish_conn) or die(mysql_error());


$row_re_search = mysql_fetch_assoc($re_search);
$totalRows_re_search = mysql_num_rows($re_search);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_re_search['name']; ?></title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#search {
	margin-left: 600px;	
}
#ShopName {
	font-size: x-large;
	font-weight: bold;
}
#left {
	float: left;
}
</style>
</head>

<body>
<a href="http://idrink.comoj.com/"  ><img src="images/iDrink.gif" width="214" height="50" hspace="50"  /></a> 
 
<form action="result.php" method="get" name="search" id="search">
<input name="target"  type="text" id="SearchTarget"/> 
<input   name="name"  type="submit" value="搜尋"    />
</form>

<hr />
 <div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup" >
      <li class="TabbedPanelsTab" tabindex="0" >簡介</li>
      <li class="TabbedPanelsTab" tabindex="0">菜單</li>
      <li class="TabbedPanelsTab" tabindex="0">評價</li>
      <li class="TabbedPanelsTab" tabindex="0">好康優惠</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent" ><span id="ShopName" ><?php echo $row_re_search['name']; ?> </span><br /><div id='left'><img src='images/<?php echo $row_re_search['ID']; ?>.png' width='683 height='316 /></div><div><iframe id'map' src='<?php echo $row_re_search['Google map']; ?>' width='600' height='450' frameborder='0' style='border:0'></iframe></div></div>
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
mysql_free_result($re_search);
?>
