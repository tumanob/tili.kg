=== Quick Chat ===
Contributors: Marko-M
Donate link:http://www.techytalk.info/quick-chat
Tags: chat, ajax chat, simple chat, live chat
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: trunk

Quick Chat is WordPress chat plugin with support for translation, chat rooms, words filtering, emoticons, user list, gravatars and more.

== Description ==
Quick Chat is WordPress chat plugin with support for chat rooms, bad words filtering, emoticons, chat participants list, gravatars, translation and more. With Quick Chat you are in control because chat messages are saved inside your own WordPress database and maximum chat participant number depends only on your own server capabilities.

*   **New in v2.40**: Quick Chat can instantly translate messages from and to 37 different languages using Bing Translator API
*   Quick Chat allows admin users to instantly ban chat participants IP from chat using Quick Chat interface controls
*   Quick Chat has gravatar support for both embedded chat and sidebar widget
*   Quick Chat has chat participants list for both sidebar and embedded chat
*   Quick Chat site registered users can have their login names reserved if site admin selects this behavior
*   Quick Chat site admins can reserve list of additional chat user names that are off limits for non admin chat users
*   Quick Chat supports incoming/outgoing messages sound notification for HTML5 audio tag enabled browsers
*   Quick Chat supports unlimited number of separate chat rooms on same or separate pages or posts (check FAQ page for more info)
*   Quick Chat has admin user interface for deleting messages
*   Quick Chat can be used as elegant sidebar widget for your web page or blog
*   Quick Chat can be embedded into your post or page using WordPress [quick-chat] shortcode
*   Quick Chat can filter bad words and has user interface for adding and removing bad words
*   Quick Chat is translation friendly (translation template (.pot), Croatian, Italian, Czech, Romanian, Spanish, Dutch, Chinese, Russian, Brazilian Portuguese, Danish and German translations provided)
*   Quick Chat can detect is user logged in to use user login name for chat user name
*   Quick Chat usage can be restricted to the logged in users only
*   Quick Chat appearance is described by separate CSS file
*   Quick Chat comes with quality set of emoticons to spice up your chat experience
*   Quick Chat saves your website bandwidth by sending Ajax requests only when there are new messages

