/* jshint laxbreak:true */
require([ 'modules/common-scripts', 'jquery', 'toastr' ], function(common, jquery, toastr) {

	'use strict';
	common.init();
	var $ = jquery;
	
	$('.pref-checkbox').change(function(){
		var setURL = $(this).attr('data-set-pref-url');
		setURL = setURL.substring(0, setURL.length-1);
		var value = '0';
		if($(this).prop('checked')) {
			value = '1';
		}
		setURL += value; 
		$.getJSON(setURL,{},
				function(data) {
					if(data.success) {
						toastr.success('Settings updated.','Success!');
					}
		});
	});
	
});