/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function createSliderButton(slider, button, action) {
    $(button).click(function() {
        $(slider).flexslider(action);
    });
}
function scrollTop() {
    $('body, html').animate({
        scrollTop: 0
    }, 500);
}
function textareaPlacehodler() {
    $(this).on('keyup', function() {
        if ($(this).val()) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
}
