function initLightBox() {
    $('.img-wrap a').lightBox({
        fixedNavigation: true,
        imageLoading: '/dict/assets/images/lightbox-ico-loading.gif',
        imageBtnClose: '/dict/assets/images/lightbox-btn-close.gif',
        imageBtnPrev: '/dict/assets/images/lightbox-btn-prev.gif',
        imageBtnNext: '/dict/assets/images/lightbox-btn-next.gif',
        txtImage: 'Картинка',
        txtOf: 'из',
        imageBlank: '/dict/assets/images/lightbox-blank.gif'
    });
}

function deleteImageFunction(e) {
    if (confirm("Удалить?")) {
        var that = this;
        e.stopPropagation();
        $.get('/dict/picture/delete/' + $(this).attr('rel'), function(data) {
            $(that).parent('div').remove();
        }, 'json');
    }
}

function OnSearch(data) {
    $('#image-search-results').empty();
    var r = data.responseData.results;
    if (data.responseStatus != 200) {
        alert('Ошибка поиска картинки: ' + data.responseDetails);
    }

    for (var i = 0; i < r.length; i++) {
        var div = $('<div>', {'class': 'img-result'});
        $('<img>', {src: r[i].tbUrl, rel: r[i].url}).appendTo(div).click(function() {
            var src = $(this).attr('src');
            var image = $(this).attr('rel');

            $.post('/dict/picture/add', {
                'thumb': src,
                'image': image,
                'word': $('#keyword').val(),
                'searchword': $('#image-search').val()
            }, function(data) {
                if (data.result == 'login') {
                    window.location.href = '/wp-login.php?redirect_to=' + encodeURIComponent(window.location.href);
                }

                if (data.result == 'ok') {
                    var div = $('<div>', {'class': 'img-wrap'});
                    div.append($('<span>', {class: 'delete-image', rel: data.id, click: deleteImageFunction, text: '[x]'}));
                    div.append($('<br />'));
                    $('<a>', {href: image}).appendTo(div).append($('<img>', {src: src}));

                    div.appendTo($('.pics').first());

                    // Show upper "add image" button
                    $('#image-search-add-with-results').show();
                    // Remove "add image" links inside .pics container
                    $('.pics .add-pic').remove();

                    initLightBox();
                    alert('Ваша картинка добавлена');
                } else if (data.result == 'bad-image') {
                    alert('Выберите другую картинку. Оригинал выбранной вами картинки удален');
                } else {
                    alert('Ошибка добавления слова');
                }
            }, 'json');
            $('#add-picture').dialog('close');
        });
        div.appendTo($('#image-search-results'));
    }
    $('#image-search-button').show().parent('div').find('span').remove();
    $('#image-search-next').show();
}

function initPictureStuff() {
    $('.add-pic').click(function() {
        $('#add-picture').dialog({'width': 600, title: 'Добавить картинку к слову "' + $('#keyword').val() + '"'});
    });

    initLightBox();

    // Show upper "add image" button, if there are already added pictures to word.
    if ($('.pics .img-wrap').length > 0) {
        $('#image-search-add-with-results').show();
    }


    $('.delete-image').click(deleteImageFunction);

    var a = 'https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=[word]&callback=OnSearch&hl=ru&rsz=8&imgsz=icon|small|medium&start=[start]';
    var flushSearchStart = true;
    var imageSearchStart = 0;

    $('#image-search-button').click(function() {
        var word = $('#image-search').val();
        if (word.trim().length == 0) {
            return;
        }

        if (flushSearchStart) {
            imageSearchStart = 0;
        }

        var url = a.replace('[word]', encodeURIComponent(word));
        url = url.replace('[start]', imageSearchStart);
        var e = document.createElement('script');
        $(e).attr('src', url).attr('type', 'text/javascript').appendTo($('head'));

        $('<span></span>').text('Загрузка...').appendTo($('#image-search-button').parent('div'));
        $('#image-search-button').hide();
    });

    $('#image-search-next').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        imageSearchStart += 8;
        flushSearchStart = false;
        $('#image-search-button').trigger('click');
        flushSearchStart = true;
    });

    $('#image-search').keypress(function(ev) {
        var keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if (keycode == '13') {
            $('#image-search-button').trigger('click');
        }
    });

    $('.pics a').click(function() {
        var that = this;
        setTimeout(function() {

            if ($('#lightbox-image').length && $('#lightbox-image').width() < 100) {
                var url = $(that).find('img').attr('src');
                $('#lightbox-image').attr('src', url).show();
                $('#lightbox-loading').hide();
            }
        }, 1000);
    });
}

$(function() {
    initPictureStuff();
});