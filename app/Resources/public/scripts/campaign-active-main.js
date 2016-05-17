require(['modules/common-scripts', 'jquery', 'datatables.net-bs', 'bootstrap/modal'], function (common, $) {

    'use strict';
    common.init();

    $('#campaigns').DataTable();
});