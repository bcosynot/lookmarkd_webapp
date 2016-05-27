require(['modules/common-scripts', 'jquery', 'moment', 'bootstrap/tab', 'bootstrap/transition',
            'bootstrap-daterangepicker', 'textarea-autosize', 'datatables.net-bs', 'datatables.net-select',
            'datatables.net-responsive', 'datatables.net-responsive-bs', 'bootstrap/tooltip'], function (common, $, moment) {

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

    function showUpdatedTable() {
        $('#influencers-updating').hide();
        $('#influencer-list').slideDown();
        var selectedInfluencers = getSelectedInfluencers();
        table.rows().every(function () {
            var rowId = parseInt(this.id());
            if (selectedInfluencers.indexOf(rowId) !== -1) {
                this.select();
            }
        });
    }

    var table = $('#influencer-list table').DataTable({
        'ajax': {
            'url': $('#posting_category_filter').data('url'),
                        'data': function(d) {
                            $('#influencer-list').slideUp();
                            $('#influencers-updating').show();
                            d.categoryId =  $('#posting_category_filter').val();
                            d.followerCount = $('#follower_count_filter').val();
                        }
                    },
                    'columns': [
                        {
                            className: 'select-checkbox',
                            name: 'checkbox',
                            defaultContent: '',
                            orderable: false
                        },
                        {
                            'name':'username',
                            'data':'username',
                            'render': function ( data, type) {
                                if(type==='display') {
                                    return '<a href="https://instagram.com/' + data + '" target="_blank">'+data+'</a>';
                                } else {
                                    return data;
                                }
                            }
                        },
                        {
                            'name': 'category',
                            'data': 'category'
                        },
                        {
                            'name':'followerCount',
                            'data':'followerCount'
                        },
                        {
                            'name':'mediaCount',
                            'data':'mediaCount'
                        }
                    ],
                    select: {
                        style:    'multi',
                        selector: 'td'
                    },
                    'rowId': 'userId',
                    'initComplete': function() {
                        showUpdatedTable();
                    },
                    'responsive': true,
                    'autoWidth': false,
                    'order': [[ 3, 'desc' ], [1, 'asc']]
    });

    table
        .on( 'select', function ( e, dt, type, indexes ) {
            selectInfluencer(table.rows( indexes ).data().toArray()[0].userId);
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            deselectInfluencer(table.rows( indexes ).data().toArray()[0].userId);
        } );

    function reloadTable() {
        table.clear();
        table.ajax.reload(showUpdatedTable, true);
    }

    $('#follower_count_filter').change(function () {
        reloadTable();
    });

    $('#posting_category_filter').change(function () {
        reloadTable();
    });

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

    function showTooltipOnDraftMessageButton() {
        $('#select-influencers-then-draft-message')
            .attr('title', 'Select at least one influencer to continue.').tooltip();
    }

    showTooltipOnDraftMessageButton();

    function updateSelectedCount() {
        var numberSelected = getSelectedInfluencers().length;
        $('#number-selected').text(numberSelected);
        var dontAllowNextStep = (numberSelected === 0);
        $('#select-influencers-then-draft-message button').prop('disabled', dontAllowNextStep);
        if(dontAllowNextStep) {
            showTooltipOnDraftMessageButton();
        } else {
            $('#select-influencers-then-draft-message').tooltip('destroy');
        }
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

        var campaignName =  $('#campaign-name').val();
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