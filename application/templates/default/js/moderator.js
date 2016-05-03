/*
 * JS related to moderator approve/decline functions
 */

$(function () {

    // Add handlers for approve & decline buttons
    // -------------------------------------------------------------------------------------
    $(document).ready(function() {

        // Handler for approve button
        $('.post-approve').on('click', function(e){
            $(this).colorbox({
                onComplete: function(){
                    // Init datetimepicker
                    $('#datetimepicker1' ).datetimepicker({
                            language: 'ru'
                    });
                    // Init selectpicker
                    $('.cboxInner-content select').chosen({disable_search_threshold: 10, width: '100%'});
                    // And checkboxes
                    $('.cboxInner-content input:checkbox').uniform();

                    // Call resize after all this manipulations
                    $.fn.colorbox.resize()
                }
            });
            // On opened colorbox

        });

        // Handler for decline button
        $('.post-decline').on('click', function(e){
            var $this = $(this),
                // Store ID of item what we need to decline in HREF. Or change anything for your needs
                target = $this.attr('href');

            e.preventDefault();
            // Send via ajax something, on success remove element from DOM
            $.ajax({
                type: "POST",
                url: "some_url",
                dataType: "json",
                data: { "remove": target },
                success: function(){
                    // Just remove element
                    $this.closest('.post').fadeOut();
                },
                error: function(xhr,err){
                    // If error - create error message before single post.
                    $this.closest('.post').before('<div class="message post-message message-error"><b>Ошибка:</b>' + xhr.responseText + '</div>');
                }
            });
        });

        // Attach handler for closing colorbox
        $(document).on('click', '.btn-cbox-close', function(e){
            e.preventDefault();
            $.colorbox.close();
        })

    });


});

