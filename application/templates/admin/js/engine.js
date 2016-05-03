/**
 *     Движок для ajax-навигации
 *
 *     @author: Trudovoy Andrew 
 *     @email:  <born4css@gmail.com>
 *     @date:   30.12.2012          
 *                          
 */
 /*=======================================================================================*/

(function( $ ){



	


	/**
	 *		Глумимся над любителями фаербага
	 */
	/*************************************************************************************/

	$('body').data('diffHeight', window.outerHeight-window.innerHeight);
	$( 'aside' ).height( $( document ).height() - 20 );

	$(window).on('resize', function(){

		// if( ( window.outerHeight-window.innerHeight ) > $('body').data('diffHeight') ){				
		// 	$('.gangnam').stop().fadeIn('fast');					
		// } 
		// else{ 
		// 	$('.gangnam').stop().fadeOut('fast');
		// }

		 /**
		 *		Ресайз сайдбара
		 */
		/*************************************************************************************/
		$( 'aside' ).height( $( document ).height() - 20 );	 

	});


	bindLinkHistory('a');

    /**
     *  Форма поиска в админке
     *
     */
    $( '.search input[type=text]' ).on( 'keydown', function() {

    	$( this ).attr( 'data-startpage') == undefined ? $( this ).attr( 'data-startpage', history.location || document.location ) : '';
    });

    $( '.search input[type=text]' ).on( 'keyup', function() {

    	//$( this ).data( 'data-startpage') == undefined ? $( this ).data( 'data-startpage', history.location || document.location ) : '';

    	if( $( this ).val().length >= 3 )
    	{

    		var url = "/admin/secrets/?w=" + $( this ).val();
    		history.pushState( null, null, url ); 
        	loadContent( url, '.content');
        	return false;

    	}
    	else
    	{
    		//console.log($( this ).attr( 'data-startpage' ));
    		//history.pushState( null, null, $( this ).data( 'data-startpage' ) ); 
        	loadContent( $( this ).attr( 'data-startpage' ), '.content');    		
    	}
    });

    // вешаем событие на popstate которое срабатывает при нажатии back/forward в браузере
    $( window ).unbind("popstate").bind( "popstate", function( e ) {
        // получаем нормальный объект Location
        var returnLocation = history.location || document.location;      
		loadContent(returnLocation, '.content');       
    });



    // Первичная инициализация скриптов( при первой загрузке страницы или при ф5 )
    wyciwygMe();

    $( '#datetimepicker1' ).datetimepicker(
    	{format: 'yyyy-MM-dd hh:mm:ss'}
    	);
	$( '#datetimepicker2' ).datetimepicker(
		{format: 'yyyy-MM-dd hh:mm:ss'}
		);

	$( '.datetimepicker3' ).datetimepicker(
		{
			pickDate: false,
			pick12HourFormat: true
		}
	);
    
	 

	



})( jQuery );

	/**
	 *		Инициализация history.api
	 */
	/*************************************************************************************/
	// ищем все ссылки и вешаем события на все ссылки в нашем документе
	//$( 'a[href^="/"]' ).addClass('binded');
    function bindLinkHistory(elements) { 

    	var elements = elements || 'a',
    		isExternal = new RegExp( '/' + window.location.host + '/' );

    	$(elements).unbind('click').bind('click', function() { 		
    	
	    	if( $( this ).hasClass( 'ext' ) == false && isExternal.test( this.href ) && $( this ).hasClass( 'lightbox' ) == false )
	    	{    		
	        	history.pushState( null, null, this.href ); 
	        	loadContent(this.href, '.content');

	        	if( $(this).closest('li').length > 0 )
		        {
		        	$('.menu li').removeClass('active');
		        	$(this).closest('li').addClass('active');
		        }

	        	return false;
	    	}

	    	else
	    	{
	    		return true;
	    	}
	    	       
	    	}
    	);

    };


	/**
	 *		Функция загружает контент в dom-дерево
	 *		@URL: {адрес страницы}
	 *		@target: {селектор} - например '.content'
	 */
	/*************************************************************************************/
	function loadContent( URL, target )	
	{

		$.ajax({
			type: "GET",
			url:  URL,		  
			success: function(msg){

				$(target).html(msg);

				// Вешаем события на котентскую часть
				bindLinkHistory('.content a');

			   /**
	 			*
	 			* Обновление title
	 			* @author E.Isaev
	 			*/

				$( "title" ).text( meta_title );
				$( window ).trigger( 'resize' );
				$( 'aside' ).height( $( document ).height() - 20 );

				wyciwygMe();

				initNagibakaTranslit();	

				$( '#datetimepicker1' ).datetimepicker(
					{format: 'yyyy-MM-dd hh:mm:ss'}
					);
				$( '#datetimepicker2' ).datetimepicker(
					{format: 'yyyy-MM-dd hh:mm:ss'}
					);
				$( '.datetimepicker3' ).datetimepicker(
					{
						pickDate: false,
						pick12HourFormat: true
					}
				);

			}
		});


	}




	/**
	 *  Навешиваем визуальный редактор на все текстарии с классом "wyciwyg"
	 */
	function wyciwygMe()
	{
		$( 'textarea.wyciwyg' ).each( function( e, i ) {

			var textareaId = 'editMeFully' + e;
			$( this ).attr( 'id', textareaId );
			CKEDITOR.replace( textareaId );

		});
	}




		

		
