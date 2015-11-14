require([ 'modules/common-scripts', 'jquery', 'typeahead', 'bloodhound' ],
		function(common, jquery, typeahead, bd) {
			'use strict';
			common.init();
			var $ = jquery;
			$('#new-msg').click(function() {
				$('#new-msg-row').slideDown('fast').addClass('active');
				if ($('#new-msg-helper,#no-threads-alert').length > 0) {
					$('#new-msg-helper,#no-threads-alert').slideUp('fast');
				}
				$("#new-message-form").slideDown();
			});

			$('#new-msg-closer').click(function() {
				$('#new-msg-row').slideUp('fast');
				if ($('#new-msg-helper,#no-threads-alert').length > 0) {
					$('#new-msg-helper,#no-threads-alert').slideDown('fast');
				}
				$("#new-message-form").slideUp();
			});

			var recipients = new Bloodhound({
				datumTokenizer : Bloodhound.tokenizers.obj.whitespace('value'),
				queryTokenizer : Bloodhound.tokenizers.whitespace,
				prefetch : $('#recipient').attr('data-recipients-url')
						+ '/null',
				remote : {
					url : $('#recipient').attr('data-recipients-url')
							+ '/%QUERY',
					wildcard : '%QUERY'
				}
			});

			$('#recipient').typeahead(null, {
				name : 'recipient',
				source : recipients,
			});

			$('.existing.thread-details').on(
					'click',
					function() {
						var threadId = $(this).attr('id');
						var fetchURL = $(this).attr(
								'data-thread-fetch-url');
						var participantName = $(this).find('strong.participant').text().trim();

						$('#message-body > .row').slideUp('fast');
						$('#messages-list #messages-header h4').text(participantName);
						$('#messages-list, #messages-list #messages-header').slideDown('fast');
						$('#send-existing-thread-msg').attr('data-thread-id',threadId);
						
						$.getJSON(fetchURL, {}, function(data) {
							$('#msg-body').empty();
							for(var i =0;i<data.length;i++) {
								var row = $('<div class="row">');
								row.attr('id',data[i].id);
								var messageBody = $('<div class="col-md-offset-1 col-md-5 message">');
								messageBody.text(data[i].body);
								messageBody.addClass(data[i].sentOrRecieved);
								if(data[i].sentOrRecieved === 'sent') {
									messageBody.addClass('pull-right');
								}
								row.append(messageBody);
								$('#msg-body').append(row);
							}
						});
					});
			
			$('#send-existing-thread-msg').on('click',function(){
				if($('#existing-thread-msg').val().length){
					$('#existing-thread-msg').removeClass('has-error');
					var threadId = $(this).attr('data-thread-id');
					var message = $('#existing-thread-msg').val();
					$('#existing-thread-msg').val('');
					$.post($(this).attr('data-send-url'),{
						threadId:threadId,
						message:message,
					},function(data){
						
					});
				} else {
					$('#existing-thread-msg').addClass('has-error');
				}
			});
		});