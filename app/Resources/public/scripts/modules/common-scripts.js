define(function(require,exports) {
    'use strict';
    var $ = require('jquery');
    require('jquery.scrollTo');
    require('jquery.nicescroll');
    require('bootstrap/tooltip');
	require('dcjqaccordion');
    /*---LEFT BAR ACCORDION----*/
    exports.init = function init() {

		$('#nav-accordion').dcAccordion({
			eventType: 'click',
			autoClose: true,
			saveState: true,
			disableLink: true,
			speed: 'slow',
			showCount: false,
			autoExpand: true,
			classExpand: 'dcjq-current-parent'
		});

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
	    
	 // ADD SLIDEDOWN ANIMATION TO DROPDOWN //
	    $('.dropdown').on('show.bs.dropdown', '#user-settings', function(e){
	    	e.preventDefault();
	    });

	    // ADD SLIDEUP ANIMATION TO DROPDOWN //
	    $('.dropdown').on('hide.bs.dropdown', function(e){
	    	e.preventDefault();
	     // $(this).find('.dropdown-menu').first().slideUp('slow');
	    });
	    
	    /**
	     * Hacky bug fix for bootstrap dropdown not working. 
	     * TODO: Figure out why its not working
	     */
	    $('#user-settings').click(function(e) {
	    	e.preventDefault();
	    	var parentLi = $(this).parents('li.dropdown').first();
	    	if($(parentLi).hasClass('open')) {
	    		$(parentLi).find('.dropdown-menu').first().slideUp('fast');
	    		$(parentLi).removeClass('open');
	    	} else {
	    		$(parentLi).find('.dropdown-menu').first().slideDown('fast');
	    		$(parentLi).addClass('open');
	    	}
	    });
	    
	    $('[data-toggle="tooltip"]').tooltip();

	    function getTotalUnreadCount() {
	    	var unreadCountURL = $('#total-unread-messages-count').data('unread-messages-count-url');
	    	$.getJSON(unreadCountURL, {}, function(data){
	    		if(data.success && data.unreadCount > 0) {
	    			$('#total-unread-messages-count').text(data.unreadCount);
	    		}
	    	});
	    }
	    
	    getTotalUnreadCount();
	    setInterval(getTotalUnreadCount, 30000);

		function getNewCampaignRequests() {
			if($('#total-new-campaign-requests-count').length) {
				var url = $('#total-new-campaign-requests-count').data('url');
				$.getJSON(url, {}, function (data) {
					if (data.requestsCount > 0) {
						$('#total-new-campaign-requests-count').text(data.requestsCount);
					}
				});
			}
		}

		getNewCampaignRequests();
		setInterval(getNewCampaignRequests, 30000);
	    
	};
});