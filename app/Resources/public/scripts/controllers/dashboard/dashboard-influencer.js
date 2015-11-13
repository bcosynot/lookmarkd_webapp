define(function(require, exports) {
	'use strict';
	var $ = require('jquery');

	exports.init = function init() {
		$('#saveBloggerName')
				.click(
						function() {
							var bloggerName = $('#bloggerName').val();
							if (bloggerName === 'undefined' || (bloggerName !== 'undefined' && (!bloggerName.length || bloggerName === ''))) {
								$('#bloggerName').addClass('has-error');
							} else {
								$('#bloggerName').removeClass('has-error');
								var saveURL = $(this).attr('data-url');
								$.post(saveURL,{value:bloggerName},
										function(data){
											if(data.success) {
												location.reload();
											}
								});
							}
						});
	};
});