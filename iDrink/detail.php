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
	
  $insertSQL = sprintf("INSERT INTO evaluation (menuID, grade) VALUES (%s, %s)",
                       GetSQLValueString($_POST['menuID'], "int"),
                       GetSQLValueString($_POST['select'], "int"));

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

function ShowFBID(){
	alert("臣亮言，先帝創業未半，而中道崩殂。今天下三分，益州疲弊，此誠危急存亡之秋也。然侍衛之臣，不懈於內；忠志之士，忘身於外者，蓋追先帝之殊遇，欲報之於陛下也。誠宜開張聖聽，以光先帝遺德，恢弘志士之氣；不宜妄自菲薄，引喻失義，以塞忠諫之路也。宮中府中，俱為體，陟罰臧否，不宜異同。若有作姦犯科，及為忠善者，宜付有司，論其刑賞，以昭陛下平明之治，不宜篇私，使內外異法也。侍中、侍郎郭攸之、費褘、董允等，此皆良實，志慮忠純，是以先帝簡拔以遺陛下。愚以為宮中之事，事無大小，悉以咨之，然後施行，必能裨補闕漏，有所廣益。將軍向寵，性行淑均，曉暢軍事，試用於昔日，先帝稱之曰「能」，是以眾議舉寵為督。愚以為營中之事，悉以咨之，必能使行陣和睦，優劣得所。親賢臣，遠小人，此先漢所以興隆也；親小人，遠賢臣，此後漢所以傾頹也。先帝在時，每與臣論此事，未嘗不嘆息痛恨於桓、靈也。侍中、尚書、長史；參軍，此悉貞良死節之臣也，願陛下親之信之，則漢室之隆，可計日而待也。臣本布衣，躬耕於南陽，苟全性命於亂世，不求聞達於諸侯。先帝不以臣卑鄙，猥自枉屈，三顧臣於草廬之中，諮臣以當世之事，由是感激，遂許先帝以驅馳。後值傾覆，受任於敗軍之際，奉命於危難之間，爾來二十有一年矣！先帝知臣謹慎，故臨崩寄臣以大事也。受命以來，夙夜憂勤，恐託付不效，以傷先帝之明。故五月渡瀘，深入不毛。今南方已定，兵甲已足，當獎率三軍，北定中原，庶竭駑鈍，攘除姦凶，興復漢室，還於舊都；此臣所以報先帝而忠陛下之職分也。至於斟酌損益，進盡忠言，則攸之、褘、允之任也。願陛下託臣以討賊興復之效；不效，則治臣之罪，以告先帝之靈。若無興德之言，則戮允等，以彰其慢。陛下亦宜自課，以諮諏善道，察納雅言，深追先帝遺詔，臣不勝受恩感激。今當遠離，臨表涕零，不知所云。");
   alert(u_fb_id);
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
      <button type="button" onclick="ShowFBID()">無</button>
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
