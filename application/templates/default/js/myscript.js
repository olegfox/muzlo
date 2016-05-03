/* ============================================================================
 *  User scripts for site
 * ============================================================================
 *
 *  @author: Trudovoy Andrew
 *  @email: <born4css@gmail.com>
 *  
 * ==========================================================================*/


/*---------------------------------------------------------------------------*/
/*   О Б Р А Б О Т К А   С О Б Ы Т И Й
/*---------------------------------------------------------------------------*/

$( function() {

        /*********************************************************************/
        /**  Выводим сообщение  */
        $( 'h1' ).on( 'click', function() {
            console.log( 'test' );
        });


        $( '.w' ).on( 'keyup', function () {

            if( $( this ).val().length >= 3 )
            {
                $.getJSON("/secrets/search/",
                    {
                        w: $( '.w' ).val(),
                        json: 1
                    },
                    function(data){

                        var html ='<ul>';

                        $.each(data.items, function(i,item){

                            html += '<li><a href="/';
                            html += item.id;
                            html += '/"><span>';
                            html += ' #' + item.id;
                            html += '</span><em>' + item.date_add +'</em><dfn>' + item.author_name + '</dfn>';
                            html += '</a></li>';   

                        });

                        html += '</ul>';

                        if( data.items.length == 0 ) { html ="<span>Ничего не найдено!</span>"}

                        $( '.results' ).html( html ).show();
                    }
                );
            }
            else 
            {
                $( '.results' ).html( '' ).hide();
            }

        });

         function getCookie(name) {
            
            var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined
            }

            getCookie("this_city") == undefined ? $('#select-country-btn').trigger('click') : "";


        /** Vote */
        $( '.post-likes' ).on( 'click', function () {

            var me = $( this );

            console.log( me );

            $.post(
                '/secrets/rate/',
                {
                    id: me.attr( 'data-id' )
                },
                function ( data )
                {
                    if( data.status == 'ok' )
                    {
                        me.find( 'span:first' ).html( data.rating );
                        me.addClass( 'active' );
                        me.find( 'span:first' ).after( '' ); //<em>Спасибо за ваш голос!</em>

                        me.closest( 'div' ).find( 'em' ).stop().animate( { opacity: 0.98 }, 1 ).animate( { opacity: 0.99 }, 3000 ).animate( { opacity: 0.0 }, 500, function(){$(this).hide();} );
                    }
                    else 
                    {
                        if( me.closest( 'div' ).find( 'em' ).length > 0 )
                        {
                            me.closest( 'div' ).find( 'em' ).html( data.msg );
                            me.closest( 'div' ).find( 'em' ).stop().animate( { opacity: 0.98 }, 1 ).animate( { opacity: 0.99 }, 3000 ).animate( { opacity: 0.0 }, 500, function(){$(this).hide();} );
                        }
                        else
                        {
                            me.find( 'span:first' ).after( '' ); //<em>' + data.msg + '</em>
                            me.closest( 'div' ).find( 'em' ).stop().animate( { opacity: 0.98 }, 1 ).animate( { opacity: 0.99 }, 3000 ).animate( { opacity: 0.0 }, 500, function(){$(this).hide();} );
                        }
                       
                    }
                },
                'JSON'

            );

            return false;

        });


        $( '.reload' ).on( 'click', function () {

            var code = "/secrets/captcha/?rand=" + Math.floor( Math.random( 1000000 ) * 1000000 );
            $( this ).closest( '.captcha-wrapper' ).find( 'img' ).attr( 'src', code );
        });


        




});

/*---------------------------------------------------------------------------*/
/*   В С П О М О Г А Т Е Л Ь Н Ы Е   Ф У Н К Ц И И
/*---------------------------------------------------------------------------*/


        /**
         *   Функция показа/скрытия ошибок 
         *                                                   
         *   @elementId: {имя селектора или объект jQuery}  - например $('#idd') или '#idd' 
         *   @mode:      {show, hide}  - показать, скрыть подсказу с ошибкой 
         */ 
        function errorBox( elementId, mode )
        {   
            var container = ( typeof( elementId ) == "object" ) ? elementId.closest( '.control-group' ) : $( elementId ).closest( '.control-group' );
            var errorMessage = container.attr( 'data-error-message' );

            if( mode == "show" )
            {
                container.addClass( 'error' );
                container.find( 'span.error' ).length > 0 ? 
                    container.find( 'span.error' ).show() :
                    $( elementId ).closest( 'div' ).append( '<span class="error">' + errorMessage + '</span>' ).find( '.error' ).show();
            }
            else
            {
                container.removeClass( 'error' );
                container.find( 'span.error' ).hide();
            }   
        }



/*---------------------------------------------------------------------------*/
/*   К Л А С С Ы (объекты js, можно вынести в отдельные файлы)
/*---------------------------------------------------------------------------*/


// $( '.city' ).on('click', function () {
//  $.colorbox({
//         'width': '100%',
//         'height': '100%',
//         'autoScale': true,
//         'iframe' : true,
//         'showClose': false, 
//         'overlayClose': false,
//         'href': '/map/index.html'
//     });

//     $('#cboxClose').remove();
//     $('#cboxMiddleLeft').remove();
//     $('#cboxMiddleRight').remove();
//     $('#cboxTopCenter').remove();
//     $('#cboxBottomCenter').remove();
//     $('#cboxTopLeft').remove();
//     $('#cboxTopRight').remove();
//     $('#cboxBottomLeft').remove();
//     $('#cboxBottomRight').remove();
//     $('#cboxLoadedContent').css('position','fixed');
// });