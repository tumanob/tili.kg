function initTagStuff() {
    $('.tag-add').click(function() {
        addTag($(this).attr('rel'), this);
    });

    $('.tag-parent-item').click(function() {
        if ($(this).siblings('ul').length) {
            if (!$(this).siblings('ul').is(':visible')) {
                $('.tag-parent-item').each(function(i, e) {
                    $(e).find('b').text('+ ')
                    $(e).siblings('ul').hide();
                })
                $(this).siblings('ul').show();
                $(this).find('b').text('- ')
            } else {
                $(this).siblings('ul').hide();
                $(this).find('b').text('+ ')
            }
        } else {
            chooseTag($(this))
        }
    })

    $('.tag-child-item, .tag-child-item a').click(function(e) {
        e.preventDefault()
        chooseTag($(this))
        return false;
    })

    $('.remove-tag').click(function() {
        if (confirm('Удалить тег?')) {
            var parts = $(this).attr('rel').split('::');
            var that = this;
            $.post('/dict/tags/remove', {tag: parts[0], word: parts[1]}, function() {
                $(that).parent().remove();
            })
        }
    })
}

var gItemId = 0;

function chooseTag(el) {
    $('#tag-chosen-ones').append(
        $(el).clone().click(function() {
            $('#tag-available span[rel=' + $(el).attr('rel') + ']').show('fast');
            $(this).remove();
        }).append($('<a>', {href: '#'}))
    );
    $('#tag-chosen-ones div').remove();
    $('#tag-chosen-ones').append($('<div>', {class: 'clear'}))
    $(el).hide();
}

function addTag(itemId, el) {
    gItemId = itemId;

    $('#add-tag-dialog span').show();
    $('#tag-chosen-ones span').each(function(i, e) {
        $(e).trigger('click');
    });

    $(el).parents('div.tags').find('span.remove-tag').each(function(i, el) {
        var rel = $(el).attr('rel');
        var tagid = rel.split('::')[0];
        $('#add-tag-dialog span[rel=' + tagid +']').hide();
    })

    $('#add-tag-dialog').dialog({
        title: 'Добавить категории к слову "' + $('#keyword').val() + '"',
        width: 550,
        'buttons': [{
            text: 'OK',
            click: function() {
                var ids = [];
                $('#tag-chosen-ones span').each(function(i, e) {
                    ids.push($(e).attr('rel'));
                });
                $.post('/dict/tags/add', {ids: ids, id: gItemId}, function(data) {
                    showWord($('#keyword').val())
                });
                $(this).dialog("close");
            }
        }, {
            text: 'Отмена',
            click: function() {
                $(this).dialog("close");
            }
        }]
    });
}

$(function() {
    initTagStuff();
});