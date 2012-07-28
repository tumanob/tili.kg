$(function() {

    $('div.image').each(function(i, el) {
	$(el).find('li').hide();
	$(el).find('li').first().show();
    })
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
        var tipVisX = $(window).width() - (mousex + tipWidth);
        var tipVisY = $(window).height() - (mousey + tipHeight);

        if ( tipVisX < 20 ) {
            mousex = e.pageX - tipWidth - 20;
        } if ( tipVisY < 20 ) {
            mousey = e.pageY - tipHeight - 20;
        }
        tip.css({  top: mousey, left: mousex });
    });
})

