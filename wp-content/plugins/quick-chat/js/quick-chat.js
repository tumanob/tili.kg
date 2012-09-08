// Quick Chat 2.40
var quick_chat_undefined;
jQuery.quick_chat_cookie = function (key, value, options) {
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }

        value = String(value);

        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '',
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    options = value || {};
    var result, decode = options.raw ? function (s) {return s;} : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};

if(typeof(quick_chat_js_vars) != typeof(quick_chat_undefined)){
    var quick_chat_users_interval;
    var quick_chat_smile = quick_chat_l10n_after.quick_chat_smile_array;
    var quick_chat_data = quick_chat_l10n_after.quick_chat_data_array;
    var quick_chat_rooms = new Array();

    var quick_chat_audio_support = 0;
    var quick_chat_audio_element = document.createElement('audio');
    if(quick_chat_audio_element.canPlayType){
        if(quick_chat_audio_element.canPlayType('audio/ogg; codecs="vorbis"')) {
            quick_chat_audio_element.setAttribute('src', quick_chat_js_vars.quick_chat_url+"sounds/message-sound.ogg");
            quick_chat_audio_element.setAttribute('preload', 'auto');
            quick_chat_audio_support = 1;
        } else if(quick_chat_audio_element.canPlayType('audio/mpeg;')){
            quick_chat_audio_element.setAttribute('src', quick_chat_js_vars.quick_chat_url+"sounds/message-sound.mp3");
            quick_chat_audio_element.setAttribute('preload', 'auto');
            quick_chat_audio_support = 1;
        } else if(quick_chat_audio_element.canPlayType('audio/wav; codecs="1"')){
            quick_chat_audio_element.setAttribute('src', quick_chat_js_vars.quick_chat_url+"sounds/message-sound.wav");
            quick_chat_audio_element.setAttribute('preload', 'auto');
            quick_chat_audio_support = 1;
        }
    }

    if(quick_chat_audio_support == 1){
        if(jQuery.quick_chat_cookie('quick_chat_sound_state'))
            quick_chat_play_audio = jQuery.quick_chat_cookie('quick_chat_sound_state');
        else
            quick_chat_play_audio = quick_chat_js_vars.quick_chat_audio_enable;
    }

    if(jQuery.quick_chat_cookie('quick_chat_dest_lang')){
        var quick_chat_dest_lang = jQuery.quick_chat_cookie('quick_chat_dest_lang');
    }else{
        quick_chat_dest_lang = quick_chat_js_vars.quick_chat_default_langugage_code;
    }
    if(quick_chat_js_vars.quick_chat_bing_appid != '') jQuery.translate.load(quick_chat_js_vars.quick_chat_bing_appid);
}

;(function($){
    var defaults = {
            tags: ["select", "option"],
            filter: $.translate.isTranslatable,
            label: $.translate.toNativeLanguage ||
                    function(langCode, lang){
                            return $.translate.capitalize(lang);
                    },
            includeUnknown: false
    };

    $.translate.quick_chat_ui = function(){
            var o = {}, str='', cs='', cl='';

            if(typeof arguments[0] === "string")
                    o.tags = $.makeArray(arguments);
            else o = arguments[0];

            o = $.extend({}, defaults, $.translate.quick_chat_ui.defaults, o);

            if(o.tags[2]){
                    cs = '<' + o.tags[2] + '>';
                    cl = '</' + o.tags[2] + '>';
            }

            var languages = $.translate.getLanguages(o.filter);
            if(!o.includeUnknown) delete languages.UNKNOWN;

            $.each( languages, function(l, lc){
                    str += ('<' + o.tags[1] + " value=" + lc + '>' + cs +
                            o.label(lc, l) +
                            cl + '</' + o.tags[1] + '>');
            });

            return jQuery('<label class="quick-chat-lang-label" for="quick-chat-lang-select">'+quick_chat_js_vars.quick_chat_select_language_string+'</label><' + o.tags[0] + ' name="quick-chat-lang-select" class="quick-chat-lang-select">' + str + '</' + o.tags[0] + '>');

    };

    $.translate.quick_chat_ui.defaults = $.extend({}, defaults);
})(jQuery);

