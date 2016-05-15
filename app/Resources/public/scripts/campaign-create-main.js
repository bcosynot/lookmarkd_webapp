require(['modules/common-scripts', 'jquery', 'moment', 'bootstrap/tab', 'bootstrap/transition',
            'bootstrap-daterangepicker', 'textarea-autosize' ], function (common, $, moment) {

    'use strict';
    common.init();

    $('#schedule-input').daterangepicker();

    $('.next-button').click(function (e) {
        e.preventDefault();

        $('.nav-tabs li.active').removeClass('active');
        $('.nav-tabs li a[href=' + $(this).attr('href') + ']').parents('li').first()
            .addClass('active');

    });

    var textMax = 1200;
    $('#brief-description').keyup(function () {
        var textLength = $(this).val().length;
        var textRemaining = textMax - textLength;

        $('#char-counter').html(textRemaining + ' remaining');
    }).textareaAutoSize();

    $('a[data-toggle="tab"][href="#message"]').on('shown.bs.tab', function () {
        // TODO: Logic for creating message based on provided fields
    });

    $('#follower_count_filter').change(function () {
        var url = $(this).data('url');
        var minFollowerCount = $(this).val();
        $('#influencer-list').slideUp();
        $('#influencers-updating').show();
        $.post(url,
            {
                categoryId: $('#posting_category_filter').val(),
                followerCount: minFollowerCount
            }, function (data) {
                updateFilteredInfluencersList(data);
            });
    });

    $('#posting_category_filter').change(function () {
        var url = $(this).data('url');
        var categoryId = $(this).val();
        $('#influencer-list').slideUp();
        $('#influencers-updating').show();
        $.getJSON(url,
            {
                categoryId: categoryId,
                followerCount: $('#follower_count_filter').val()
            }, function (data) {
                updateFilteredInfluencersList(data);
            });
    });

    function addToFilterResults(influencer) {
        var parentBoxElement = $('<div class="col-md-3">');
        var influencerBox = $('<div class="panel panel-default influencer-box">');
        var panelBody = $('<div class="panel-body">');
        panelBody.css({
            'background': 'linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)),url("' + influencer.profilePicture + '") no-repeat',
            'background-size': 'cover'
        });
        panelBody.appendTo(influencerBox);
        var panelTitle = $('<h4 class="panel-title white">');
        var linkedUserName = $('<a href="https://instagram.com/' + influencer.username + '">');
        linkedUserName.text('@' + influencer.username);
        linkedUserName.appendTo(panelTitle);
        panelTitle.appendTo(panelBody);
        var followerCountElement = $('<div class="row mt"><div class="col-md-12"><p class="white"><span class="ion-eye white"></span>&nbsp;&nbsp;' + influencer.followerCount + '</p></div>');
        followerCountElement.appendTo(panelBody);
        var buttonToAdd = $('<button class="btn btn-block btn-primary selection" data-user-id="'+influencer.userId+'"><span class="ion-checkmark"></span></button></div></div></div>');
        buttonToAdd.appendTo(panelBody);
        influencerBox.appendTo(parentBoxElement);
        parentBoxElement.appendTo('#influencer-list');
    }

    function showTooltipForNoInfluencers(data) {
        if (data.length === 0) {
            $('#no-influencers-found').show();
        } else {
            $('#no-influencers-found').hide();
        }
    }

    function markSelectedInfluencers() {
        var selectedInfluencers = getSelectedInfluencers();
        for (var j = 0; j < selectedInfluencers.length; j++) {
            selectInfluencer(selectedInfluencers[j]);
        }
    }

    function updateFilteredInfluencersList(data) {
        $('#influencer-list').slideUp();
        $('#influencers-updating').show();
        $('#influencer-list *:not(#no-influencers-found)').remove();
        for (var i = 0; i<data.length; i++) {
            var influencer = data[i];
            addToFilterResults(influencer);
        }
        showTooltipForNoInfluencers(data);
        markSelectedInfluencers();
        showInfluencerList();
    }

    function showInfluencerList() {
        if ($.active > 0) {
            window.setTimeout(showInfluencerList, 1000);
        } else {
            $('#influencers-updating').hide();
            $('#influencer-list').slideDown();
        }
    }

    function convertAllToInt(selectedInfluencers) {
        for (var i = 0; i < selectedInfluencers.length; i++) {
            selectedInfluencers[i] = parseInt(selectedInfluencers[i]);
        }
    }

    function getSelectedInfluencers() {
        var selectedInfluencers = $('#number-selected').data('selected-user-ids');
        if (selectedInfluencers === undefined ||
            (selectedInfluencers !== undefined && selectedInfluencers.trim().length === 0)) {
            selectedInfluencers = [];
        } else if (selectedInfluencers.indexOf(',') === -1) {
            selectedInfluencers = [parseInt(selectedInfluencers)];
        } else {
            selectedInfluencers = selectedInfluencers.split(',');
            convertAllToInt(selectedInfluencers);
        }
        return selectedInfluencers;
    }

    function updateSelectedInfluencers(selectedInfluencers) {
        $('#number-selected').data('selected-user-ids', selectedInfluencers.join(','));
    }

    function markButtonAsSelected(userId) {
        var button = $('button.selection[data-user-id=' + userId + ']');
        $(button).addClass('active');
        $(button).find('span')
            .addClass('ion-checkmark-circled')
            .removeClass('ion-checkmark');
    }

    function addUserIdToSelectedList(userId) {
        var selectedInfluencers = getSelectedInfluencers();
        var index = selectedInfluencers.indexOf(userId);
        if (index === -1) {
            selectedInfluencers.push(userId);
            updateSelectedInfluencers(selectedInfluencers);
        }
    }

    function selectInfluencer(userId) {
        markButtonAsSelected(userId);
        addUserIdToSelectedList(userId);
        updateSelectedCount();
    }

    function markButtonAsUnselected(userId) {
        var button = $('button.selection[data-user-id=' + userId + ']');
        $(button).removeClass('active');
        $(button).find('span')
            .removeClass('ion-checkmark-circled')
            .addClass('ion-checkmark');
    }

    function removeUserIdFromSelectedList(userId) {
        var selectedInfluencers = getSelectedInfluencers();
        var index = selectedInfluencers.indexOf(userId);
        if (index !== -1) {
            selectedInfluencers.splice(index, 1);
            updateSelectedInfluencers(selectedInfluencers);
        }
    }

    function updateSelectedCount() {
        var numberSelected = getSelectedInfluencers().length;
        $('#number-selected').text(numberSelected);
    }

    function deselectInfluencer(userId) {
        markButtonAsUnselected(userId);
        removeUserIdFromSelectedList(userId);
        updateSelectedCount();
    }

    $('#influencer-list').on('click', 'button.selection', function(){
        var userId = $(this).data('user-id');
        userId = parseInt(userId);
        if (!$(this).hasClass('active')) {
            selectInfluencer(userId);
        } else {
            deselectInfluencer(userId);
        }
    });

    $('#mailSent').click(function(){
        
        $('#message > div > div > div > div.panel-heading').slideUp();
        $('#message > div > div > div > div.panel-body').slideUp();
        $('#message > div > div > div > div.panel-footer > div > a.btn.btn-link.pull-right').fadeOut();
        $('.ladda-label', this).text('Creating campaign...');
        $(this).prop('disabled',true);

        var campaignName =  $('#campaign-name').text();
        var startDate = moment($('#schedule-input').data('daterangepicker').startDate._d).format('YYYY-MM-DD');
        var endDate = moment($('#schedule-input').data('daterangepicker').endDate._d).format('YYYY-MM-DD');
        var brief = $('#brief-description').val();
        var numPosts = $('#posts-count').val();
        var handles = $('#handles').val();
        var hashtags = $('#hashtags').val();
        var cashReward = $('#cash-amount').val();
        var kindReward = $('#kind-details').val();
        var selectedInfluencers = getSelectedInfluencers();
        var msgSubject = $('#subject').val();
        var msgBody = $('#message-body').val();

        var url = $(this).data('url');
        $.post(url,
                {
                    campaignName: campaignName,
                    startDate: startDate,
                    endDate: endDate,
                    brief: brief,
                    numPosts: numPosts,
                    handles: handles,
                    hashtags: hashtags,
                    cashReward: cashReward,
                    kindReward: kindReward,
                    selectedInfluencers: selectedInfluencers,
                    msgSubject: msgSubject,
                    msgBody: msgBody
                },
                function () {
                    $('#myTab').fadeOut();
                    $('.nav-tabs a[href=#done]').tab('show');
                });
    });

});