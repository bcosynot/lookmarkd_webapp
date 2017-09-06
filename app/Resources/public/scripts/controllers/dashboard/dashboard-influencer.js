define(function(require, exports) {
	'use strict';
	var $ = require('jquery');
	require('bootstrap');
	function getFollowersCount(){
            $.getJSON($('#followerCount').attr('data-url'),{},function(data){
                if(typeof data !== undefined) {
                    if(data.followerCount>-1) {
                        $('#followerCount > div > h3').text(data.followerCount + ' followers');
                        $('#followerCount p').text('You have ' + data.followerCount + ' follower(s) on Instagram.');
                    } else {
                        $('#followerCount > div > h3').text('Followers count N/A');
                        $('#followerCount p').text('Whoops! Looks like we haven\'t been able to update this information yet. We\'ll get it to you ASAP!');
						setTimeout(getFollowersCount,30000);
                    }
                }
            });
        }

	function getMediaCount(){
            $.getJSON($('#mediaCount').attr('data-url'),{},function(data){
                if(typeof data !== undefined) {

                    if(data.mediaCount>-1) {
                        $('#mediaCount > div > h3').text(data.mediaCount + ' post(s)');
                        $('#mediaCount p').text('You have ' + data.mediaCount + ' post(s) on Instagram.');
                    } else {
                        $('#mediaCount > div > h3').text('Post count N/A');
                        $('#mediaCount p').text('Whoops! Looks like we haven\'t been able to update this information yet. We\'ll get it to you ASAP!');
						setTimeout(getFollowersCount,30000);
                    }

                    if(data.mediaCount>-1) {
                        $('#likesCount > div > h3').text(data.likesCount + ' like(s)');
                        $('#likesCount p').text('You have ' + data.likesCount + ' like(s) across ' + data.mediaCount + ' post(s) on Instagram.');
                    } else {
                        $('#likesCount > div > h3').text('Likes count N/A');
                        $('#likesCount p').text('Whoops! Looks like we haven\'t been able to update this information yet. We\'ll get it to you ASAP!');
                    }

                    if(data.mediaCount>-1) {
                        $('#commentsCount > div > h3').text(data.commentsCount + ' comment(s)');
                        $('#commentsCount p').text('You have ' + data.commentsCount + ' comments(s) across ' + data.mediaCount + ' post(s) on Instagram.');
                    } else {
                        $('#commentsCount > div > h3').text('Comments count N/A');
                        $('#commentsCount p').text('Fetching your posts from Instagram might take a while. Please check back later...');
                    }
                }
            });
        }

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
		
		getFollowersCount();
		
		getMediaCount();
	};
});