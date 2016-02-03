require([ 'modules/common-scripts', 'jquery', 'bootstrap-datetimepicker','bootstrap/tab','bootstrap/transition' ], function(common, jquery) {

    'use strict';
    common.init();
    var $ = jquery;

    $( '#from' ).datetimepicker({
        defaultDate: '+1w',
        changeMonth: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( '#to' ).datepicker( 'option', 'minDate', selectedDate );
        }
    });
    $( '#to' ).datetimepicker({
        defaultDate: '+1w',
        changeMonth: true,
        numberOfMonths: 3,
        onClose: function( selectedDate ) {
            $( '#from' ).datepicker( 'option', 'maxDate', selectedDate );
        }
    });

    $('.next-button').click(function (e) {
        e.preventDefault();

        $($(this).attr('href')).addClass('in').addClass('active');

        $(this).parents('.tab-pane').first()
                                        .removeClass('in')
                                        .removeClass('active')
                                        .addClass('out');

    });

});