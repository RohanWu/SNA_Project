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

$colname_rs_menu = "-1";
if (isset($_GET['id'])) {
  $colname_rs_menu = $_GET['id'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_menu = sprintf("SELECT * FROM Menu WHERE shopID = %s", GetSQLValueString($colname_rs_menu, "int"));
$rs_menu = mysql_query($query_rs_menu, $publish_conn) or die(mysql_error());
$row_rs_menu = mysql_fetch_assoc($rs_menu);
$totalRows_rs_menu = mysql_num_rows($rs_menu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_rs_detail['name']; ?></title>


<!--Facebook API--> 
<script src="./FB_id.js"></script>
        <script src="../FB_id.js"></script>
        
<!--End of Facebook API--> 


<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<style type="text/css">
#ShopName {
	font-size: x-large;
	font-weight: bold;
}
#left {
	float: left;
}
#grade {
	text-align: center;
}
</style>

<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
 
</head>

<body background="images/background.jpg">

<!--Facebook API-->
<!-- BLOCK: FB SDK 初始化 -->
        <div id="fb-root"></div>
        <script>
            window.fbAsyncInit = function() {
                // 宣告 FB JS SDK
                FB.init({
                    appId      : FacebookAppId,    // App ID from the app dashboard
                    cookie     : true,             // Allowed server-side to fetch fb auth cookie
                    status     : true,             // Check Facebook Login status
                    xfbml      : true              // Look for social plugins on the page
                    });
                        
                    // Additional initialization code such as adding Event Listeners goes here
            };
        
          
			 // 連結iDrink app
            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=716678975030552";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <!-- ENDBLOCK: FB SDK 初始化 -->
        
     
<!--End of Facebook API-->

<div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup" >
      <li class="TabbedPanelsTab" tabindex="0" >簡介</li>
      <li class="TabbedPanelsTab" tabindex="0" >菜單</li>
      <li class="TabbedPanelsTab" tabindex="0">評論</li>  
      <!-- BLOCK: FB功能介面 -->
        
         
         <!-- ENDBLOCK: FB功能介面 -->
      <li class="TabbedPanelsTab" tabindex="0">好康優惠</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent" ><span id="ShopName" ><?php echo $row_rs_detail['name']; ?></span><br /><div id='left'><img src='images/<?php echo $row_rs_detail['ID']; ?>.png' width='683 height='316 /></div><div><iframe id'map' src='<?php echo $row_rs_detail['Google map']; ?>' width='600' height='450' frameborder='0' style='border:0'></iframe>
       <!--FB Like Button-->
 
<div id="my-like-btn" class="col-md-4">
                <!-- Like Button -->
               <div class="fb-like" data-href="http://idrink.comoj.com/detail.php?id=<?php echo $row_rs_detail['ID']; ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            </div>
 </div>
 <!--End of FB Like Button-->    
      </div> 
      <div class="TabbedPanelsContent" id="menu">        
       <table width="414" border="1">
  <tr>
    <th width="102" scope="col">飲料</th>
    <th   scope="col">評價</th>
    <th  scope="col">你覺得 </th>
    
  </tr>
  <?php    do { ?>
      <?php if ($totalRows_rs_menu > 0) { // Show if recordset not empty ?>
  <tr>
    
    <td><?php echo $row_rs_menu['name']; ?></td>
    <td id="grade"> <?php echo $row_rs_menu['evaluation']; ?> </td>
    
    
    <td> 
    <form name="evalution" id="evalution"> 
    <select name="select" id="select">
    <option selected="selected"></option>
<option>超難喝</option>
      <option>難喝</option>
      <option>普普</option>
      <option>好喝</option>
      <option>超好喝der</option>
    </select>
    <input name="" type="button" value="送出"/></form>
    </td>
    
    
  </tr>
  <?php } // Show if recordset not empty ?>
<?php 
		    } while ($row_rs_menu = mysql_fetch_assoc($rs_menu)); ?>
      </table>
    </div>
      <div class="TabbedPanelsContent"> <div class="fb-comments" data-href="http://idrink.comoj.com/detail.php?id=<?php echo $row_rs_detail['ID']; ?>" data-numposts="5" data-colorscheme="light"></div></div>
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

mysql_free_result($rs_menu);
?>
