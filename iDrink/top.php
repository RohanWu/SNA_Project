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

mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_index = "SELECT * FROM shops";
$rs_index = mysql_query($query_rs_index, $publish_conn) or die(mysql_error());
$row_rs_index = mysql_fetch_assoc($rs_index);
$totalRows_rs_index = mysql_num_rows($rs_index);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />




<title>iDrink</title>

<!--<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>-->

 

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">

 

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  
 // var index=document.getElementById("jumpMenu").selectedIndex;
 
  
  
 /* document.getElementById("map").src=selObj.value;*/

	 
 
	//document.getElementById("mainFrame").height=1500;
//	document.getElementById("mainFrame").src=selObj.options[selObj.selectedIndex].value;
if(document.getElementById("jumpMenu").selectedIndex==0)
     {
	   parent.frames['mainFrame'].location.href= "promotion.html" ;
	    window.parent.document.title = "iDrink";
	 }

else
	 parent.frames['mainFrame'].location.href=selObj.options[selObj.selectedIndex].value;
	 
  
}

function resetMenu()
{
	 
  document.getElementById("jumpMenu").selectedIndex=0;
}


</script>


</script>


<style type="text/css">
#FbApi{
	background-color: #E0E1E6;  
}
#my-like-btn{
	float: right;
	 
}


#search {
	float: right;	/*margin-left: 777px;	*/
	
}
</style>

 
<link rel="shortcut icon" href="images/webIcon.ico" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body onload="resetMenu()" background="images/background.jpg">



<a href="http://idrink.comoj.com/" target="_parent"  ><img src="images/iDrink.gif" width="214" height="50" hspace="50"  /></a> 
 <br />
<form action="result.php" method="get" name="search" target="mainFrame" id="search">
  <span id="sprytextfield1">
  <input name="target"  type="text" id="SearchTarget"/>
  <span class="textfieldRequiredMsg">請輸入店名</span></span>
  <input   name="name"  type="submit" value="搜尋"  onclick="resetMenu()" />
</form>
 
  <br />
  <form name="form" id="form"> 
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
    <option selected="selected" value="" >飲料店</option>
    <?php
do {  
?>
    <option value="detail.php?id=<?php echo $row_rs_index['ID']?>"><?php echo $row_rs_index['name']?></option>
    <?php
} while ($row_rs_index = mysql_fetch_assoc($rs_index));
  $rows = mysql_num_rows($rs_index);
  if($rows > 0) {
      mysql_data_seek($rs_index, 0);
	  $row_rs_index = mysql_fetch_assoc($rs_index);
  }
?>
  </select>
</form>


 
<br />
 


<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($rs_index);
?>
