require(['modules/common-scripts', 'jquery', 'datatables.net-bs', 'bootstrap/modal',
            'datatables.net-responsive', 'datatables.net-responsive-bs'], function (common, $) {

    'use strict';
    common.init();

    $('#campaigns').DataTable({
        'responsive':true
    });
});