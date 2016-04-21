jQuery(function($) {
    var keywords = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/dict/search-word/%QUERY',
            wildcard: '%QUERY',
            transform: function(data) {
                return data['w'];
            }
        }
    });

    $('#stxt').typeahead(null, {
        name: 'keywords',
        source: keywords,
        limit: 2000000
    }).on('typeahead:select', function() {
        $('#mdform').trigger('submit');
    });
});