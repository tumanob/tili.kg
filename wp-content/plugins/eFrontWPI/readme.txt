Author  L. Sheed
Email	Lawrence@computersolutions.cn
URL		http://www.computersolutions.cn/blog/2010/09/efrontwpi-wordpress-integration-plugin-for-efront/
Date	02 / Sep / 2010
Version 1.0


Overview     *************************************************************************



This plugin provides single login functionality for Wordpress / BBPress and eFront

It will optionally create an eFront user if one does not exist (option to set this in plugin settings).
For login to function the Wordpress user and password must be the same as the eFront username and password.

Plugin is based on the v1 api provided by eFront.  Should work with v2 also.
To use the v2 api, simply change the eFront URL to the appropriate URI


IMPORTANT NOTE:

This plugin requires cURL (php5_curl) to be installed as a pre-requisite.

Instructions *************************************************************************



Upload this folder into your wordpress / bbpress plugins folder.

Typically ->
[your wordpress folder]/wp-content/plugins/

Activate plugin, then go to eFrontWPI Plugin Settings, and enter the appropriate data:

* eFront URL should be the full URI for the eFront API on your server.
eg 
   http://www.yourservername.com/eFront/www/api.php
or
   http://www.yourservername.com/eFront/www/api2.php

* Admin Login 
The eFront Admin user (suggest create a user for the API to use)

* Admin Pass
The eFront Admin user pass

* Create User checkbox
Check if you want a user automatically created.

* Current eFront token 
This is a read only field which shows the current eFront API token (if any).
This is a good way to check if the plugin is working - if you have a token, it should be working.


