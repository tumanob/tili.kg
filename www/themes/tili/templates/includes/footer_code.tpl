{if $T_THEME_SETTINGS->options.show_footer && $T_CONFIGURATION.show_footer}
 {if $T_CONFIGURATION.additional_footer}
<center>
 <div class="sbuttons">
     <div class="fb-like" data-href="http://course.tili.kg" data-send="false" data-layout="button_count" data-width="170" data-show-faces="false" data-font="verdana"></div>
     <div class="g-plusone" data-size="medium"></div>

     <a href="https://twitter.com/share" class="twitter-share-button" data-lang="ru">Tweet</a>
 {literal} <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>   {/literal}

 </div>

</center>


  {$T_CONFIGURATION.additional_footer}
 {else}
  <div><a href = "{$smarty.const._EFRONTURL}">{$smarty.const._EFRONTNAME}</a> (version {$smarty.const.G_VERSION_NUM}) &bull; {$T_VERSION_TYPE} Edition &bull; <a href = "index.php?ctg=contact">{$smarty.const._CONTACTUS}</a></div>
 {/if}
{/if}
{literal}
<div class="netkg">
                <!-- WWW.NET.KG , code for http://tili.kg -->
                <script language="javascript" type="text/javascript">
                 java="1.0";
                 java1=""+"refer="+escape(document.referrer)+"&amp;page="+escape(window.location.href);
                 document.cookie="astratop=1; path=/";
                 java1+="&amp;c="+(document.cookie?"yes":"now");
                </script>
                <script language="javascript1.1" type="text/javascript">
                 java="1.1";
                 java1+="&amp;java="+(navigator.javaEnabled()?"yes":"now");
                </script>
                <script language="javascript1.2" type="text/javascript">
                 java="1.2";
                 java1+="&amp;razresh="+screen.width+'x'+screen.height+"&amp;cvet="+
                 (((navigator.appName.substring(0,3)=="Mic"))?
                 screen.colorDepth:screen.pixelDepth);
                </script>
                <script language="javascript1.3" type="text/javascript">java="1.3"</script>
                <script language="javascript" type="text/javascript">
                 java1+="&amp;jscript="+java+"&amp;rand="+Math.random();
                 document.write("<a href='http://www.net.kg/stat.php?id=1670&amp;fromsite=1670' target='_blank'>"+
                 "<img src='http://www.net.kg/img.php?id=1670&amp;"+java1+
                 "' border='0' alt='WWW.NET.KG' width='88' height='31' /></a>");
                </script>
                <noscript>
                 <a href='http://www.net.kg/stat.php?id=1670&amp;fromsite=1670' target='_blank'><img
                  src="http://www.net.kg/img.php?id=1670" border='0' alt='WWW.NET.KG' width='88'
                  height='31' /></a>
                </noscript>
                <!-- /WWW.NET.KG -->

            </div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter13790767 = new Ya.Metrika({id:13790767, enableAll: true, trackHash:true, webvisor:true});
        } catch(e) {}
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/13790767" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!--[if lte IE 6]>
<script type="text/javascript" src="http://support.ktnet.kg/js/ie6ketsin.js"></script>
<![endif]-->

<script type="text/javascript">
    var reformalOptions = {
        project_id: 66713,
        project_host: "tili.reformal.ru",
        tab_orientation: "right",
        tab_indent: "50%",
        tab_bg_color: "#72cc7d",
        tab_border_color: "#FFFFFF",
        tab_image_url: "http://tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/88128dfd6ca0743b5ccc2f8afed9f3b1/right/0/tab.png",
        tab_border_width: 2
    };

    (function() {
        var script = document.createElement('script');
        script.type = 'text/javascript'; script.async = true;
        script.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'media.reformal.ru/widgets/v3/reformal.js';
        document.getElementsByTagName('head')[0].appendChild(script);
    })();
</script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://tili.reformal.ru">Oтзывы и предложения для Tili.kg - изучение кыргызского языка онлайн</a></noscript>

{/literal} 

