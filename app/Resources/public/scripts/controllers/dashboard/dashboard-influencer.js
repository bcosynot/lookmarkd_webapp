define(function(require, exports) {
	'use strict';
	var $ = require('jquery');
	require('bootstrap');
	exports.init = function init() {
		$('#saveBloggerName')
				.click(
						function() {
							var bloggerName = $('#bloggerName').val();
							$(this).button('loading');
							if (bloggerName === 'undefined' || (bloggerName !== 'undefined' && (!bloggerName.length || bloggerName === ''))) {
								$('#bloggerName').addClass('has-error');
							} else {
								$('#bloggerName').removeClass('has-error');
								var saveURL = $(this).attr('data-url');
								var welcomeMsgURL = $(this).attr('data-welcome-msg-url');
								$.post(saveURL,{value:bloggerName},
										function(data){
											if(data.success) {
												$.getJSON(welcomeMsgURL,{},function(){
													location.reload();
												});
											}
								});
							}
						});
		
		$.getJSON($('#followerCount').attr('data-url'),{},function(data){
			if(typeof data !== undefined) {
				$('#followerCount > div > h3').text(data.followerCount+' followers');
				$('#followerCount p').text('You have '+data.followerCount+' follower(s) on Instagram.');
			}
		});
		
		$.getJSON($('#mediaCount').attr('data-url'),{},function(data){
			if(typeof data !== undefined) {
				$('#mediaCount > div > h3').text(data.mediaCount+' post(s)');
				$('#mediaCount p').text('You have '+data.mediaCount+' post(s) on Instagram.');
				
				$('#likesCount > div > h3').text(data.likesCount+' like(s)');
				$('#likesCount p').text('You have '+data.likesCount+' like(s) across '+data.mediaCount+' post(s) on Instagram.');
				
				$('#commentsCount > div > h3').text(data.commentsCount+' comment(s)');
				$('#commentsCount p').text('You have '+data.commentsCount+' comments(s) across '+data.mediaCount+' post(s) on Instagram.');
			}
		});
	};
});