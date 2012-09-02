<?php
	if (!current_user_can('manage_options'))  {
   	wp_die( __('You do not have sufficient permissions to access this page.') );
  	}
?><html>
<head>
<style>
div.container{
	width: 950px;
}
div.simple_style{
	padding: 5px;
	background: #EBEBEB;
	margin: 10px;
	width:450px;
	height:375px;
	font-family: Calibri,Helvetica,Arial,sans-serif;
	float: left; 
}
div.simple_style_test{
	padding: 5px;
	margin: 0px 10px 10px 10px;
	background: #EBEBEB;
	width: 450px;
	height: 280px;
	font-family: Calibri,Helvetica,Arial,sans-serif;
	float: left;
}
div.information_pane{
	height:280px;
	width: 450px;
	padding: 5px;
	background: #EBEBEB;
	margin: 0px 10px 10px 0;
	font-family: Calibri,Helvetica,Arial,sans-serif;
	float:left;
}
div.advanced{
	padding: 5px;
	background: #EBEBEB;
	margin: 10px 10px 10px 0px;
	width:450px;
	height:375px;
	font-family: Calibri,Helvetica,Arial,sans-serif;
	float: left; 
}
div.banner{
	padding 5px;
	margin-left: 10px;
	margin-top: 15px;
	font-family: Calibri,Helvetica,Arial,sans-serif;
}
h1{
	margin: 0;
}
h2{
	margin: 0;
}
h3{
	margin: 0;
}
h4{
	margin: 0;
}
p{
	margin-bottom: 0;
}
</style>
</head>
<?php 

//Where are we?
$this_page = $_SERVER['PHP_SELF'].'?page='.$_GET['page'];


//If admin options updated (uses hidden field)
if ($_POST['stage'] == 'process') 
{
    update_option('eFrontWPI_path', $_POST['eFrontWPI_path']);
	update_option('eFrontWPI_admin_user', $_POST['eFrontWPI_admin_user']);
	update_option('eFrontWPI_admin_pass', $_POST['eFrontWPI_admin_pass']);
	update_option('eFrontWPI_token',$_POST['eFrontWPI_token']);
	update_option('eFrontWPI_domain',$_POST['eFrontWPI_domain']);

	if(isset($_POST['eFrontWPI_create_login']))
	{
		update_option("eFrontWPI_create_login", $_POST['eFrontWPI_create_login']);
	}
	else
	{
		update_option("eFrontWPI_create_login", "no");
	}
	$updated=1;
}


//Get current settings
$eFrontWPI_options=array (
	"path"=>get_option("eFrontWPI_path"),
	"admin_user"=>get_option("eFrontWPI_admin_user"),
	"admin_pass"=>get_option("eFrontWPI_admin_pass"),
	"create_login"=>get_option("eFrontWPI_create_login"),
	"token"=>get_option("eFrontWPI_token"),
	"domain"=>get_option("eFrontWPI_domain")
	);
?>
<body>
<div class="container">
<div class="banner"><h1>eFrontWPI Login Integration</h1></div>
<form style="display::inline;" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&updated=true">
<div class="simple_style">
	<h2>Settings</h2>
	<p><strong>Path or URL to eFront</strong><br />
	<input name="eFrontWPI_path" type="text" value="<?php  echo $eFrontWPI_options['path']; ?>" size="80" /><br />
	*Example: http://www.yourservername.com/eFront/www/api.php
	  </p>
	 <p><strong>eFront Admin Login:</strong><br />
	<input name="eFrontWPI_admin_user" type="text" value="<?php  echo $eFrontWPI_options['admin_user']; ?>" size="20" /><br />
	  </p>
	<p><strong>eFront Admin Pass:</strong><br />
	<input name="eFrontWPI_admin_pass" type="text" value="<?php  echo $eFrontWPI_options['admin_pass']; ?>" size="20" /><br />
	  </p>
	<p><strong>Should I try and create an equivalent eFront user on a successful wordpress login?:</strong><br />
		<input name="eFrontWPI_create_login" type="checkbox" value="yes" id="eFrontWPI_create_login" <?php if($eFrontWPI_options['create_login']=="yes"){echo "checked";}?>>
	</p>
	<?php if ($updated==1) {	 echo "<p><font color='green'><strong>Saved settings</strong></font></p>"; }  ?>
	<input type="hidden" name="stage" value="process" />
	<input type="submit" name="button_submit" value="<?php _e('Update Options', 'eFrontWPI') ?>" />
	
	<p><strong>Current eFront Token:</strong><br />
	<input name="eFrontWPI_token" type="text" value="<?php  echo $eFrontWPI_options['token']; ?>" size="50" /><br />
	</p>

    <p><strong>Cookie Domain:</strong><br />
    <input name="eFrontWPI_domain" type="text" value="<?php  echo $eFrontWPI_options['domain']; ?>" size="50" /><br />
    </p>
	
</div>
</form>

</div> <!--End Container Div -->

</body>
</html>