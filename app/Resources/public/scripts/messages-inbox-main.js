require(['modules/common-scripts','jquery','typeahead','bloodhound'],function(common, jquery,typeahead,bd) {
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
    
    var recipients = new Bloodhound({
    	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    	  queryTokenizer: Bloodhound.tokenizers.whitespace,
    	  prefetch: $('#recipient').attr('data-recipients-url')+'/null',
    	  remote: {
    	    url: $('#recipient').attr('data-recipients-url')+'/%QUERY',
    	    wildcard: '%QUERY'
    	  }
    	});
    
    $('#recipient').typeahead(null,{
    	name:'recipient',
    	source: recipients,
    });
});