For more information and demo please visit [Quick Chat support page](http://www.TechyTalk.info/quick-chat) at [TechyTalk.info](http://www.TechyTalk.info/).

== Upgrade Notice ==
= 2.00 =
Quick Chat 2.xx has new features like list of online users that couldn't be successfully implemented on top of Quick Chat 1.xx. Because of that it isn't possible to preserve old messages and settings when upgrading Quick Chat 1.xx to Quick Chat 2.xx. If you need your old messages you should backup your data from "wp_quick_chat" table inside your WordPress database using Phpmyadmin before upgrading to Quick Chat 2.xx.

== Installation ==
Installation is quick and easy like Quick Chat itself:

1.  Upload ’quick-chat’ folder to the ’/wp-content/plugins/’ directory.
1.  Activate ’Quick Chat’ plugin through the ’Plugins’ menu in WordPress.
1.  Add Quick Chat widget through ’Appearance’ -> ’Widgets’ and/or add [quick-chat height="your_chat_height_pixels"] shortcode inside the post or page where you want Quick Chat to appear. Also you can control chat room by editing ’Appearance’ -> ’Widgets’ page for sidebar chat, and by using [quick-chat room="your_room_name"] shortcode for in-post chat (check FAQ page for more info).
1.  Go to ’Settings’ -> ’Quick Chat’ to tweak security settings like forbidden words list, forbidden domains to post links and other options.
1.  Have fun showing people new chat on your web site/blog.

== Frequently Asked Questions ==
= After upgrading Quick Chat 1.xx to 2.xx what will happen with my old chat messages and settings? =
Quick Chat 2.xx has new features like list of online users that couldn't be successfully implemented on top of Quick Chat 1.xx. Because of that it isn't possible to preserve old messages and settings when upgrading Quick Chat 1.xx to Quick Chat 2.xx. If you need your old messages you should backup your data from "wp_quick_chat" table inside your WordPress database using Phpmyadmin before upgrading to Quick Chat 2.xx.

= How to embed Quick Chat into post or page? =
You can do that by placing [quick-chat] (including [] brackets) inside post or page where you want your chat to appear. See [WordPress shortcodes](http://codex.wordpress.org/Shortcode) for more info.

= How can I control Quick Chat sidebar widget height? =
You do this by editing your Quick Chat widget settings on ’Appearance’ -> ’Widgets’ page. Default sidebar widget height is 400px.

= How can I control Quick Chat height when it is embeded into post or page? =
You control Quick Chat height by giving height attribute to the [quick-chat] shortcode. So to have 600px high Quick Chat window embeded on your page you would add [quick-chat height="600"] inside page where you want your chat to appear. If you omit height attribute default height is 400px.

= How can I control what chat room is shown on my Quick Chat sidebar widget? =
You do this by changing your Quick Chat widget settings on ’Appearance’ -> ’Widgets’ page inside WordPress admin dashboard. So if you want your sidebar widget chat to show chat room identified by word "musictalk", you will put "musictalk" word inside "Chat room" text box in your Quick Chat widget settings on your WordPress Appearance -> Widgets page. Every chat (sidebar or in-post) with "musictalk" room attribute will show this same content. Default behavior for sidebar widget is to show predefined chat room identified by the "default "word".

= How can I control what chat room is shown when Quick Chat is embeded into post or page? =
In this case you control chat room by giving room attribute to the [quick-chat] shortcode. So if you want your embedded chat to show chat room identified by word "musictalk" you will display this chat like this: [quick-chat room="musictalk"]. Every chat (sidebar or in-post) with "musictalk" room attribute will show this same content. If you omit room shortcode attribute, default behavior is to show predefined chat room identified by the "default" word.

= I want to change user list position when Quick Chat is embeded into post or page? =
To use embedded chat with user list on the left you can embedd it into your post or page using following shortcode: [quick-chat userlist_position="left"]. You can also use "top" and "right" values for userlist_position shortcode attribute.

= I want to change user list position when using Quick Chat sidebar widget? =
You do this by changing your Quick Chat widget settings on ’Appearance’ -> ’Widgets’ page inside WordPress admin dashboard. There you can adjust "User list position" option.

= Can you tell me more about Quick Chat Gravatar support =
Quick Chat supports gravatars since version 2.20. Guest users or logged in users without gravatar get "unknown@gravatar.com" avatar and other logged in users get their own gravatar. For more information about gravatars you can check out [Codex Using Gravatars page](http://codex.wordpress.org/Using_Gravatars).

= How do I configure Quick Chat Gravatar support with my Quick Chat embedded using shortcode? =
When using embedded chat you use "gravatars" shortcode attribute whose value can be "0" to hide gravatars or "1" to show them (default value). "gravatar_size" shortcode attribute is used to control the size of gravatars in pixels (32px is default). So to display Quick Chat with 48x48 px high gravatars you would use [quick-chat gravatars="1" gravatars_size="48"] shortcode.

= How do I configure Quick Chat Gravatar support with my Quick Chat sidebar widget? =
When using sidebar widget you can control your Quick Chat widget settings on ’Appearance’ -> ’Widgets’ page inside WordPress admin dashboard. There you can control are gravatars enabled (default) or not and the size of gravatars (default is 32px).

= My theme has no widget support. How can I embed Quick Chat into my web site using PHP? =
To embed Quick Chat on your page you can place `<?php echo quick_chat(500,'default',1,'left',1,32,0,1,1); ?>` inside your theme PHP files. You can replace "500" with wanted Quick Chat message history window height and 'default' with your chat room name. The third parameter should be 1 when you want to display user list (0 otherwise) and fourth parameter will decide where will user list be placed ('right', 'left' or 'top'). Fifth parameter will decide will gravatars be displayed (1) or hidden (0) and sixth will control the size of gravatars in pixels. Seventh parameter can take value (0) to hide send button and (1) to display it. Last two parametars can take value (0) to hide chat for logged in users (8th parameter) or guests (9th parameter) and (1) to display it.

= I'm using WordPress Javascript optimizing plugin like WP Minify or WP Super Cache and Quick Chat does not work on my site? =
Quick Chat isn't compatible with any of the Javascript mangle/compact WordPress plugins. These plugins do their best to compact Javascript code but sometimes shortcuts they take while doing their work leave Quick Chat without correct Javascript code. Also because of its real time nature Quick Chat currently doesn't support WordPress caching plugins like WP Super Cache. If you have problems with Quick Chat you might have to disable those plugins.

= What are the requirements for Quick Chat audio notification features? =
Quick Chat can use sound to notify you of incoming messages. For this feature to work you need modern HTML5 audio tag enabled browser like Mozilla Firefox 3.5+, Google Chrome 6+, Opera 10.5+ or Internet Explorer 9 (works but not recommended).

= Can I change messages notification sound? =
Sure you can. You just replace "message-sound.mp3", "message-sound.ogg" and "message-sound.wav" from your "wp-content/plugins/quick-chat/sounds" directory with your own message notification sound files. Three files are necessary because not all HTML5 audio tag enabled browsers support all audio file formats.

= I want to customize CSS styles used to differentiate between admin users, loggedin users and guest users messages? =
You can do that by modifing quick-chat.css file inside your "wp-content/plugins/quick-chat/css" directory. For example to modify admin users message appearance you will modify "div.quick-chat-admin div.quick-chat-history-alias", "div.quick-chat-admin div.quick-chat-history-timestring" and "div.quick-chat-admin div.quick-chat-history-message" code blocks. You can modify loggedin and guest users messages appearance and appearance of users on user list by editing matching code blocks inside quick-chat.css.

= How should I configure timeout options inside General section of Quick Chat admin options? =
Generally the lower you go with timing options the more stress is put to your server but your chat is more responsive. Default values are optimal so please don't go overboard with making them much lower.

= How to display send button for embedded chat? =
To control send button visibility for embedded chat you can use "send_button" shortcode attribute. Default "send_button" short code attribute value is "0" to hide send message button. To embedd Quick Chat with send button displayed you would use following shortcode [quick-chat send_button="1"].

= How to display send button when using Quick Chat sidebar widget? =
Go to your Quick Chat widget settings by clicking ’Appearance’ -> ’Widgets’ on your WordPress admin dashboard and find Quick Chat widget settings on one of your sidebars. There you can check "Include send button" input check box to display send message button.

= How do I specify user groups (logged in, guests) which will be able to see my chat room when chat room is embedded using Quick Chat shortcode? =
When using embedded chat you can use "loggedin_visible" and "guests_visible" shortcode attributes whose value can be "0" to hide chat room for specefied user group or "1" to display it. Default value for both "loggedin_visible" and "guests_visible" shortcode atributes is "1", so this means that if you omit this shortcode attributes chat will be displayed to all users. For example to display chat room only to logged in users and hide it for guests you would use [quick-chat loggedin_visible="1" guests_visible="0"] shortcode.

= How do I specify user groups (logged in, guests) that will be able to see my chat room when using Quick Chat sidebar widget? =
When using sidebar widget you can control visibility settings for every Quick Chat widget instance by navigating to ’Appearance’ -> ’Widgets’ page inside WordPress admin dashboard. There you will find "Visible to logged in users" and "Visible to guest users" checkboxes for every Quick Chat widget instance. Default value for both checkboxes is checked so this means that if you add new Quick Chat sidebar widget instance by default this widget instance will be visible to all users.

= How do I enable or disable Quick Chat translating abilities? =
To enable Quick Chat translation features you must have Bing Translator AppID and paste it into "Bing Translator AppID" input box inside Quick Chat admin options. You can obtain your AppID [here](http://www.bing.com/developers/appids.aspx). To disable Quick Chat translation features just delete your AppID from admin option input box.

= Why is Bing Translator API used to provide translation abilities instead of Google Language API? =
Google Language API does have more languages and Google is generally little less evil towards open source technologies than Microsoft, we all know that. But unfortunately Google decided to deprecate and shut down free Google Translate API by the end of year 2011. Because of that I had no choice but to use Bing Translator API to provide Quick Chat with messge translate abilities until something better comes along.

== Screenshots ==
1.  Quick Chat placed on sidebar using sidebar widget
2.  Quick Chat embedded in post using shortcode
3.  Quick Chat sidebar widget with five separate chat rooms on same page
4.  Quick Chat admin interface options
5.  Quick Chat sidebar widget options

== Changelog ==
= 2.40 (30.10.2011.) =
*   Add message translation using Bing Translator API (requires Bing Translator AppID) (see FAQ for more)
*   Add "Bing Translator AppID" admin option
*   Add "Manual timestamp offset when displaying messages " admin option
*   Change "Timeout for refreshing list of messages" admin option from 1 to 2 seconds and default "Timeout for refreshing list of online users" admin option from 15 to 30 seconds (performance)
*   Remove "Keep first and last letter of filtered word" admin option (performance)
*   Remove "Allow guest users to choose their chat user names" admin option, hardcode enabled (performance)
*   Remove "Allow logged in users to choose their chat user names" admin option, hardcode enabled (performance)
*   Remove special behavior for room named "unique" (performance)
*   Single user name cookie for all logged in users, tie user name cookie with WordPress user id, some cookies simplifications (performance)
*   Add German translation by Art4

= 2.33 (06.09.2011.) =
*   Add "loggedin_visible" and "guests_visible" shortcode attributess for embedded chat (see FAQ for more)
*   Add "Visible to logged in users" and "Visible to guest users" check boxes to Quick Chat widget settings (see FAQ for more)
*   Change "Hide Quick Chat sidebar widget on pages where Quick Chat is embedded in post" into "Hide Quick Chat sidebar widget on pages where same chat room is embedded using shortcode"
*   Function quick_chat_display_chat() renamed to quick_chat(), backward compatibility preserved
*   File quickchat.js renamed to quick-chat.js and quickchat.min.js renamed to quick-chat.min.js for consistency
*   Revert "Web spiders are now completely blocked from indexing chat rooms" because of reported problems with some bots
*   Updated Russian translation by DreamJunkie

= 2.32 (01.09.2011.) =
*   Upcoming WordPress 3.3 compatibility
*   Web spiders are now completely blocked from indexing chat rooms (better SEO in most cases, better chat performance)
*   Fix bug where chat user names weren't checked for bad words
*   Prevent possibility of tampering with chat user name cookie
*   Add explanation tooltips for Ban, Sound, Scroll, Delete and Toggle control links
*   Danish translation by Per Bovbjerg

= 2.31 (23.08.2011.) =
*   Revert to sound toggle scheme with one global audio notifications enable/disable switch and cookie to remember state between pages
*   Optional send message button for browsing using touchscreen device (off by default for both widget and embedded chat)
*   Add "send_button" shortcode attribute for embedded chat (see FAQ for more)
*   Add "Include send button" input box to Quick Chat widget settings (see FAQ for more)
*   Add "Debug mode" admin option to load devel version of Quick Chat Javascript for easier debugging
*   Make input textarea verticaly resizable
*   Fix some audio notification bugs
*   Brazilian Portuguese translation by Hajiro

= 2.30 (12.08.2011.) =
*   Users now go instantly into no participation mode when their IP is banned. When user IP is unblocked by admin, user instantly gets participation rights back (be aware that admin users IP can be baned but admin isn't affected by being IP banned).
*   Guest users now go instantly into no participation mode when admin enables "Only logged in users can use chat" admin option.  When this option is again disabled by admin, guest users instantly get participation rights.
*   Add "Ban" link for admin users to add chat participants IP address automatically to the IP blocklist
*   Block web spiders from being shown on the users list (set them into no participation mode)
*   "Audio" link is renamed to "Sound" and if user has multiple chat rooms on the same page he can turn the sound on/off for every chat room individually (but no more cookies to remember on/off state)
*   Add "Scroll" link for all users to disable chat history auto scroll when new messages arrive (useful when reading old messages)
*   Add "Timeout for refreshing list of messages" admin option
*   Remove "Timeout after user is considered gone from chat" and hard code it as 2x "Timeout for refreshing list of online users"
*   Remove Modernizr HTML5 features detection library dependancy
*   Updated Croatian, Italian, Romanian, Spanish, Dutch and Russian translations

= 2.20 (07.08.2011.) =
*   Add gravatar support for both embedded chat and sidebar widget
*   Add "gravatar" and "gravatar_size" shortcode attributes (see FAQ for more)
*   Add "Include gravatars" checkbox to Quick Chat widget settings (see FAQ for more)
*   Add "Gravatars size" input box to Quick Chat widget settings (see FAQ for more)
*   Change default history container box height for shortcode from 300px to 400px
*   Change default history container box height for sidebar widget from 310px to 400px
*   Up minimum requirements for WordPress version to 3.0 (mainly because of WordPress included jQuery version).

= 2.10 (05.08.2011.) =
*   Add feature into Quick Chat options to paste advertisement code for ads that will be shown between chat user name input box and message text input box
*   Chat user names color defaults to blue color for guests, green for loggedin users and red for admin users (can be changed in quick-chat.css)
*   Disable adding links to users own name on message history and users list
*   Disable adding other users links for users on IP block list or when the "only logged in can participate" option is turned on and user is guest
*   Increase typing timeout to check user name from 1000 ms to 1500ms
*   Add Russian translation by DreamJunkie

= 2.09 (30.07.2011.) =
*   Tweak long polling code to send headers to disable browsers caching message update requests
*   Implement alternative way of storing and fetching chat ID using HTML5 "data-" way

= 2.08 (29.07.2011.) =
*   Use CSS sprites instead of separate images for smilies to improve page load times even more
*   Optimize fetching messages to conserve bandwidth by monitoring only chat rooms user has on current page.
*   Rewrote Quick Chat PHP and jQuery in a way to make upcoming private messages functionality possible
*   Rewrote user name check functionality to simplify jQuery code
*   Rewrote the delete messages functionality

= 2.01 (22.07.2011.) =
*   Fix bug where users could use white spaces for user name
*   Fix chat user name prefix not being translated when using localized Quick Chat
*   In Quick chat 2.00 I've removed "Filter URLs to the following domains" admin option. Now I've removed obsolete "keep in mind that URLs filter has priority" sentence from admin options.

= 2.00 (21.07.2011.) =
*   Add list of online users feature (can be positioned at the top, left or right of the chat)
*   Add "userlist" shortcode attribute with value "1" to turn user list on and "0" to turn user list off when using embedded chat. Default is "1"
*   Add "userlist_position" shortcode attribute with possible values "left", "right", "top". Default is "left".
*   Add "Include user list" checkbox for sidebar widget to turn user list for that widget instance on and off
*   Add "User list position" select box with with possible values "left", "right", "top". Default is "top".
*   Add "Disallow using special characters inside chat user names" admin option
*   Add code for making impossible for two users to use same name in same chat room
*   Add links for Quick Chat FAQ, Quick Chat support page, changelog and Quich Chat version number to the Quick Chat admin options
*   Remove "Maximum length of guest chat user name" option. Hard coding the user alias length to the 30 characters
*   Remove "Filter URLs to the following domains" admin option to improve performance
*   Audio notification isn't dependant on ip address anymore, it checks for chat user names in the chat room before playing
*   Admin users are not affected by any of the Quick Chat security or filter restrictions

= 1.84 (11.07.2011.) =
*   Chinese translation by Victor
*   Add "Deny chat access to the following IP addresses" admin option
*   Add "quick-chat-admin", "quick-chat-loggedin" and "quick-chat-guest" CSS classes so you can style admin, loggedin users and guest users messages separately

= 1.83 (09.07.2011.) =
*   Romanian translation provided by Dragiša
*   Play messages notification sound only on incoming message (checked by message sender IP address)
*   Some work on ajax calls security to hopefully minimize probability that legitimate ajax calls will be blocked

= 1.82 (07.07.2011.) =
*   Czech translation provided by Petr
*   Fix CSS layout bug when option "Only logged in users can use chat" is enabled

= 1.81 (04.07.2011.) =
*   Fix CSS bug where message input box wouldn't wrap text on some browsers

= 1.80 (04.07.2011.) =
*   Add "Protect registered users user names from being used by other users" admin option (admin users are not affected by this restriction)
*   Add "Reserved chat user names list (comma separated)" admin option, with "admin" and "moderator" as default reserved names (admin users are not affected by this restriction)
*   Additional steps to protect chat against malicious usersA
*   Ajax logic rewritten to use admin-ajax.php
*   Ajax calls secured using WordPress nounces
*   When word "unique" is used for chat room name for any sidebar chat widget, this widget shows unique chat on every post/page except on home page where it shows the "default" chat room
*   Add PayPal donate button at the end of Quick Chat admin option list

= 1.73 (31.06.2011.) =
*   Quick Chat Javascript logic disabled on pages without chat window to improve performance
*   Use minified Javascript code for faster page loading
*   General code cleanup

= 1.72 (24.06.2011.) =
*   Add possibility to automatically convert URLs inside messages to hyperlinks and admin option to toggle this on and off
*   Work on preventing Google Chrome/Chromium browser from displaying spinning circle after Quick Chat is loaded

= 1.71 (23.06.2011.) =
*   Add click chat user name to mark as reply using @username:
*   Tiny CSS tweaks

= 1.70 (21.06.2011.) =
*   Full upcoming WordPress 3.2 compatibility
*   Incoming/outgoing messages notification sound for any modern HTML5 audio tag enabled browser
*   Explicitly remove borders and padding from smilies (some themes add these what makes smilies look funny)
*   Delete messages without reloading page using ajax
*   Dozen of minor tweaks and bug fixes

= 1.62 (09.06.2011.) =
*   Fix potential database bug with TEXT field incorrectly having default value (thanks Freeman for pointing this out)

= 1.61 (02.06.2011.) =
*   Fix upgrade problem with sidebar not showing anything

= 1.60 (02.06.2011.) =
*   Modify database, php and Javascript code for multiple separate chat rooms feature
*   Add "room" shortcode and sidebar options for multiple chatroom names
*   Add index on "timestamp" and "room" database fields for performance

= 1.52 (27.05.2011.) =
*   Fix periodic automatic scrolling behavior when reviewing chat history
*   Italian translation by Alex Camilleri

= 1.51 (20.05.2011.) =
*   Some users report multiple messages after single message has been sent, hopefully this will workaround this problem

= 1.50 (19.05.2011.) =
*   Add administrator interface for deleting messages
*   Now every message has timestamp received through ajax instead of last message timestamp from last page refresh.
*   Fix bug with jQuery 1.6 where chat history container doesn't scroll to the bottom
*   Quick chat Javascript can now be added to the header or the footer
*   Million of other small tweaks and fixes

= 1.45 (07.05.2011.) =
*   Add "Keep first and last letter of filtered word" option
*   Chat user name is no longer limited to 10 characters
*   Add "Maximum length of guest chat user name" option
*   Fix bug with wrong IP address inside Quick Chat message database
*   Tweaks to the Quick Chat jQuery code

= 1.44 (05.05.2011.) =
*   Divide admin settings into general, filter, security and appearance sections
*   Add "Hide Quick Chat sidebar widget on pages where Quick Chat is embeded in post" option

= 1.43 (05.05.2011.) =
*   Fix "can't save certan admin settings" bug
*   Update screenshots to the newest version

= 1.41 (30.04.2011.) =
*   Improve message filtering with option to disable filtering of bad words found inside other words
*   Add admin option to keep number of messages inside database around given number
*   Administrator can forbidd guest users to actively participate in chat
*   It is possible to restrict chat user name to site login name for logged in users, and special unique name like "Guest_123" for guest users.
*   Improve Quick Chat installation and deinstallation process
*   Split Javascript from PHP, should improve compatibility

= 1.28 (28.04.2011.) =
*   Remove colon after user name input box as suggested by some users
*   A few of the CSS tweaks

= 1.27 (28.04.2011.) =
*   Load WordPress included jQuery version instead Google's to increase compatibility with other plugins and themes

*   Fix monkey smiley not working correctly
*   Fix CSS for smilies container that caused overflow for some themes and layouts
*   Use logged in user name for alias instead logged in user first name because user name is unique and first name isn't
*   Filter user name for bad words and links to forbidden domains

= 1.26 (27.04.2011.) =
*   Simplify jQuery for selecting active textarea when there are multiple Quick Chat instances on the same page

= 1.25 (27.04.2011.) =
*   Quick Chat now removes its WordPress options and database when being deleted

= 1.23 (27.04.2011.) =
*   Make Quick Chat load jquery.min.js instead jquery.js

= 1.22 (26.04.2011.) =
*   Fix chat auto scrolling in certan scenarios with multiple Quick Chat instances on the same page

= 1.21 (26.04.2011.) =
*   Fix missing jquery.focused.js because of the SVN upload problem with file permissions

= 1.20 (26.04.2011.) =
*   Support unlimited multiple instances of the Quick Chat on the same page
*   Quick Chat can be added to the posts or pages by placing WordPress shortcode [quick-chat height="your_integer"]
*   Add insert from smilies repository fade-in and fade-out effects
*   Set textarea and smilies repository width to 100% of available space

= 1.14 (24.04.2011.) =
*   Fix display of local server time

= 1.13 (24.04.2011.) =
*   More work on the readme.txt

= 1.12 (21.04.2011.) =
*   Fix devil smilie not working
*   Fix chat not working with empty bad words filter
*   Remove unnecessary checkbox from admin
*   Many other bug fixes

= 1.1 (21.04.2011.) =
*   Add option to disable posting URLs to specified domains (posted as text, true links are transformed to text)
*   Message input text becomes textarea
*   Smilies can be teleported from smilies repository in the middle of the sentence.
*   Add smilies textual representation on smilies repository images hover
*   Add removable ’Powered by Quick Chat’ link to spread the word about Quick Chat

= 1.0 (20.04.2011.) =
*   Initial release
