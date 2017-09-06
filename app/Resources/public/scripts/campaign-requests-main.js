require(['modules/common-scripts', 'jquery', 'bootstrap/modal'], function (common, $) {

    'use strict';
    common.init();

    $('.status-reply-button').click(function () {
        var status = $(this).data('status') ;
        var campaignParticipantId = $(this).data('campaign-participant-id');
        var url = $(this).data('url');
        var button = $(this);
        button.text('Processing...');
        button.parents('panel-footer').first().find('button').not(button).fadeOut();

        $.post(url,
                {
                    campaignParticipantId: campaignParticipantId,
                    status: status
                },
                function(){
                    button.text('Done!');
                    button.prop('disabled', true);
                });
    });

    $('button.attach-link').click(function(){
        var campaignParticipantId = $(this).data('campaign-participant-id');
        var link = $('#link-'+campaignParticipantId).val();
        var url = $(this).data('url');
        var button = $(this);
        button.text('Processing...');

        $.post(url,
            {
                campaignParticipantId: campaignParticipantId,
                link: link
            },
            function(){
                button.text('Done!');
                button.prop('disabled', true);
            });
    });

});