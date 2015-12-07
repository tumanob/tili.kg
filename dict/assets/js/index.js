var timer;
var inRequest = false;
var keyword = false;
var lastQuery = false;


function findWord(autoshow) {
    if (autoshow == 'undefined') {
        autoshow = false;
    }
    if (inRequest) return false;

    keyword = $("#keyword").val();

    if (keyword == lastQuery) return false;

    if (keyword < 1) return false;

    inRequest = true;
    $.get("search-word/" + encodeURIComponent(keyword), function (data) {
        eval("data=" + data);
        var tmp = "";
        for (var x in data['w']) {
            tmp = tmp + "<div class=\"wl\"><a href=\"/dict/#"+data['w'][x]+"\"  onClick=\"showWord('" + data['w'][x] + "');  return false;\">" + data['w'][x] + "</a></div>";
        }
        $("#result").html(tmp);
        $("#query_stat").html(data.s);

        inRequest = false;
        lastQuery = keyword;

        if (autoshow && data['w'].length > 0) {
            showWord(data['w'][0]);
        }
        if (data['w'].length == 0) {
            $('#dic_content').empty();
            var word = $('#keyword').val();
            $('#not-found span').text(word);
            var ref = $('#not-found a').attr('href');
            var pos = ref.indexOf('#');
            if (pos >= 0) {
                ref = ref.substring(0, pos);
            }
            $('#not-found a').attr('href', ref + '#' + encodeURIComponent(word));
            $('#not-found').show('slow');
        } else {
            $('#not-found').hide('fast');
        }
    });
}

function showWord(id) {
    imageSearchStart = 0;

    $('#add-picture').dialog('destroy');
    $('#add-picture').remove();
    $('#add-picture').remove();
    $('#add-tag-dialog').dialog('destroy');
    $('#add-tag-dialog').remove();
    $('#add-tag-dialog').remove();

    $.get("show-word/" + encodeURIComponent(id), function (data) {
        $("#dic_content").html(data);
        window.location.hash = '#' + id;

        // Tooltips
        $(".tip_trigger").hover(function(){
            tip = $(this).find('.tip');
            tip.show(); //Показать подсказку
        }, function() {
            tip.hide(); //Скрыть подсказку
        }).mousemove(function(e) {
            var mousex = e.pageX - 200; //Получаем координаты по оси X
            var mousey = e.pageY + 20; // Получаем координаты по оси Y
            var tipWidth = tip.width(); //Вычисляем длину подсказки
            var tipHeight = tip.height(); // Вычисляем ширину подсказки
            //Определяем дистанцию от правого края окна браузера до блока, содержащего подсказку
            var tipVisX = $(window).width() - (mousex + tipWidth);
            // Определяем дистанцию от ниждего края окна браузера до блока, содержащего подсказку
            var tipVisY = $(window).height() - (mousey + tipHeight);

            if ( tipVisX < 20 ) { //Если ширина подсказки превышает расстояние от правого края окна браузера до курсора,
                mousex = e.pageX - tipWidth - 20; // то распологаем область с подсказкой по другую сторону от курсора
            } if ( tipVisY < 20 ) { // Если высота подсказки превышает расстояние от нижнего края окна браузера до курсора,
                mousey = e.pageY - tipHeight - 20;  // то распологаем область с подсказкой над курсором

            }
            tip.css({  top: mousey, left: mousex });
        });


        initPictureStuff();
        initTagStuff();
    });
}

$(document).ready(function () {
    // Setup the ajax indicator
    $(".searchform").append('<div id="ajaxBusy" style=""><p><img src="views/images/loading.gif"><center>Ищу слова</center></p> </div>');

    $('#ajaxBusy').css({
        display:"none"

    });

    // Ajax activity indicator bound
    // to ajax start/stop document events
    $(document).ajaxStart(function () {
        $('#ajaxBusy').show();
    }).ajaxStop(function () {
            $('#ajaxBusy').hide();
        });

    $("#keyword").keyup(function () {
        var length = $('#keyword').val().length;
        if (length > 1) {
            clearTimeout(timer);
            timer = setTimeout(findWord, 1500);
        }

		   });

   // $("#keyword").focus();

    var hash = window.location.hash;
    if (hash) {
        hash = hash.replace('#', '');
        $("#keyword").val(hash);
        findWord(true);
    }

    $(window).bind("hashchange", function (e) {
        // In jQuery 1.4, use e.getState( "url" );
        var url = $.bbq.getState("url");
        var hash = window.location.hash;
        if (hash) {
            hash = hash.replace('#', '');
            $("#keyword").val(hash);
            findWord(true);
        }
    });

    $('#keyword').focusout(function(){
       // setTimeout($('#result').delay(10000), 2000);
      $('#result').delay(400).hide(200); // hide podskazka
    });
    $('#keyword').focusin(function(){

      $('#result').show(); // hide podskazka
        });

    $(window).trigger("hashchange");

/*   // fixed height when is down -  btter for search field
    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > 150) {
            $('#mainmenu').addClass('fixed');
        } else {
            $('#mainmenu').removeClass('fixed');
        }
    });*/


});
