/*
 * This JS handles old browser messages and other stuff like this
 */

$(function () {

    $(document).ready(function () {

        // Test if current browser supports svg of canvas, and throw message about modern browsers
        if(!Modernizr.canvas || !Modernizr.svg) {
            throwBrowserMessage('Ваш браузер устарел', 'Вы пользуетесь устаревшим браузером, который не поддерживает современные веб-стандарты и представляет угрозу вашей безопасности. Пожалуйста, установите современный браузер: <br/><a target="_blank" href="http://www.getfirefox.com/">Mozilla Firefox</a>, <a target="_blank" href="http://www.google.com/chrome/">Google Chrome</a>, <a target="_blank" href="http://www.getie.com/">Internet Explorer</a>');
        }

        if(!Modernizr.filereader) {
            // There is nothing to throw, because we simply hide upload file button on website via CSS.
        }
    });

    var throwBrowserMessage = function(title, content) {
        var messageProto = '<div class="browser-message"><div class="browser-close"></div>' +
            '<div class="browser-title">' + title + '</div>' +
            '<div class="browser-content">' + content + '</div></div>';

        $('body').append('<div id="white-mask"></div>');
        $('#white-mask').addClass('first-enter white-mask').fadeIn(400, function(){
            $(this).before(messageProto).fadeIn(400);
        });

    };
});