jQuery.fn.quick_chat_insert_at_caret = function (myValue) {

    return this.each(function() {

        if (document.selection) {

        this.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
        this.focus();

        } else if (this.selectionStart || this.selectionStart == '0') {
            var startPos = this.selectionStart;
            var endPos = this.selectionEnd;
            var scrollTop = this.scrollTop;
            this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
            this.focus();
            this.selectionStart = startPos + myValue.length;
            this.selectionEnd = startPos + myValue.length;
            this.scrollTop = scrollTop;
        } else {
            this.value += myValue;
            this.focus();
        }
    });
};

jQuery.quick_chat_preg_quote = function (str) {
        var specials = new RegExp("[.*+?|()\\[\\]{}\\\\]", "g");
        return str.replace(specials, "\\$&");
};

jQuery.quick_chat_stripslashes = function (str) {
        str = str.replace(/\\'/g,'\'');
        str = str.replace(/\\"/g,'"');
        str = str.replace(/\\\\/g,'\\');
        str = str.replace(/\\0/g,'\0');
        return str;
};


jQuery.quick_chat_update_rooms = function () {
    for(var chat_id in quick_chat_data){
        if(jQuery.inArray(quick_chat_data[chat_id]['quick_chat_room_name'], quick_chat_rooms) == -1)
            quick_chat_rooms.push(quick_chat_data[chat_id]['quick_chat_room_name']);
    }
};

jQuery.quick_chat_update_sound_state = function (){
    if(quick_chat_play_audio == 0){
         jQuery("div.quick-chat-sound-link a").css('text-decoration','line-through');
    } else{
         jQuery("div.quick-chat-sound-link a").css('text-decoration','none');
    }
};

jQuery.quick_chat_user_status_class = function(user_status){
    var user_status_class = '';
    if(user_status == 0){
        user_status_class = 'quick-chat-admin';
    } else if(user_status == 1){
        user_status_class = 'quick-chat-loggedin';
    } else if(user_status == 2){
        user_status_class = 'quick-chat-guest';
    }
    return user_status_class;
}

jQuery.quick_chat_single_message_html = function(single_message, username, gravatars, gravatars_size){
    var alias = jQuery.quick_chat_stripslashes(single_message.alias);
    var status_class = jQuery.quick_chat_user_status_class(single_message.status);

    var message_with_smile = jQuery.quick_chat_stripslashes(single_message.message);
    for (var smile in quick_chat_smile){
        var replace_string = '<div class="quick-chat-smile-message quick-chat-smile quick-chat-smile-'+quick_chat_smile[smile]+'" title="'+smile+'"></div>';
        message_with_smile = message_with_smile.replace(new RegExp(jQuery.quick_chat_preg_quote(smile), 'g'), replace_string);
    }
    var string = "<div class=\"quick-chat-history-message-alias-container "+status_class+"\"><div class=\"quick-chat-history-header\">";

    if(gravatars == 1){
        string += "<img class=\"quick-chat-history-gravatar\" style=\"width:"+gravatars_size+"px; height:"+gravatars_size+"px;\" src=\"http://0.gravatar.com/avatar/"+single_message.md5email+"?s="+gravatars_size+"&d=http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s="+gravatars_size+"&r=G\"/>";
    }

    string += "<div class=\"quick-chat-history-alias\">";

    if(alias == username || quick_chat_js_vars.quick_chat_no_participation == 1){
        string += alias;
    } else{
        string += "<a href=\"\" title=\""+quick_chat_js_vars.quick_chat_reply_to_string+" "+alias+"\">"+alias+"</a>";
    }
    string += "</div>";

    string += "<div class=\"quick-chat-history-timestring\">"+single_message.timestring+"</div>";

    string += "</div><div class=\"quick-chat-history-message\">"+message_with_smile+"</div>";

    string += '<div class="quick-chat-history-links">';

    if(quick_chat_js_vars.quick_chat_bing_appid != ''){
        string += "<div class=\"quick-chat-translate-link\">";
            string += " <a style=\"text-decoration: none;\" href=\"\">"+quick_chat_js_vars.quick_chat_translate_string+"</a> ";
        string += "</div>";
    }

    if(quick_chat_js_vars.quick_chat_user_status == 0){
        string += "<input class=\"quick-chat-to-delete-boxes\" type=\"checkbox\" name=\"quick-chat-to-delete[]\" value=\""+single_message.id+"\" />";
    }

    string += "</div>";
    return string;
}

jQuery.quick_chat_check_username = function (chat_id, username_check, username_status_element){
    var roomname = quick_chat_data[chat_id]['quick_chat_room_name'];
    var username_old = quick_chat_data[chat_id]['quick_chat_username']

    if (typeof(quick_chat_data[chat_id]['quick_chat_username_timeout']) != typeof(quick_chat_undefined))
        clearTimeout(quick_chat_data[chat_id]['quick_chat_username_timeout']);

    quick_chat_data[chat_id]['quick_chat_username_timeout'] = setTimeout(function(){
        jQuery.ajax({
            type: 'POST',
            url: quick_chat_js_vars.quick_chat_ajaxurl,
            data: {action: 'quick-chat-ajax-username-check', username_check: username_check, username_old: username_old, room_name: roomname, quick_chat_username_check_nonce: quick_chat_js_vars.quick_chat_username_check_nonce},
            cache: false,
            dataType: 'json',

            success: function(data){
                quick_chat_js_vars.quick_chat_username_check_nonce = data.quick_chat_username_check_nonce;
                if(quick_chat_js_vars.quick_chat_no_participation == 0 && data.quick_chat_no_participation == 1){
                    location.reload();
                }
                jQuery(username_status_element).html('');
                if(data.username_invalid == 1) {
                    jQuery(username_status_element).addClass('quick-chat-error');
                    jQuery(username_status_element).html(quick_chat_js_vars.quick_chat_username_invalid_string);
                }else if(data.username_bad_words == 1){
                    jQuery(username_status_element).addClass('quick-chat-error');
                    jQuery(username_status_element).html(quick_chat_js_vars.quick_chat_username_bad_words_string);
                }else if(data.username_exists == 1){
                    jQuery(username_status_element).addClass('quick-chat-error');
                    jQuery(username_status_element).html(quick_chat_js_vars.quick_chat_username_exists_string);
                } else if(data.username_blocked == 1){
                    jQuery(username_status_element).addClass('quick-chat-error');
                    jQuery(username_status_element).html(quick_chat_js_vars.quick_chat_username_blocked_string);
                }else if(data.username_exists == 0 || data.username_blocked == 0 || data.username_invalid == 0){
                    jQuery(username_status_element).html('');
                    quick_chat_data[chat_id]['quick_chat_username'] = data.username;
                }
            },
            beforeSend: function(){
                jQuery(username_status_element).html('');
                jQuery(username_status_element).removeClass('quick-chat-error');
                jQuery(username_status_element).html(quick_chat_js_vars.quick_chat_username_check_wait_string);
            },
            error: function(){

            }
        });
        quick_chat_data[chat_id]['quick_chat_username_timeout'] = quick_chat_undefined;
    }, 1500);
};

jQuery.quick_chat_update_messages = function(){
    jQuery.post(quick_chat_js_vars.quick_chat_ajaxurl, {
        action: 'quick-chat-ajax-update-messages',
        quick_chat_last_timestamp: quick_chat_js_vars.quick_chat_last_timestamp,
        quick_chat_rooms: quick_chat_rooms,
        quick_chat_update_messages_nonce: quick_chat_js_vars.quick_chat_update_messages_nonce},
        function(data){
            quick_chat_js_vars.quick_chat_update_messages_nonce = data.quick_chat_update_messages_nonce;
            if((quick_chat_js_vars.quick_chat_no_participation == 0 && data.quick_chat_no_participation == 1)
                ||
                (quick_chat_js_vars.quick_chat_no_participation == 1 && data.quick_chat_no_participation == 0)){
                location.reload();
            }
            if(data.quick_chat_success == 1){
                var updates = data.quick_chat_messages;
                quick_chat_js_vars.quick_chat_last_timestamp = updates[updates.length-1].unix_timestamp;
                jQuery('.quick-chat-container').each(function(){
                    var already_notified = 0;
                    var chat_id = jQuery(this).attr('data-chat-id');
                    var room_name = quick_chat_data[chat_id]['quick_chat_room_name'];
                    var username = quick_chat_data[chat_id]['quick_chat_username'];
                    var gravatars = quick_chat_data[chat_id]['quick_chat_gravatars'];
                    var gravatars_size = quick_chat_data[chat_id]['quick_chat_gravatars_size'];
                    var scroll_enable = quick_chat_data[chat_id]['quick_chat_scroll_enable'];
                    for(var i=0;typeof(updates[i])!=typeof(quick_chat_undefined);i++){
                        if(room_name == updates[i].room){
                                if( already_notified == 0
                                    &&
                                    quick_chat_play_audio == 1
                                    &&
                                    username != jQuery.quick_chat_stripslashes(updates[i].alias)
                                    ) {
                                    quick_chat_audio_element.play();
                                    already_notified = 1;
                                }
                                jQuery(this).children('.quick-chat-history-container').append(jQuery.quick_chat_single_message_html(updates[i], username, gravatars, gravatars_size));
                        }
                    }

                    if(scroll_enable == 1){
                        var this_container = jQuery(this).children('.quick-chat-history-container');
                        jQuery(this_container).animate({scrollTop: jQuery(this_container)[0].scrollHeight}, 500);
                    }
            });
        }

            jQuery.quick_chat_update_messages();
        },
        'json'
    );
};

jQuery.quick_chat_update_users = function (){
    quick_chat_users_interval = setInterval(function(){
        jQuery(".quick-chat-container").each(function(){
            var chat_id = jQuery(this).attr('data-chat-id');
            var userlist_position = quick_chat_data[chat_id]['quick_chat_userlist_position'];
            var room_name = quick_chat_data[chat_id]['quick_chat_room_name'];
            var username = quick_chat_data[chat_id]['quick_chat_username'];
            var this_container = jQuery(this);

            jQuery.post(quick_chat_js_vars.quick_chat_ajaxurl, {
                action: 'quick-chat-ajax-update-users',
                to_update_room_name: room_name,
                to_update_user_name: username,
                quick_chat_update_users_nonce: quick_chat_js_vars.quick_chat_update_users_nonce},
                function(data){
                    quick_chat_js_vars.quick_chat_update_users_nonce = data.quick_chat_update_users_nonce;
                    if((quick_chat_js_vars.quick_chat_no_participation == 0 && data.quick_chat_no_participation == 1)
                    ||
                    (quick_chat_js_vars.quick_chat_no_participation == 1 && data.quick_chat_no_participation == 0)){
                    location.reload();
                    }
                    if(quick_chat_js_vars.quick_chat_user_status == 0){
                        var checked_ids = [];
                        jQuery(this_container).find('.quick-chat-users-container input[type=checkbox]:checked').each(function(){
                            checked_ids.push(jQuery(this).attr('data-user-id'));
                        });
                    }

                    var user_list = data.quick_chat_users_list;
                    var string = '';
                    for(var i=0;typeof(user_list[i])!=typeof(quick_chat_undefined);i++){
                        var alias = jQuery.quick_chat_stripslashes(user_list[i].alias);

                        string += "<div class=\"quick-chat-single-user "+jQuery.quick_chat_user_status_class(user_list[i].status)+"\">";

                        if(alias == username || quick_chat_js_vars.quick_chat_no_participation == 1)
                            string += alias;
                        else{
                            if(quick_chat_js_vars.quick_chat_user_status == 0){
                                string += "<input class=\"quick-chat-to-ban-boxes\" type=\"checkbox\" name=\"quick-chat-to-ban[]\" value=\""+user_list[i].ip+"\" data-user-id=\""+user_list[i].id+"\""+((jQuery.inArray(user_list[i].id, checked_ids) == 0) ? " checked=\"checked\"":"")+"/>";
                            }
                            string += "<a href=\"\" title=\""+quick_chat_js_vars.quick_chat_reply_to_string+" "+alias+"\">"+alias+"</a>";
                        }
                        if(userlist_position == 'top' && user_list[i] !== user_list[user_list.length-1]){
                            string += ",";
                        }
                        string += "</div>";
                    }

                    jQuery(this_container).children('.quick-chat-users-container').html(string);
                },
                'json'
            );
        });
    }, quick_chat_js_vars.quick_chat_timeout_refresh_users);
};

jQuery.quick_chat_delete_messages = function (chat_id, to_delete_ids){
    var to_delete_room_name = quick_chat_data[chat_id]['quick_chat_room_name'];
    jQuery.post(quick_chat_js_vars.quick_chat_ajaxurl, {
        action: 'quick-chat-ajax-delete',
        to_delete_ids: to_delete_ids,
        to_delete_room_name: to_delete_room_name,
        quick_chat_delete_nonce: quick_chat_js_vars.quick_chat_delete_nonce},
        function(data) {
            quick_chat_js_vars.quick_chat_delete_nonce = data.quick_chat_delete_nonce;

            jQuery(".quick-chat-container").each(function(){
                var this_chat_id = jQuery(this).attr('data-chat-id');
                var this_room_name = quick_chat_data[this_chat_id]['quick_chat_room_name'];
                var this_username = quick_chat_data[this_chat_id]['quick_chat_username'];
                var gravatars = quick_chat_data[chat_id]['quick_chat_gravatars'];
                var gravatars_size = quick_chat_data[chat_id]['quick_chat_gravatars_size'];

                if(this_room_name == to_delete_room_name){
                    messages = data.quick_chat_messages;
                    var string = '';
                    for(var i=0;typeof(messages[i]) != typeof(quick_chat_undefined);i++){
                        string += jQuery.quick_chat_single_message_html(messages[i], this_username, gravatars, gravatars_size);
                    }
                    jQuery(this).children('.quick-chat-history-container').html(string);
                }
            });
        });
};

jQuery.quick_chat_ban_users = function (chat_id, to_ban_ips){
    var this_chat = jQuery.find('div[class=quick-chat-container][data-chat-id="'+chat_id+'"]');
    jQuery.post(quick_chat_js_vars.quick_chat_ajaxurl, {
        action: 'quick-chat-ajax-ban',
        to_ban_ips: to_ban_ips,
        quick_chat_ban_nonce: quick_chat_js_vars.quick_chat_ban_nonce},
        function(data) {
            quick_chat_js_vars.quick_chat_ban_nonce = data.quick_chat_ban_nonce;
            jQuery(this_chat).find('.quick-chat-users-container input[type=checkbox]').each(function(){
                jQuery(this).attr('checked', false);
            });
        });
};

jQuery.quick_chat_new_message = function (chat_id, message_text){
        var room_name = quick_chat_data[chat_id]['quick_chat_room_name'];

        jQuery.post(quick_chat_js_vars.quick_chat_ajaxurl,
                    {action: 'quick-chat-ajax-new-message',
                    message: message_text,
                    room: room_name,
                    quick_chat_new_message_nonce: quick_chat_js_vars.quick_chat_new_message_nonce},
                    function(data) {
                        quick_chat_js_vars.quick_chat_new_message_nonce = data.quick_chat_new_message_nonce;
                        if(quick_chat_js_vars.quick_chat_no_participation == 0 && data.quick_chat_no_participation == 1){
                            location.reload();
                        }
                    });
};

jQuery(window).load(function() {
    if(typeof(quick_chat_js_vars) != typeof(quick_chat_undefined)){
        jQuery('.quick-chat-history-container').each(function(){
            jQuery(this).animate({scrollTop: jQuery(this)[0].scrollHeight}, 250);
        });

        if(quick_chat_audio_support){
            jQuery("div.quick-chat-sound-link").css('display','block');
            jQuery.quick_chat_update_sound_state();
        }

        jQuery.quick_chat_update_rooms();

        jQuery.quick_chat_update_users();

        jQuery('.quick-chat-message').bind('keypress', function(e) {
            code = e.keyCode ? e.keyCode : e.which;
            if(code.toString() == 13) {
                e.preventDefault();

                var message_text = jQuery.trim(jQuery(this).val());
                if(message_text != ''){
                    var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');
                    jQuery(this).val('');
                    jQuery.quick_chat_new_message(chat_id, message_text);
                }
            }
        });

        jQuery('input.quick-chat-send-button').bind('click', function(e) {
            e.preventDefault();

            var message_text = jQuery.trim(jQuery(this).prev().val());
            if(message_text != ''){
                var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');
                jQuery(this).prev().val('');
                jQuery.quick_chat_new_message(chat_id, message_text);
            }
            jQuery(this).prev().focus();
        });

        jQuery('.quick-chat-alias').bind('keyup', function(){
            var username_check = jQuery.trim(jQuery(this).val());
            if(username_check != ''){
                var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');
                var username_status_element = jQuery(this).parents('.quick-chat-container').find('span.quick-chat-username-status');

                jQuery.quick_chat_check_username(chat_id, username_check, username_status_element);
            }
        });

        jQuery("div.quick-chat-smile").bind('click', function() {
            var input_textarea = jQuery(this).parents('.quick-chat-container').find('.quick-chat-message');

            jQuery(this).fadeTo(100, 0, function() {
                jQuery(input_textarea).quick_chat_insert_at_caret(jQuery(this).attr('title'));
                jQuery(this).fadeTo(100, 1);
            });
        });

        jQuery("div.quick-chat-history-alias a, div.quick-chat-single-user a").live('click', function(e) {
            e.preventDefault();
            var input_textarea = jQuery(this).parents('.quick-chat-container').find('.quick-chat-message');

            jQuery(this).fadeTo(100, 0, function() {
                jQuery(input_textarea).quick_chat_insert_at_caret('@'+jQuery(this).text()+': ');
                jQuery(this).fadeTo(100, 1);
            });
        });

        jQuery("div.quick-chat-sound-link a").bind('click', function(e) {
            e.preventDefault();

            jQuery(this).fadeTo(100, 0, function() {
                if(quick_chat_play_audio == 1){
                    quick_chat_play_audio = 0;
                } else{
                    quick_chat_play_audio = 1;
                }

                jQuery.quick_chat_cookie('quick_chat_sound_state', quick_chat_play_audio, {path: quick_chat_js_vars.quick_chat_cookiepath, domain: quick_chat_js_vars.quick_chat_cookie_domain});

                jQuery.quick_chat_update_sound_state();

                jQuery(this).fadeTo(100, 1);
            });
        });

        jQuery("div.quick-chat-scroll-link a").bind('click', function(e) {
            e.preventDefault();

            var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');
            var scroll_enable = quick_chat_data[chat_id]['quick_chat_scroll_enable'];

            jQuery(this).fadeTo(100, 0, function() {
                if(scroll_enable == 0){
                    quick_chat_data[chat_id]['quick_chat_scroll_enable'] = 1;
                    jQuery(this).css('text-decoration','none');
                } else{
                    quick_chat_data[chat_id]['quick_chat_scroll_enable'] = 0;
                    jQuery(this).css('text-decoration','line-through');
                }
                jQuery(this).fadeTo(100, 1);
            });
        });

        jQuery(".quick-chat-translate-link a").live('click', function(e) {
            e.preventDefault();
            jQuery(this).fadeTo(100, 0, function() {
                if(jQuery(this).css('text-decoration') == 'none'){
                    jQuery(this).parents('.quick-chat-history-message-alias-container').find('.quick-chat-history-message').translate('', quick_chat_dest_lang, {fromOriginal: true});
                    jQuery(this).css('text-decoration','line-through');
                } else if(jQuery(this).css('text-decoration') == 'line-through'){
                    jQuery(this).parents('.quick-chat-history-message-alias-container').find('.quick-chat-history-message').translate('');
                    jQuery(this).css('text-decoration','none');
                }
                jQuery(this).fadeTo(100, 1);
            });
        });

        if(quick_chat_js_vars.quick_chat_user_status == 0){
            jQuery("div.quick-chat-delete-link a").bind('click', function(e) {
                e.preventDefault();

                var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');

                var to_delete_ids = [];
                jQuery(this).parents('.quick-chat-container').find('.quick-chat-history-container input[type=checkbox]:checked').each(function(){
                    to_delete_ids.push(jQuery(this).val());
                });

                jQuery(this).fadeTo(100, 0, function() {
                    if(to_delete_ids == ""){
                        alert(quick_chat_js_vars.quick_chat_delete_what_string);
                    } else{
                        if (confirm(quick_chat_js_vars.quick_chat_delete_confirm_string)){
                            jQuery.quick_chat_delete_messages(chat_id, to_delete_ids);
                        }
                    }
                    jQuery(this).fadeTo(100, 1);
                });
            });

            jQuery("div.quick-chat-ban-link a").bind('click', function(e) {
                e.preventDefault();

                var chat_id = jQuery(this).parents('.quick-chat-container').attr('data-chat-id');

                var to_ban_ips = [];
                jQuery(this).parents('.quick-chat-container').find('.quick-chat-users-container input[type=checkbox]:checked').each(function(){
                    to_ban_ips.push(jQuery(this).val());
                });

                jQuery(this).fadeTo(100, 0, function() {
                    if(to_ban_ips == ""){
                        alert(quick_chat_js_vars.quick_chat_ban_who_string);
                    } else{
                        if (confirm(quick_chat_js_vars.quick_chat_ban_confirm_string)){
                            jQuery.quick_chat_ban_users(chat_id, to_ban_ips);
                        }
                    }
                    jQuery(this).fadeTo(100, 1);
                });
            });

            var quick_chat_toggle = false;
            jQuery("div.quick-chat-select-all-link a").live('click', function(e){
                e.preventDefault();
                jQuery(this).fadeTo(100, 0, function() {
                    jQuery(this).parents('.quick-chat-container').find('.quick-chat-history-container input[type=checkbox]').attr('checked',!quick_chat_toggle);
                    quick_chat_toggle = !quick_chat_toggle;
                    jQuery(this).fadeTo(100, 1);
                });
            });
        }

        jQuery.translate(function(){
            jQuery.translate.quick_chat_ui('select', 'option').change(function(){
                quick_chat_dest_lang = jQuery(this).val();
                jQuery.quick_chat_cookie('quick_chat_dest_lang', quick_chat_dest_lang, {path: quick_chat_js_vars.quick_chat_cookiepath, domain: quick_chat_js_vars.quick_chat_cookie_domain});
            }).val(quick_chat_dest_lang).prependTo('.quick-chat-language-container');
        });

        jQuery.quick_chat_update_messages();
    }
});