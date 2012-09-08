/**
 * Created by IntelliJ IDEA.
 * User: entea
 * Date: 7/10/12
 * Time: 3:04 PM
 */
$(function() {
    var hash = window.location.hash;
    hash = hash.replace('#', '');
    $('#submission_word').val(decodeURIComponent(hash));

    $('#submit-link').click(function() {
        $('#new_form').submit();
    })
});