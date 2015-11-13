define(function(require, exports) {
    'use strict';
    var $ = require('jquery');
    require('bootstrap');
    require('bootstrap/tooltip');
    
    exports.init = function init() {
    	$('.category-picture').click(function(){
    		if($(this).hasClass('selected')) {
    			$(this).removeClass('selected');
    			$('.category-picture').show('fast');
    			$('#done-button').hide('fast');
    			$('button#cancel').hide('fast');
    		} else {
    			$(this).addClass('selected');
    			$('.category-picture:not(.selected)').hide('fast');
    			$('#done-button').show('fast');
    			$('#done-button button.btn-success').attr('data-posting-category-id',$(this).attr('data-posting-category-id'));
    			$('button#cancel').show('fast');
    		}
    	});
    	$('[data-toggle=tooltip]').tooltip();
    	$('#done-button button.btn-success').click(function(){
    		var refrer = $(this).attr('data-refrer');
    		var submitURL = $(this).attr('data-submit-url');
    		var postingCategoryId = $(this).attr('data-posting-category-id');
    		$(this).button('loading');
    		$.getJSON(submitURL+'/'+postingCategoryId,{},function(data){
    			if(data.success) {
    				window.location = refrer;
    			}
    		});
    	});
    	$('button#cancel').click(function(){
    		$('.category-picture.selected').click();
    	});
    };
});