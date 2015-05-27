<?php 
 
$options = array(

	array( "label" => __( "General Settings", 'wp-lock' ),
		"name" => "general",
		"type" => "section"),
		
	array( "type" => "open"),
	
		array(  
			"type" => "text",
			"name" => "Default Site Image",
			"desc" => "Default site image used if no thumbnail exists in posts. Default site image must be at least 200&times;200 pixels in size.",
			"id" => "default_logo",
			"std" => ""
		),
		
		array(  
			"type" => "textarea",
			"name" => "Homepage Description",
			"desc" => "This description is used on site homepage shares.",
			"id" => "home_desc",
			"std" => ""
		),
		
		array(  
			"type" => "text",
			"name" => "Admins (Optional)",
			"desc" => "List of user ids associated with this site separated with comma. (e.g. USER_ID1,USER_ID2).",
			"id" => "site_admins",
			"std" => ""
		),

		array(  
			"type" => "text",
			"name" => "App ID (Optional)",
			"desc" => "Application ID associated with this site. You can <a href=\"https://developers.facebook.com/apps/\">get your app id here</a>. ",
			"id" => "app_id",
			"std" => ""
		),
		
		array(
		"desc" => "If you want to add a debug link to your posts you can use following code in your single.php templates: ".
		'<pre>&lt;?php if( function_exists("sfmt_debug_link") ){ echo "&lt;a href=\"" . sfmt_debug_link() . "\"&gt;Debug Meta Tags&lt;/a&gt;"; } ?></pre>',
		"type" => "paragraph"
		),
	
	array( "type" => "close")

);