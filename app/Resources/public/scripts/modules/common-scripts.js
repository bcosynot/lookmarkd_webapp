define(function(require,exports) {
    'use strict';
    var $ = require('jquery');
    require('jquery.scrollTo');
    require('jquery.nicescroll');
    /*---LEFT BAR ACCORDION----*/
    exports.init = function init() {

	//sidebar dropdown menu auto scrolling

	$('#sidebar .sub-menu > a').click(function () {
	        var o = ($(this).offset());
	        var diff = 250 - o.top;
	        if(diff>0) {
	            $('#sidebar').scrollTo('-='+Math.abs(diff),500);
	        } else {
	            $('#sidebar').scrollTo('+='+Math.abs(diff),500);
	        }
	    });



      // sidebar toggle

	        function responsiveView() {
	            var wSize = $(window).width();
	            if (wSize <= 768) {
	                $('#container').addClass('sidebar-close');
	                $('#sidebar > ul').hide();
	            }

	            if (wSize > 768) {
	                $('#container').removeClass('sidebar-close');
	                $('#sidebar > ul').show();
	            }
	        }
	        $(window).on('load', responsiveView);
	        $(window).on('resize', responsiveView);

	    $('#nav-toggle').click(function () {
	        if ($('#sidebar > ul').is(':visible') === true) {
	            $('#main-content').animate({
	                'margin-left': '0px'
	            });
	            $('#sidebar').animate({
	                'margin-left': '-210px'
	            });
	            $('#sidebar > ul').hide();
	            $('#container').addClass('sidebar-closed');
	        } else {
	            $('#main-content').animate({
	                'margin-left': '210px'
	            });
	            $('#sidebar > ul').show();
	            $('#sidebar').animate({
	                'margin-left': '0'
	            });
	            $('#container').removeClass('sidebar-closed');
	        }
	    });

	// custom scrollbar
	    $('#sidebar').niceScroll({styler:'fb',cursorcolor:'#4ECDC4', cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});

	    $('html').niceScroll({styler:'fb',cursorcolor:'#4ECDC4', cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});
	};
});