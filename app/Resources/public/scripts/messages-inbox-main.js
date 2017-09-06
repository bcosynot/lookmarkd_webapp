/* jshint laxbreak:true */
require([ 'modules/common-scripts', 'jquery', 'typeahead', 'bloodhound', 'bootstrap' ],
		function(common, jquery, typeahead, Bloodhound) {
			'use strict';
			common.init();
			var $ = jquery;
			$('#new-msg,#new-msg-row').click(function() {
				$('#threads .thread-details.active').removeClass('active');
				$('#new-msg-row').slideDown('fast').addClass('active');
				
				if ($('#new-msg-helper,#no-threads-alert').length > 0) {
					$('#new-msg-helper,#no-threads-alert').slideUp('fast');
				}
				$('#new-message-form').slideDown();
				$('#threads').attr('data-current-thread-id',-9999);
				$('#messages-list').slideUp('fast');
			});

			$('#new-msg-closer').click(function(e) {
				e.stopPropagation();
				$('#new-msg-row').slideUp('fast');
				if ($('#new-msg-helper,#no-threads-alert').length > 0) {
					$('#new-msg-helper,#no-threads-alert').slideDown('fast');
				}
				$('#new-message-form').slideUp();
			});
			
			$('#send-new-msg').click(function(){
				var recipient = $('#recipient').val();
				var message = $('#new-message-body').val();
				var $btn = $(this);
				$('#new-message-body').parents('.form-group').first().removeClass('has-error');
				$('#new-message-body').parents('.form-group').first().find('span.help-block').slideUp('fast');
				$('#recipient').parents('.form-group').first().removeClass('has-error');
				$('#recipient').parents('.form-group').first().find('span.help-block').slideUp('fast');
				if(recipient.trim().length === 0) {
					$('#recipient').parents('.form-group').first().addClass('has-error');
					$('#recipient').after('<span class="help-block">Please enter valid recipient</span>');
					$btn.button('reset');
				} else if (message.trim().length === 0) {
					$('#new-message-body').parents('.form-group').first().addClass('has-error');
					$('#new-message-body').after('<span class="help-block">Please enter a message</span>');
					$btn.button('reset');
				} else if(recipient.trim().length > 0 && message.trim().length > 0) {
					$(this).button('loading');
					var sendNewMessageURL=$(this).attr('data-send-new-msg-url');
					var validateRecipientURL = $(this).attr('data-validate-recipient-url')+'/'+recipient;
					$.getJSON(validateRecipientURL,{},function(data){
						if(data.success) {
							$.post(sendNewMessageURL,{
								recipientUserName: recipient,
								message: message,
							},null);
							location.reload();
						} else {
							$btn.button('reset');
							$('#recipient').parents('.form-group').first().addClass('has-error');
							$('#recipient').after('<span class="help-block">Please enter valid recipient</span>');
						}
					});
				}
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

			$('#existing-thread-msg').on('keypress',function(e){
				if(e.which === 13) {
					$('#send-existing-thread-msg').click();
			    }
			});
			
			function addMessageToInbox(body, sentOrRecieved, id) {
				if(null === id || (null!== id && (id.length === 0 || id === '' || $('#msg-body ul li.row#'+id).length===0))) {
					var row = $('<li class="row thread-msg">');
					row.attr('id',id);
					var messageBody = $('<div class="col-md-5 message">');
					var p = $('<p>');
					p.text(body);
					messageBody.append(p);
					messageBody.addClass(sentOrRecieved);
					if(sentOrRecieved === 'sent') {
						messageBody.addClass('pull-right col-md-pull-1');
					}
					row.append(messageBody);
					$('#msg-body ul').append(row);
				}
			}
			
			$('.existing.thread-details').on(
					'click',
					function() {
						var threadId = $(this).attr('id');
						if($('#threads').attr('data-current-thread-id') !== threadId) {
							var fetchURL = $(this).attr(
									'data-thread-fetch-url');
							var participantName = $(this).find('strong.participant').text().trim();
	
							$('#threads').attr('data-current-thread-id',threadId);
							$('#message-body > .row').slideUp('fast');
							$('#messages-list #messages-header h4')
								.text(participantName)
								.append('<div class="spinner-loader" style="font-size:5px;">');
							$('#messages-list, #messages-list #messages-header').slideDown('fast');
							$('#send-existing-thread-msg').attr('data-thread-id',threadId);
							$('#existing-thread-msg').val('');
							$('#threads .thread-details.active').removeClass('active');
							$(this).addClass('active');
							var loadingMsg = $('<li class="row mt" id="msgs-loading-helper">')
												.append('<div class="col-sm-12"><p>Loading...</p></div>');
							$('#msg-body ul')
								.empty()
								.append(loadingMsg);
							$.getJSON(fetchURL, {}, function(data) {
								$('#messages-list #messages-header h4 .spinner-loader').remove();
								$('#msgs-loading-helper').remove();
								for(var i =0;i<data.length;i++) {
									if($('#threads').attr('data-current-thread-id') === threadId) {
										addMessageToInbox(data[i].body, data[i].sentOrRecieved, data[i].id);
									}
									$('#msg-body ul').niceScroll({styler:'fb',cursorcolor:'#4ECDC4', cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});
								}
							});
						}
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
						if(data === 'success') {
							if($('#threads').attr('data-current-thread-id') === threadId) {
								addMessageToInbox(message, 'sent', '');
							}
						}
					});
				} else {
					$('#existing-thread-msg').addClass('has-error');
				}
			});
			
			function getNewMessagesForThread() {
				var threadId = $('#threads').attr('data-current-thread-id');
				if(threadId.length && threadId !== -9999) {
					var getNewMessagesURL = $('#threads').attr('data-new-messages-url')+'/'+threadId;
					$.getJSON(getNewMessagesURL, {}, function(data) {
						for(var i =0;i<data.length;i++) {
							if($('#threads').attr('data-current-thread-id') === threadId) {
								addMessageToInbox(data[i].body, data[i].sentOrRecieved, data[i].id);
							}
						}
					});
				}
			}
			
			setInterval(getNewMessagesForThread,30000);
			
			function addThreadToInbox(thread) {
				var row = $('<li class="row existing thread-details cursor-pointer">');
				row.attr('id',thread.id);
				var threadFetchUrl = $('#threads').attr('data-thread-fetch-url')+'/'+thread.id;
				row.attr('data-thread-fetch-url',threadFetchUrl);
				var participantParent = $('<div class="col-sm-8">');
				var participant = $('<strong class="participant">');
				participant.text(thread.associatedUser);
				var badge = $('<span class="badge">');
				badge.text(thread.unreadCount);
				var p = $('p');
				p.append(participant);
				p.append(badge);
				participantParent.append(p);
				row.append(participantParent);
				row.append('<div class="col-sm-offset-2 col-sm-2">');
				$('#threads ul').append(row);
			}
			
			function updateThreadsUnreadCounts() {
				var threadsInformationURL = $('#threads').attr('data-threads-information-url');
				$.getJSON(threadsInformationURL,{},function(threads){
					for(var i = 0; i<threads.length;i++) {
						var existingThreadLink = $('.existing.thread-details[id='+threads[i].id+']');
						if(existingThreadLink.length) {
							var unreadCount = threads[i].unreadCount;
							if(unreadCount > 0) {
								existingThreadLink.find('span.badge').text(unreadCount);
							}
						} else {
							addThreadToInbox(threads[i]);
						}
					}
				});
			}
			
			setInterval(updateThreadsUnreadCounts,30000);
			
			$('#new-msg-row, #new-message-form, #messages-list').hide();
			
			$(window).on('beforeunload', function() {
				if($('#new-message-body').val().length > 0 || $('#existing-thread-msg').val().length > 0 ) {
					return 'You have not sent your messages yet.';
				}
			});
		});