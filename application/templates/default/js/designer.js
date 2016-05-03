/*
 * All JS related to submitting whispers (including canvas picture designer)
 */

$(function () {

    var $wrapperSelectPic = $('#select-pic-wrap'), // Fieldset with selecting picture
        $wrapperDesignPic = $('#design-pic-wrap'), // Fieldset for pic designer
        $selectPicBtn = $('#select-pic-btn'),

        $fileInput = $('#whisper-file'),

        $availablePics = $('.available-pics'),
        selectedUrl = null,

        // Canvas variables
        $canvas = $('#whisper-designer'),
        canvas = $canvas[0],
        $canvasWrapper = $('#send-form'),
        canvasRatio = 0,
        context = null,
        imageObj = new Image(),
        imageSrc = null,
        imageUrl = null,
        inAction = false,
        canvasInited = false,

        copyright = "iHeard.com.ua",

        // Initialization of canvas element
        baseWidth = 780, // Basic width of canvas wrapper
        currentWidth = baseWidth,
        maxWidth = 740, // Max width for text
        fontFamily = "sans-serif",
        textTop = "",
        textBottom = "",

        // Inputs for canvas
        $textInputs = $('.whisper-text-input'),
        $topTextInput = $('#whisper-top-text'),
        $bottomTextInput = $('#whisper-bottom-text'),
        $symbolMax = $('.symbol-max'),
        $symbolTop = $('.symbol-top'),
        $symbolBottom = $('.symbol-bottom'),
        maxSymbols = 80, // Max number of symbols what we can add in input

        $fontFamilyRadio = $('#whisper-how-write input'),
        $writeInputsRadio = $('#whisper-where-write input'),
        $fontSizeSelect = $('#whisper-font-size select'),

        fontSizeRatio = 1, // Used for fontSize select. Calculate aspect ratio with... MAGIC! :)

        // Submiting form
        $formSubmit = $('#whisper-submit');

    var getFontSize = function(){
        return Math.floor(currentWidth * fontSizeRatio / 27.85); // Something like 28pt size
    };

    var getLineHeight = function(){
        return Math.floor(fontSize / 0.875); // Around 32pt line height
    };

    var getMargin = function(){
        return Math.floor(currentWidth * fontSizeRatio / 17); // Around 60pt, MAGIC again... :)
    };

    var fontSize = getFontSize(), // Something like 28pt size
        lineHeight = getLineHeight(), // Around 32pt line height
        margin = getMargin(); // Around 40

    // Toggle button for selecting prepared images from gallery, and, on click on it
    // load in canvas
    // -------------------------------------------------------------------------------

    $selectPicBtn.on('click', function(e){
        e.preventDefault();
        $selectPicBtn.toggleClass('active');
        $wrapperSelectPic.slideToggle();
        // If designer is visible - hide it
        if($wrapperDesignPic.is(':visible')) {
            $wrapperDesignPic.slideUp();
        }
        else {
            if(canvasInited) {
                $wrapperDesignPic.slideDown();
            }
        }
    });
    // If we close gallery with 'X' button - remove active class from 'select from gallery' button
    $wrapperSelectPic.on('click', '.close-btn', function(){
        $selectPicBtn.removeClass('active');
    });

    $availablePics.on('click', 'a', function(e){
        var $this = $(this);
        e.preventDefault();
        // On click - get from A tag url for big picture and after - load it in new wrapper
        selectedUrl = $this.attr('href');

        $selectPicBtn.removeClass('active');
        $wrapperSelectPic.slideUp();
        // Init canvas with selected image URL
        initCanvas(selectedUrl);
        $wrapperDesignPic.slideDown();
    });

    // FileReader functionality for creating canvas element
    // -------------------------------------------------------------------------------
    $fileInput.on('change', function(e){
       var file = $fileInput[0].files[0],
           imageType = /image.*/;

       if(file.type.match(imageType)) {

           var reader = new FileReader();


           reader.onload = function(e) {
               // Init canvas wrapper
               initCanvas(reader.result);
               // Show inited canvas item
               $wrapperSelectPic.slideUp();
               $wrapperDesignPic.slideDown();
               // Remove old message if image is successfully uploaded
               $('#write-pic-wrap').find('.message').remove();
           };
           reader.readAsDataURL(file);
       }
       else {
           throwMessage('error', 'Недопустимый формат картинки. Попробуйте снова', '#write-pic-wrap > .form-item .value');
       }
    });

    // Canvas functions
    // -------------------------------------------------------------------------------
    var initCanvas = function(imageUrl) {
        if(canvas && canvas.getContext) {
            context = canvas.getContext('2d');
            canvasInited = true;
            // First load image in initialization
            imageObj.onload = function() {
                // Calculate canvas aspect ratio
                canvasRatio = imageObj.width / imageObj.height;
                context.drawImage(this, 0, 0, imageObj.width, imageObj.height, 0, 0, canvas.width, canvas.height);
                refreshCanvas();   // Call first time when image is loaded
            };
            imageSrc = imageUrl;
            imageObj.src = imageSrc;

            // Place event on resize
            $(window).on('resize', function(){
                refreshCanvas();
            });
        }
    };

    var refreshCanvas = function(){
        currentWidth = $canvasWrapper.width();
        maxWidth = currentWidth / 1.05;

        $canvas.attr('width', currentWidth);
        $canvas.attr('height', Math.floor(currentWidth/canvasRatio));

        drawImage();
    };

    // Draw image function
    var drawImage = function(){
        imageObj = new Image();
        imageObj.onload = function() {
            context.drawImage(this, 0, 0, imageObj.width, imageObj.height, 0, 0, canvas.width, canvas.height);
            // Text is draw inside because there is overlaping issues if not.
            drawText();

        };
        imageObj.src = imageSrc;
    };

    // Draw text function
    var drawText = function(){
        // Recalculate for current size width font size for canvas element
        fontSize = getFontSize();
        lineHeight = getLineHeight();
        margin = getMargin();
        context.fillStyle = '#FFF';
        context.strokeStyle = '#000';
        context.textAlign = "center";
        context.textBaseline = "middle";
        context.font = "bold " + fontSize + "pt " + fontFamily;
        // Change line height regarding to font size
        if(fontSizeRatio < 1.4) {
            context.lineWidth = 1;
        } else {
            context.lineWidth = 2;
        }
        // Draw text on top and on bottom
        wrapText(context, textTop, margin, maxWidth, lineHeight, 'top');
        wrapText(context, textBottom, margin, maxWidth, lineHeight, 'bottom');

        // Draw copyrights
        context.textAlign = "left";
        context.textBaseline = "top";
        context.font = "bold " + (currentWidth  / 27.85) /3.5 + "pt " + fontFamily;
        context.fillText(copyright, 5, 5);
    };

    var wrapText = function(context, text, margin, maxWidth, lineHeight, position) {
        var words = text.split(" "),
            countWords = words.length,
            line = "";

        if(position === 'top') {
            for (var n = 0; n < countWords; n++) {
                var testLineTop = line + words[n] + " ";
                var testWidthTop = context.measureText(testLineTop).width;
                if (testWidthTop > maxWidth) {
                    context.fillText(line, currentWidth/2, margin);
                    context.strokeText(line, currentWidth/2, margin);
                    line = words[n] + " ";
                    margin += lineHeight;
                }
                else {
                    line = testLineTop;
                }
            }
            context.fillText(line, currentWidth/2, margin);
            context.strokeText(line, currentWidth/2, margin);
        }
        if(position === 'bottom') {

            var lines = [],
                linesNum = 0;

            for (var m = 0; m < countWords; m++) {
                var testLineBottom = line + words[m] + " ";
                var testWidthBottom = context.measureText(testLineBottom).width;
                if (testWidthBottom > maxWidth) {
                    lines[linesNum] = line;
                    linesNum++;

                    line = words[m] + " ";
                    margin += lineHeight * 2.2;
                }
                else {
                    line = testLineBottom;
                }
            }
            lines[linesNum] = line;
            linesNum++;

            // Print lines in reversed order
            for (var k = 0; k < linesNum; k++) {
                context.fillText(lines[k], currentWidth/2, currentWidth / canvasRatio - margin / 1.7);
                context.strokeText(lines[k], currentWidth/2, currentWidth / canvasRatio - margin / 1.7);
                margin -= lineHeight * 1.7;

            }
        }
    };

    // Add listeners to inputs with filling text
    // -------------------------------------------------------------------------------
    // Set max symbols number for inputs, attach listeners for max-symobls
    $(document).ready(function(){
        $textInputs.attr('maxlength', maxSymbols);
        $symbolMax.text(maxSymbols);
        updateSymbolsNumber('each');

        // Seek changes in each of 2 inputs and make 'little cool and funny load', and refresh after
        var inputInterval;
        $textInputs.on('input', function(){
            $canvas.css('visibility', 'hidden');
            refreshCanvas();
            // Clear precedent interval before new is set
            clearTimeout(inputInterval);
            inputInterval = setTimeout(function(){
                if(inAction) {
                    $canvas.css('visibility', 'visible');
                    inAction = false;
                }
            }, 500);
            inAction = true;
        });

        // Seek text changes and update values and numbers for this field
        $topTextInput.on('properychange keyup input paste', function(){
            var $this = $(this),
                currentValue = $this.val();
            updateSymbolsNumber('top');
            textTop = currentValue;
        });
        $bottomTextInput.on('properychange keyup input paste', function(){
            var $this = $(this),
                currentValue = $this.val();
            updateSymbolsNumber('bottom');
            textBottom = currentValue;
        });

        function updateSymbolsNumber(position){
            if(position == 'top') {
                $symbolTop.text(maxSymbols - $topTextInput.val().length);
            }
            if(position == 'bottom') {
                $symbolBottom.text(maxSymbols - $bottomTextInput.val().length);
            }
            if(position == 'each') {
                $symbolTop.text(maxSymbols - $topTextInput.val().length);
                $symbolBottom.text(maxSymbols - $bottomTextInput.val().length);
            }
        }
    });

    // Add listeners for checkboxes for font-family changes
    // -------------------------------------------------------------------------------
    var setFontFamily = function($this) {
        if($this.val() == 1) {
            fontFamily = 'georgia';
        } else {
            fontFamily = 'sans-serif';
        }
    };

    // On page load detect active element
    $(document).ready(function(){
        $fontFamilyRadio.each(function(){
            var $this = $(this);
            if($this.is(':checked')){
                setFontFamily($this);
            }
        });
    });

    // Detect checked item on click
    $fontFamilyRadio.on('change', function(){
        var $this = $(this);
        setFontFamily($this);
        refreshCanvas();
    });

    // Detect changes of font-size selector
    $fontSizeSelect.on('change', function(){
        var $this = $(this);
        fontSizeRatio = $this.val();
        refreshCanvas();
    });

    // Add listeners for selections where to write
    // -------------------------------------------------------------------------------

    // On change - erase all text from inputs
    $writeInputsRadio.on('change', function(){
        $textInputs.val('');
        textTop = '';
        textBottom = '';
        refreshCanvas();
    });

    // Submit form
    // -------------------------------------------------------------------------------
    $canvasWrapper.submit(function(e){
        e.preventDefault();

        // If selected post type 'image' and image deisgner is closed - throw error
        var submitType = $('[name=type]:checked').val();


                // When with email it's all ok - go with captcha
                if(!$('[name=captcha]').val().length) {
                    throwMessage('error', 'Необходимо заполнить поле captcha', '#send-form .form-actions');
                }
                else {
                    // Go deeper with more specific validation...
                    if((submitType == 1) && !$wrapperDesignPic.is(':visible')) {
                        throwMessage('error', 'Необходимо выбрать картинку', '#send-form .form-actions');
                    }
                    else {
                        if(submitType == 1) {
                            // It is image

                            // Refresh canvas to real size
                            currentWidth = baseWidth;
                            maxWidth = currentWidth / 1.05;
                            $canvas.attr('width', currentWidth);
                            $canvas.attr('height', Math.floor(currentWidth/canvasRatio));

                            imageObj = new Image();
                            imageObj.onload = function() {
                                context.drawImage(this, 0, 0, imageObj.width, imageObj.height, 0, 0, canvas.width, canvas.height);
                                // Text is draw inside because there is overlaping issues if not.
                                drawText();
                                imageUrl = canvas.toDataURL("image/jpeg");
                                sendAjax();
                                // And revert it to current size

                                refreshCanvas();
                            };
                            imageObj.src = imageSrc;
                        }
                        else {
                            // If submit is text, check if text is filled
                            if($('[name=text]').val().length) {
                                sendAjax();
                            }
                            else {
                                throwMessage('error', 'Необходимо ввести текст секрета', '#send-form .form-actions');
                            }

                        }
                    }
                }



    });

    // Ajax send function
    // -------------------------------------------------------------------------------
    var sendAjax = function() {
        var sendType = $('[name=type]:checked').val(),
            sendText = '',
            sendImage = '';

        // Detect post type, and fill data with what wee need
        if(sendType == 1) {
            sendImage = imageUrl;
        }
        if(sendType == 0) {
            sendText = $('[name=text]').val();
        }
        $.ajax({
            type: 'POST',
            url: '/secrets/add/',
            dataType: 'json',
            data: {
                // What we send
                // 1. email
                // 2. category (all ok if it is not 0)
                // 3. type - 0 or 1 (0 - text, 1 - image)
                // 4. text (if 'type'==1 - it will be empty)
                // 5. image (base64 decoded image)
                // 6. captcha

                email: $('[name=email]').val(),
                category: $('[name=category]').val(),
                type: sendType,
                text: sendText,
                image: sendImage,
                captcha: $('[name=captcha]').val()
            },
            success: function(data) {
                // I'm waiting from server:
                // 1. 'status' => 0 or 1 (0 - there are errors, 1 - there are no errors)
                // 2. 'message' => string (status message about successfull action, or about encountered validation errors)
                // If there are any validation or other errors from server
                if(data.status == 0) {
                    // In message - write all you need about errors
                    throwMessage('error', data.message, '#send-form .form-actions');
                }
                // If there are no errors and all goes fine
                if(data.status == 1) {
                    $('.form-content').hide();
                    $('#whisper-submit').hide();
                    throwMessage('status', data.message, '#send-form .form-actions');
                }
                // When we send successfully AJAX, empty some fields.
                if($wrapperDesignPic.is(':visible')) {
                    $wrapperDesignPic.slideUp();
                }
                if(sendType == 0) {
                    $('[name=text]').val('');
                }
                // Empty captcha item
                $('[name=captcha]').val('');
                // TODO: Заккоментированный кусок для продакшна. Меняет в капче картинку на другое любое рандомное значение
                // $('.captcha-wrapper img').attr('src', "/secrets/captcha/?rand=" + Math.floor( Math.random( 1000000 ) * 1000000 ))
                $('.captcha-wrapper img').attr('src', "http://" + location.href.split("/")[2] + "/secrets/captcha/?rand=" + Math.floor( Math.random( 1000000 ) * 1000000 ))
            },
            error: function(xhr, err) {
                throwMessage('error', xhr.status + ' ' +  xhr.statusText + '. Повторите попытку позже', '#send-form .form-actions');
            }
        });
    };
    // Messages handling
    // -------------------------------------------------------------------------------
    var throwMessage = function(type, content, target) {
        // type - error/warning/status
        // content - just text
        var messageLabel = '',
            messageLive;

        switch(type) {
            case 'error':
                messageLabel = '<b>Ошибка:</b> ';
                break;
            case 'warning':
                messageLabel = '<b>Внимание:</b> ';
                break;
            default:
                break;
        }

        var messageProto = '<div class="message message-' + type + '">' + messageLabel + content + '</div>';

        // Remove old message, if existed
        $(target).parent().find('.message').remove();
        $(target).prepend(messageProto).show();
        clearTimeout(messageLive);
        messageLive = setTimeout(function(){
            // Remove current message
            $(target).parent().find('.message').fadeOut();
        }, 5000);

    };

    // Validate Email
    // -------------------------------------------------------------------------------
    var validateEmail = function($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(!emailReg.test($email)) {
            return false;
        } else {
            return true;
        }
    }




});
