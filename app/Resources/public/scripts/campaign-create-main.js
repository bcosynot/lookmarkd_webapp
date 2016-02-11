require([ 'modules/common-scripts', 'jquery', 'bootstrap/tab','bootstrap/transition','bootstrap-daterangepicker','textarea-autosize'], function(common, jquery) {

    'use strict';
    common.init();
    var $ = jquery;

    $( '#schedule-input' ).daterangepicker();

    $('.next-button').click(function (e) {
        e.preventDefault();

        $('.nav-tabs li.active').removeClass('active');
        $('.nav-tabs li a[href='+$(this).attr('href')+']').parents('li').first()
            .addClass('active');

    });

    var textMax = 1200;
    $('#brief-description').keyup(function() {
        var textLength = $(this).val().length;
        var textRemaining = textMax - textLength;

        $('#char-counter').html(textRemaining + ' remaining');
    }).textareaAutoSize();

    $('button.selection').click(function(){
        if(!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).find('span')
                    .addClass('ion-checkmark-circled')
                    .removeClass('ion-checkmark');
        } else {
            $(this).removeClass('active');
            $(this).find('span')
                    .removeClass('ion-checkmark-circled')
                    .addClass('ion-checkmark');
        }
    });

    $('a[data-toggle="tab"][href="#message"]').on('shown.bs.tab', function(){
        // TODO: Logic for creating message based on provided fields
    });

});