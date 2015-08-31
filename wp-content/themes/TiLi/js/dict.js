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
      //  $("#query_stat").html(data.s);

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


        });


        initPictureStuff();
        initTagStuff();
    });
}

$(document).ready(function () {

    alert("123123");
    // Ajax activity indicator bound
    // to ajax start/stop document events


    $("#keyword").keyup(function () {
        var length = $('#keyword').val().length;
        if (length > 1) {
            clearTimeout(timer);
            timer = setTimeout(findWord, 1500);
        }

		   });




});
