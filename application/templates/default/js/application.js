/*
 * Main application JS file. Anything is initialized and created here
 */

$(function () {

    // Init Chosen selects & Uniform checkboxes
    // -------------------------------------------------------------------------------------
    $(document).ready(function() {
        $("select:not(.with-search)").chosen({disable_search_threshold: 10, width: '100%'});
        $(".with-search").chosen({width: '100%', no_results_text: "Нет результатов"});

        $("input:checkbox").uniform();
    });

    // Radio-buttons that shows\hides anything what is set by data-target=""  placed on label
    // It's used for radio buttons with same name.
    // User on selecting picture or text post.
    // -------------------------------------------------------------------------------------
    var $btnRadioToggle = $('.btn-radio-toggle');

    // Hide anything that is not checked when page is loaded
    $($btnRadioToggle.get().reverse()).each(function(){
        var $this = $(this),
            $target = $this.data('target'),
            $for = $this.attr('for');
        if($('#' + $for).is(':checked')) {
            $($target).show();
            $this.addClass('active');
        } else {
            $($target).hide();
        }
    });
    // Handler for clicking
    $btnRadioToggle.on('click', function(e) {
        var $this = $(this);
        var $target;
        // Prevent default action if is not label
        if($this.prop("tagName").toUpperCase() != 'LABEL') {
            e.preventDefault();
        }
        // Get collection of input (radio or checkboxs) that are related to the clicked input (label)
        var $inputFromLabel = $('input[name="'+ $('#' + $this.attr('for')).attr('name') + '"]');
        // Remove from all labels 'active' state and place it only on one that was clicked recently
        $inputFromLabel.each(function(){
            var $thisInner = $(this);
            var $targetId = $thisInner.attr('id');
            // Remove active state and take target from it
            $target = $('label[for="'+ $targetId +'"]').removeClass('active').data('target');
            // Using target hide the related fieldset
            if(!($this.data('target') == $target)) {
                $($target).slideUp();
            }
        });
        $($this.data('target')).slideDown();
        // Add active class to clicked element
        $this.addClass('active');
    });

    // Collapsible blocks (Make hidden when user click on close button)
    // -------------------------------------------------------------------------------------
    var $collapsibleBlock = $('.collapsible-block');

    $collapsibleBlock.on('click', '.close-btn', function(e){
        var $this = $(this);
        e.preventDefault();
        $this.closest('.collapsible-block').slideUp();
    });


    // Show tags menu
    // -------------------------------------------------------------------------------------
    var $tagsBtn = $('#menu-tags-btn'),
        $tagsMenu = $('#menu-tags'),
        $countryBtn = $('#select-country-btn'),
        $mask = $('#mask'),
        tagsHeight = $tagsMenu.height(),
        tagsVisible = false,
        countryVisible = false,
        countryLoaded = false,
        $mapWrapper = $('#map-wrapper-outside'); // Here will be loaded our map

    // Calculate position for tags menu
    $tagsMenu.css('margin-top', -(tagsHeight/2 + 1));

    $tagsBtn.on('click', function(e){
        e.preventDefault();
        if(countryVisible) {
            countryToggle();
        }
        tagsToggle();
    });

    $countryBtn.on('click', function(e){
        e.preventDefault();
        if(tagsVisible) {
            tagsToggle();
        }
        countryToggle();
    });

    // Background mask toggle (show/hide)
    // -------------------------------------------------------------------------------------
    var maskToggle = function(){
        $mask.fadeToggle(200);
        // Dirty hack for repainting, but I'll avoid to use it...
        //$('body').css('display', 'inline').css('display', 'block');
    };

    // Tags menu toggle
    // -------------------------------------------------------------------------------------
    var tagsToggle = function(){
        maskToggle();
        $tagsBtn.toggleClass('active');
        $tagsMenu.fadeToggle(400);
        tagsVisible = (tagsVisible) ? false : true;
    };

    // Country menu toggle
    // -------------------------------------------------------------------------------------
    var countryToggle = function(){
        maskToggle();
        $countryBtn.toggleClass('active');

        if(countryVisible) {
            $mapWrapper.fadeOut(400);
            countryVisible = false;
        }
        else {
            // Load content in wrapper via ajax
            if(!countryLoaded){
                $mapWrapper.load($countryBtn.attr('href'), function(){
                    // Init chosen for inner select
                    $('#map-wrapper').find('select').chosen({width: '100%', no_results_text: "Нет результатов"});
                    // On complete - show wrapper
                    $mapWrapper.fadeIn(400);
                });
                countryLoaded = true;
            }
            else {
                $mapWrapper.fadeIn(400);
            }
            countryVisible = true;
        }
    };

    // Close anything when user clicks on mask
    // -------------------------------------------------------------------------------------
    $mask.on('click', function(){
        // Test if tags or map are visible, and hide them
        if(tagsVisible) {
            tagsToggle();
        }
        if(countryVisible) {
            countryToggle();
        }
    });

    // Mobile navbar toggle
    // -------------------------------------------------------------------------------------
    var $mainMenu = $('#main-menu'),
        $sectionHeader = $('#section-header');
    $('.navbar-toggle').on('click', function(){
        // Set max-height to collapsing menu for small phones (scroll will appear)
        $mainMenu.css('max-height', $(window).height() - $sectionHeader.height());
        // If countries or tags wrapper is opened - close it
        if(tagsVisible) {
            tagsToggle();
        }
        if(countryVisible) {
            countryToggle();
        }
    });

    // iOS fix for fixed header (when keyboard is opened, header became like position
    // absolute in middle of page)
    // -------------------------------------------------------------------------------------
    if (Modernizr.touch) {
        var $body = jQuery('body');
        // Bind touch events on appearing keyboard
        $(document)
            .on('focus', 'input, textarea', function(e) {
                $body.addClass('fix-fixed');
            })
            .on('blur', 'input, textarea', function(e) {
                $body.removeClass('fix-fixed');
            });
    }


});

