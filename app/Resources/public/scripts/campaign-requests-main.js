require(['modules/common-scripts', 'jquery'], function (common, $) {

    'use strict';
    common.init();

    $('.status-reply-button').click(function () {
        var status = $(this).data('status') ;
        var campaignParticipantId = $(this).data('campaign-participant-id');
        var url = $(this).data('url');

        $.post(url,
                {
                    campaignParticipantId: campaignParticipantId,
                    status: status
                },
                function(data){
                    $('.row[data-campaign-participant-id='+data.campaignParticipantId+']').slideUp();
                });
    });

});