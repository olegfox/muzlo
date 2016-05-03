/**
 *     Движок для ajax-навигации
 *
 *     @author: Trudovoy Andrew 
 *     @email:  <born4css@gmail.com>
 *     @date:   30.12.2012          
 *                          
 */
 /*=======================================================================================*/

	function initNagibakaTranslit()
	{
			$( '[data-module=nagibaka-translit]' ).each( function () {

				if( $( this ).data( 'init' ) != 1 )
				{

					var it = $( this );
					//сам плагин

					//разбираем параметры
					var data = $( this ).attr( 'data-params' ).split( '|' );
					var params = {
									checkbox: data[0],
									editarea: data[1],
									label: data[2]
								 };

					//проверяем чекбокс - вешаем дизейбл при необходимости
					function checkIn()
					{
						if( $( params.checkbox ).attr( 'checked' ) == 'checked' )
						{
							$( it ).attr( 'readonly', 'readonly' );
							//вешаем обработку события на название
							$( params.editarea ).on( 'keyup', function () {

								if( $( this ).attr('value') != '' )
								{

									$( it ).val( 'Переводится...' )

									$.getJSON( "/admin/ajax/url/",
												{
													text: $( params.editarea ).val()
												},
												function( data )
												{										
													data.status == "ok" ? $( it ).val( data.text ) | $( params.label ).html( data.text ) : '';
												}

									);		
								}


								console.log ( this );															

							});

							// $( params.editarea ).trigger( 'keyup' );	

						}
						else
						{
							$( it ).removeAttr( 'readonly' );
							$( params.editarea ).off( 'keyup' );	
						}
					}
					checkIn();

					$( params.checkbox ).on( 'change', function () {
						checkIn();
					});
					
					
					$( this ).data( 'init', 1 );
				}
				

			});
	}

	initNagibakaTranslit();
	
