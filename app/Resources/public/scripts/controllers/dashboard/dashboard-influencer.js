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
	};
});