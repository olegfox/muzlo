$(function(){
    var r = Raphael('map', 680, 450),
        attributes = {
            // TODO: Changed map settings
            'fill': '#eee',
            'stroke': '#000',
            'stroke-width': 1,
            'stroke-opacity': 0.2,
            'stroke-linejoin': 'round'
        },
        arr = new Array();
    s="hello";

    // TODO: Add to SVG responsive settings
    r.canvas.setAttribute('preserveAspectRatio', 'xMidYMid meet');

    // TODO: Make baloon hidden by default
    $('.baloon').hide();

    for (var country in paths) {
        $('#city').append('<option value="' + country + '">' + paths[country].name + '</option>');
        var obj = r.path(paths[country].path);
        obj.attr(attributes);
        arr[obj.id] = country;


        obj.hover(function(){
                this.animate({
                    // TODO: Changed this color too
                    fill: '#60d1ff'
                }, 300);

                // document.location.hash = arr[this.id];
                $('.baloon').html(paths[arr[this.id]].name);
                $('.baloon').show();
            }, function(){
                this.animate({
                    fill: attributes.fill
                }, 300);
                $('.baloon').hide();
            })
            .click(function(){

                document.location.hash = arr[this.id];
                console.log(document.location.hash);

                $('#city').val( arr[this.id] ).trigger('change');

                // TODO: Update choosen too
                $('#city').trigger("chosen:updated");

                $('.point').remove();
                $('#map').after($('<div />').addClass('point'));
            });


        // TODO: Changed LIVE with ON. Because there are some errors
//        $('.point .close').live('click', function(){
        $('.point').on('click', '.close', function(){
            $(this).closest('.point').fadeOut(function(){
                this.remove();
            });
            return false;
        });

    }

    $('#map').bind( 'mousemove', function (e) {
//        console.log(e);
//        console.log('X offset:' + e.offsetX);
//        console.log('Y offset:' + e.offsetY);
        $('.baloon').css({
//            "left": e.layerX + "px",
//            "top": e.layerY + "px"
            // TODO: Centered baloon
            "left": e.pageX - $('#map').offset().left - $('.baloon').outerWidth()/2 + "px",
            "top": e.pageY - $('#map').offset().top - 60 + "px"
        })
    });

    var container = document.getElementsByTagName('svg')[0];
    container.setAttribute('viewBox','0 0 455 295');

    // Confirmation
    $('#city').bind('change', function(){

        document.location.hash = arr[$('#city').val()];
        $.confirm({
            'title'		: 'Выбор города',
            'message'	: 'Вы уверены что хотите выбрать этот город?',
            'buttons'	: {
                'Ок'	: {
                    // TODO: Changed classes
//                    'class'	: 'blue',
                    'class'	: 'btn btn-green',
                    'action': function(){
                        // window.parent.document.location.href = '/?city=' + document.location.hash.replace(/#/,'');
                        $(window.parent.document).find('.city').html( paths[document.location.hash.split('#')[1]-1+""].name );
                        
                        setCookie("this_city", document.location.hash.split('#')[1]-1, {path: '/', expires: 999999999 } );
                        window.parent.document.location.reload();

                        // TODO: Now we don't need colorbox for all this stuff...
//                        window.parent.$.colorbox.close();
                    }
                },
                'Отмена'	: {
                    // TODO: Changed classes
//                    'class'	: 'gray',
                    'class'	: 'btn btn-red',
                    'action': function(){
                        // console.log(document.location.hash.split('#')[1]);
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });

    });

    // возвращает cookie если есть или undefined
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined
    }

    // уcтанавливает cookie
    function setCookie(name, value, props) {
        props = props || {};
        var exp = props.expires;

        if (typeof exp == "number" && exp) 
        {

            var d = new Date();
            d.setTime(d.getTime() + exp*1000);

            // console.log(d);

            exp = props.expires = d;
        }

        if(exp && exp.toUTCString) { props.expires = exp.toUTCString() }

        value = encodeURIComponent(value);
        var updatedCookie = name + "=" + value;
        for(var propName in props){
            updatedCookie += "; " + propName;
            var propValue = props[propName];
            if(propValue !== true){ updatedCookie += "=" + propValue }
        }
        document.cookie = updatedCookie

    }

    // удаляет cookie
    function deleteCookie(name) {
        setCookie(name, null, { expires: -1 })
    }

});
