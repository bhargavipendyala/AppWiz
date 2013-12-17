<?php
require_once("includes/dbconfig.php");
if(isset($_SESSION['retailer_id'])){
header("location:dashboard.php");
exit;
}
if((isset($_REQUEST['act']))&&($_REQUEST['act']=="login")){
	extract($_POST);
	$chkQry = mysql_query("select * from aw_retailers where ((username='".$username."' and password='".md5($password)."') or (secondary_user='".$username."' and secondary_pwd='".md5($password)."')) and status=1");
	$chkCnt = mysql_num_rows($chkQry);
	if($chkCnt>0){
		$retailerInfo = mysql_fetch_array($chkQry);
		$lastLogin = date('Y-m-d H:i:s');
		if($retailerInfo['last_login']=='0000-00-00 00:00:00'){
			$_SESSION['last_login'] = $lastLogin;
		}else{
			$_SESSION['last_login'] = $retailerInfo['last_login'];
		}
		$_SESSION['retailer_id'] = $retailerInfo['id'];
		
		mysql_query("update aw_retailers set last_login=now() where id='".$retailerInfo['id']."'");
		header("location:dashboard.php");
		exit;
	}else{
		header("location:index.php?msg=err");
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>App Wiz</title>
<?php require_once("includes/scripts.php"); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#frm").validate();
		/*$("#frm").validate({
			rules: {
				emailId: {
					required: true,
					email: true
				}
			},
			messages: {
				email: "Please enter a valid email address"
			}
		});*/
	});
</script>
<style type="text/css">
#wrappar{
height:666px;
}
@-moz-document url-prefix() { 
  #wrappar {
	 height:664px;
  }
}

</style>
</head>
<body>
  <div id="wrappar">
  <div id="main-container">
  <div class="header-con">
  <?php require_once("includes/header.php");?>
	</div>
     <div class="body-con">
     	<div class="left-con">
        <div class="register-area"><img src="images/register.gif" border="0" alt="register" usemap="#registermap"/>
<map name="registermap" id="registermap"><area shape="rect" coords="228,157,497,236" href="register.php" target="_self" alt="register" />
</map></div>
        </div>
        <div class="right-con">
        <div class="log-area">
        <h2>EXISTING MERCHANTS</h2>
        <h1>SIGN IN HERE</h1>
        <div class="login-con">        
    <?php if((isset($_REQUEST['msg']))&&($_REQUEST['msg']=="err")){?>
    <div class="error-msg" id="msg_error">The User Id or Password you have entered is Incorrect.</div>
    <?php }?>
    <form action=" " method="post" name="frm" id="frm" >
    <input type="hidden" name="act" id="act" value="login" />
      <div class="log-row required">
        <label style="line-height:26px;">
         User Id
          <span class="required-indicator">*</span>
        </label>
        <span class="req-separator">:</span>
        <input type="text" name="username" id="username" value="" class="txtfield required" maxlength="50"  style="line-height:30px\0/;" />
      </div>
      <div class="log-row required">
        <label style="line-height:26px;">
          Password
          <span class="required-indicator">*</span>
        </label>
        <span class="req-separator">:</span>
        <input type="password" name="password" id="password" value="" class="txtfield required" maxlength="50"  style="line-height:30px\0/;" />
      </div>
      <div class="button-con" style="padding-left:168px; margin-top:12px;">
        <input name="login" type="submit" value="Sign In" class="ybtn" />
      </div>
    </form>
  </div>
        </div>
        </div>
     </div>
</div></div>
</body>
</html>
