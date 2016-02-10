var input_element_focus = false;
var range = {start:0, end:0};
var bufVal = '';
var bufReplace = '';

jQuery(document).ready(function() {
    var $FCB = jQuery('#float_chars_block');
    //var $FCI = jQuery('#float_chars_icon');

    function setCharacter(character) {
        if (!input_element_focus)return false;
        var newText = '';
        var value = jQuery(input_element_focus).val();
        if(jQuery.trim(bufReplace)!=''){
            value=value.replace(bufReplace,'');
            jQuery(input_element_focus).val(value);
        }
        if(value.length>0){
         var startText = value.substr(0, range.start);
         var endText = value.substr(range.end, value.length);
         newText = startText + character + endText;
        }else{
         newText = character;
        }
        jQuery(input_element_focus).val(newText);

        jQuery(input_element_focus).caretPos(parseInt(range.start) + 1, parseInt(range.start) + 1);
        jQuery(input_element_focus).focus();
    }
    jQuery(document).click(function(e){
        var $clicked=jQuery(e.target);
        if($clicked.attr('id')=='float_chars_block' || $clicked.closest('#float_chars_block').size()>0){
            return false;
        }else{
            $FCB.hide();
        }
    });

    jQuery('#float_chars_block .close').click(function() {
        $FCB.fadeOut();
    });
    jQuery(':text, textarea')
    .focus(function() {
        input_element_focus = this;
        if(jQuery.trim(this.value)=='' && jQuery.trim(this.value)!=bufVal){
            bufReplace = bufVal;
        }else{
            bufReplace = '';
        }


        range = jQuery(input_element_focus).caretPos();
        //if($FCB.is(':visible'))$FCB.hide();
        var cur_offset = jQuery(this).offset();
        var pos = {left:cur_offset.left, top:cur_offset.top-30};
      //  if(!$FCB.is(':visible'))$FCB.css(pos).show();
          if(!$FCB.is(':visible'))$FCB.show();
    })
    .bind('mousedown', function() {
        bufVal = jQuery.trim(this.value);
    }).bind('click keyup', function() {
        input_element_focus = this;
        range = jQuery(input_element_focus).caretPos();
        return false;
    }).bind('keyup', showEventDetails);


    jQuery('span', $FCB).click(function() {

        var character = jQuery(this).text();
        setCharacter(character);
    });

    function showEventDetails(event) {
        switch (event.keyCode) {
            case 69:
                if (event.altKey && event.ctrlKey && !event.shiftKey) {
                    setCharacter('ү');
                } else if (event.altKey && event.ctrlKey && event.shiftKey) {
                    setCharacter('Ү');
                }
                break;
            case 89:
                if (event.altKey && event.ctrlKey && !event.shiftKey) {
                    setCharacter('ң');
                } else if (event.altKey && event.ctrlKey && event.shiftKey) {
                    setCharacter('Ң');
                }
                break;
            case 74:
                if (event.altKey && event.ctrlKey && !event.shiftKey) {
                    setCharacter('ө');
                } else if (event.altKey && event.ctrlKey && event.shiftKey) {
                    setCharacter('Ө');
                }
                break;
        }
        return false;
    }
});
