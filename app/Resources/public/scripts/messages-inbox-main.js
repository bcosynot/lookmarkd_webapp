require(['modules/common-scripts','jquery'],function(common, jquery) {
    'use strict';
    common.init();
    var $ = jquery;
    $('#new-msg').click(function(){
    	$('#new-msg-row')
    		.slideDown('fast')
    		.addClass('active');
    	if($('#new-msg-helper,#no-threads-alert').length > 0) {
    		$('#new-msg-helper,#no-threads-alert').slideUp('fast');
    	}
    	$("#new-message-form").slideDown();
    });
    
    $('#new-msg-closer').click(function(){
    	$('#new-msg-row').slideUp('fast');
    	if($('#new-msg-helper,#no-threads-alert').length > 0) {
    		$('#new-msg-helper,#no-threads-alert').slideDown('fast');
    	}
    	$("#new-message-form").slideUp();
    });
});