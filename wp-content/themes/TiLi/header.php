<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='loginza-verification' content='c087f9ee270d394785e1e56953635ffe' />
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.caret.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/character.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/dict.js"></script>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto|Roboto+Mono">

    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
           {lang: 'ru'}
           </script>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

</head>

<body <?php body_class(); ?>>
  <div id="topmenu">
        <nav class="navbar navbar-default navbar-tili" role="navigation" style="margin-top:0px;">

        <div class="container-fluid topbluebox">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Меню</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           <!--  <span class="navbar-brand hidden-xs"> Меню</span> -->
            <div class="row topcenter">
              <div class="col-md-8 col-sm-6 col-xs-6">
                <h1 id="logotext"><a href="<?php bloginfo('url'); ?>">Tili.kg <span>Все для изучения Киргизского языка!</span></a></h1>
              </div>
              <div class="col-md-3 .col-sm-3 col-xs-4 pull-right">
                <div class="login">
                 <?php
                 if ( is_user_logged_in() ) {?>
                      	Добро пожаловать <?php global $current_user;
                         get_currentuserinfo();
                         echo "<b>".$current_user->user_login . "</b>\n";
                         ?>
                         | <a href="/wp-login.php?action=logout">Выйти</a>

                   <?php }
                 else {?>
                     	<a href="http://tili.kg/wp-login.php">Войти</a>  <a href="http://tili.kg/wp-login.php?action=register">Регистрация</a>
                 <?php }
                 ?>
                 </div>
              </div>
            </div>

          </div>

              <?php
                  wp_nav_menu( array(
                      'menu'              => 'primary',
                      'theme_location'    => 'primary',
                      'depth'             => 2,
                      'container'         => 'div',
                      'container_class'   => 'collapse navbar-collapse',
              'container_id'      => 'bs-example-navbar-collapse-1',
                      'menu_class'        => 'nav navbar-nav',
                      'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                      'walker'            => new wp_bootstrap_navwalker())
                  );
              ?>

          </div>
          <div class="headersearch">
            <div class="searchform">

              <form id="mdform" >
                  <div class="">
                    <span class="isearch">&nbsp;</span>
                    <input placeholder="Введите слово для поиска в словаре" type="text" id="stxt"  class="stxt col-md-12 col-sm-12 col-xs-12" required="">
                    <input type="submit" class="sbtn col-md-2 col-sm-2 col-xs-3" value="Найти" onClick="//location.href = '<?php bloginfo('url'); ?>/dict/#'+document.getElementById('stxt').value;  return false;"/>
                  </div>
                </form>
                <div id="float_chars_block">
                  <!--  <div class="close">x</div> -->
                    <span title="Ctrl+Alt+н">ң</span>
                    <span title="Ctrl+Alt+о">ө</span>
                    <span title="Ctrl+Alt+у">ү</span>
                    <div style="clear:both"></div>
                </div>
                <div id="float_chars_icon"><img src="<?php bloginfo('template_url'); ?>/images/character.gif" border="0"/></div>


            </div>
          </div>


            <!--
            <form id="" action="<?php bloginfo('url'); ?>" method="get">
                 <input placeholder="Введите слово для поиска в словаре" type="text" />
                 <input type="submit" class="sbtn" value="Перевод" onClick="//location.href = '<?php bloginfo('url'); ?>/dict/#'+document.getElementById('stxt').value;  return false;"/>
            </form>
            -->

      </nav>

</div>

<div id="site">
	<div id="header" >





	</div>
