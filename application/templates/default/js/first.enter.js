/*
 * First entered user must select city. This JS is used for this purposes...
 */

$(function () {

    // TODO: В любом случае, вы можете проверять своим способом есть ли куки что первый раз заходит пользоваель.

    // TODO: Кажеться, нужно перезагрузить страницу после выбора города... Хотя я не уверен как оно должно работать в оригинале

    $(document).ready(function () {
        // If cookie is not set, we set it for 10 days and make visible city selector
        if(document.cookie.search(/(^|;)visited=/) == -1) {
            document.cookie = "visited=true;max-age=" + 60 * 60 * 24 * 10;

            // Toggle background mask and add to it additional class
            $('body').addClass('first-enter-wrap');
            $('#mask').addClass('first-enter').fadeIn(400);

            // Load via AJAX map
            $('#map-wrapper-outside').addClass('first-enter').load($('#select-country-btn').attr('href'), function(){
                // Init chosen for inner select
                $('#map-wrapper').find('select').chosen({width: '100%', no_results_text: "Нет результатов"});
                // On complete - show wrapper
                $('#map-wrapper-outside').fadeIn(400);
            });
        }
    });

});