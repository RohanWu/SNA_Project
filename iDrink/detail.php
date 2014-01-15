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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "evalution")) {
	
  $insertSQL = sprintf("INSERT INTO evaluation (menuID, grade ) VALUES (%s, %s )",
                       GetSQLValueString($_POST['menuID'], "int"),
                       GetSQLValueString($_POST['select'], "int")
					   );

  mysql_select_db($database_publish_conn, $publish_conn);
  $Result1 = mysql_query($insertSQL, $publish_conn) or die(mysql_error());
}

/*rs_detail*/
$colname_rs_detail = "-1";
if (isset($_GET['id'])) {
  $colname_rs_detail = $_GET['id'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_detail = sprintf("SELECT * FROM shops WHERE ID = %s", GetSQLValueString($colname_rs_detail, "int"));
$rs_detail = mysql_query($query_rs_detail, $publish_conn) or die(mysql_error());
$row_rs_detail = mysql_fetch_assoc($rs_detail);
$totalRows_rs_detail = mysql_num_rows($rs_detail);
/*end of rs_detail*/

/*re_menu*/
$colname_rs_menu = "-1";
if (isset($_GET['id'])) {
  $colname_rs_menu = $_GET['id'];
}
mysql_select_db($database_publish_conn, $publish_conn);
$query_rs_menu = sprintf("SELECT * , AVG(evaluation.grade) AS avgGrade,   Count(*) AS size FROM Menu LEFT JOIN evaluation ON Menu.ID=evaluation.menuID GROUP BY Menu.ID HAVING shopID = %s", GetSQLValueString($colname_rs_menu, "int"));
$rs_menu = mysql_query($query_rs_menu, $publish_conn) or die(mysql_error());
$row_rs_menu = mysql_fetch_assoc($rs_menu);
$totalRows_rs_menu = mysql_num_rows($rs_menu);
/*end of rs_menu*/

/*rs_avgGrade*/

/*end of rs_avgGrade*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_rs_detail['name']; ?></title>

<!--Facebook API-->
<meta property="og:title" content="iDrink, fantastic evaluation" />
<meta property="og:type" content="website" />
<meta property="og:image" content="http://idrink.comoj.com/images/iDrink.gif" />
<meta property="og:url" content="http://idrink.comoj.com/detail.php?id=<?php echo $row_rs_detail['ID']; ?>" />
<meta property="og:description" content="Wonder whether the drink you have is awesome or awful? Visit iDrink, and you will get the point." />
<meta property="fb:app_id" content="716678975030552" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">

<!--End of Facebook API-->

<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script type="text/javascript">
function bodyOnLoad()
{
	 
     window.parent.document.title = "iDrink - <?php echo $row_rs_detail['name']; ?>";
	  
	  FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    // the user is logged in and has authenticated your
    // app, and response.authResponse supplies
    // the user's ID, a valid access token, a signed
    // request, and the time the access token 
    // and signed request each expire
   // document.getElementById("my-login-button").innerHTML="已登入";
	document.getElementById("my-login-button").style.visibility="hidden";
	document.getElementById("my-logout-button").style.visibility="visible";
	document.getElementById("my-profile-picture").style.visibility="visivle";
	
	 
  } else if (response.status === 'not_authorized') {
    // the user is logged in to Facebook, 
    // but has not authenticated your app
  } else {
    // the user isn't logged in to Facebook.
  }
 });
 
 
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


</script>
<style type="text/css">
#ShopName {
	font-size: xx-large;
	font-weight: bold;
}
#left {
	float: left;
}
#grade {
	text-align: center;
}
#my-login-button {
	margin-left: 1040px;
}
#my-logout-button {
	visibility: hidden;
}
#my-profile-picture{
visibility: hidden;
}
</style>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>

<body background="images/background.jpg" onload="bodyOnLoad()">

<!--Facebook API--> 

<!-- BLOCK: FB SDK 初始化 --> 
<script>
            window.fbAsyncInit = function() {
                // 宣告 FB JS SDK
                FB.init({
                    appId      : 716678975030552,    // App ID from the app dashboard
                     cookie     : true,   
                    status     : true,             // Check Facebook Login status
                    xfbml      : true              // Look for social plugins on the page
                    });
                        
                    // Additional initialization code such as adding Event Listeners goes here
					  window.fbLoaded();
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

<div >
  <button  id="my-login-button" class="btn btn-primary" >Facebook登入</button>
  <img id="my-profile-picture"   src="" alt=""> 
  <button id="my-logout-button" class="btn btn-primary">登出</button>
  </div>
<script id="my-script-playground">
        window.fbLoaded = function(){
		     // define the events when login status changed.
			 
            FB.Event.subscribe('auth.login', function(response) {
                // when user has been logged in, this block will be triggered.
                var msg = "You're logged in.";
                $("#my-login-message").html(msg);
                console.log("Your login response:");
                console.log(response);
                
				//document.getElementById("my-login-button").innerHTML="已登入";
 document.getElementById("my-login-button").style.visibility="hidden";
 document.getElementById("my-logout-button").style.visibility="visible";
 document.getElementById("my-profile-picture").style.visibility="visible";
 
                // fetch the profile
                fetch_my_profile();
            });

            // define the action when user clicked the login button.
            $("#my-login-button").click(function(){
				
                FB.login();
            });
			
			$("#my-logout-button").click(function(){
				
                FB.logout();
				document.getElementById("my-login-button").style.visibility="visible";
				document.getElementById("my-logout-button").style.visibility="hidden";
				document.getElementById("my-profile-picture").style.visibility="hidden";
            });

            var fetch_my_profile = function () {				
				FB.api('/me', function(response) {
                    var my_facebook_id = response.id;
					 
				});
				FB.api('/me/picture', function(response) {
                 var my_picture_url = response.data.url;
                 $("#my-profile-picture").attr('src', my_picture_url);
                  });
			};
		};
        </script> 

<!--End of Facebook API-->
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup" >
    <li class="TabbedPanelsTab" tabindex="0" >簡介</li>
    <li class="TabbedPanelsTab" tabindex="0" >菜單</li>
     
    <!-- BLOCK: FB功能介面 --> 
    
    <!-- ENDBLOCK: FB功能介面 -->
    <li class="TabbedPanelsTab" tabindex="0">其他資訊</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent" ><span id="ShopName" ><?php echo $row_rs_detail['name']; ?></span> <br />
      <div id='left'><img src='images/<?php echo $row_rs_detail['ID']; ?>.png' width='683 height='316 /><br />
        <br />
        <input name="按鈕" type="button" onclick="MM_goToURL('parent','<?php echo $row_rs_detail['URL']; ?>')"    value="官方網站" style="width:80px;height:40px; margin-left:300px"/>
      </div>
      <div>
        <iframe id="id"'map' src='<?php echo $row_rs_detail['Google map']; ?>' width='600' height='450' frameborder='0' style='border:0'></iframe>
        
        <!--FB Like Button-->
        
        <div id="my-like-btn" class="col-md-4"> 
          <!-- Like Button -->
          <div class="fb-like" data-href="http://idrink.comoj.com/detail.php?id=<?php echo $row_rs_detail['ID']; ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        </div>
      </div>
      <!--End of FB Like Button--> 
    </div>
    <div class="TabbedPanelsContent" id="menu">
    <div style="width:500px; float:left">
      <table   border="1">
        <tr>
          <th    scope="col">飲料</th>
          <th     scope="col">評價</th>
          <th    scope="col">你覺得 </th>
        </tr>
        <?php    do { ?>
          <?php if ($totalRows_rs_menu > 0) { // Show if recordset not empty ?>
            <tr>
              <td><?php echo $row_rs_menu['name']; ?></td>
              <?php 	 
	if($row_rs_menu['avgGrade'] >4.5){		
	   echo "<td id='grade' bgcolor='#00CCFF'>".sprintf("%.1f",$row_rs_menu['avgGrade'])."(潮好喝der)";}
	else if($row_rs_menu['avgGrade']>3.5)
	   echo "<td id='grade' bgcolor='#99cc00'>".sprintf("%.1f",$row_rs_menu['avgGrade'])."(好喝)";
	else if($row_rs_menu['avgGrade']>2.5)
	   echo "<td id='grade' bgcolor='#ffcf02'>".sprintf("%.1f",$row_rs_menu['avgGrade'])."(普普)";
	else if($row_rs_menu['avgGrade']>1.5)
	   echo "<td id='grade' bgcolor='#ff9f02'>".sprintf("%.1f",$row_rs_menu['avgGrade'])."(難喝)";
	else 
	   echo "<td id='grade' bgcolor='#ff6f31'>".sprintf("%.1f",$row_rs_menu['avgGrade'])."(超難喝)";
	    
	echo	"/".$row_rs_menu['size']."人評過分</td>";	  ?>
              <td><form action="<?php echo $editFormAction; ?>" method="post" name="evalution" id="evalution"  >
                  <input name="menuID" type="hidden" value="<?php echo $row_rs_menu['menuID']; ?>" />
                  <input name="FBID" type="hidden" />
                  <select name="select" id="select">
                    <option selected="selected"></option>
                    <option value="1">超難喝</option>
                    <option value="2">難喝</option>
                    <option value="3">普普</option>
                    <option value="4">好喝</option>
                    <option value="5">超好喝der</option>
                  </select>
                  <input   type="submit"  />
                  <input type="hidden" name="MM_insert" value="evalution" />
                </form></td>
            </tr>
            <?php } // Show if recordset not empty ?>
          <?php 
		    } while ($row_rs_menu = mysql_fetch_assoc($rs_menu)); ?>
      </table>
      </div>
      <div   class="fb-comments" data-href="http://idrink.comoj.com/detail.php?id=<?php echo $row_rs_detail['ID']; ?>"   data-colorscheme="light"></div>
     
    </div>
    
      
    <div class="TabbedPanelsContent">
      無
    </div>
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
