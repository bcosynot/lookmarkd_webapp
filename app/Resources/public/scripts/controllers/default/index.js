/**
 *
 * @author Ben ZÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¶rb @bezoerb https://github.com/bezoerb
 * @copyright Copyright (c) 2015 Ben ZÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¶rb
 *
 * Licensed under the MIT license.
 * http://bezoerb.mit-license.org/
 * All rights reserved.
 */
define(function(require, exports) {
    'use strict';
    // var $ = require('jquery');
    var log = require('loglevel');
    require('bootstrap');
    require('bootstrap/scrollspy');
    require('bootstrap3-ie10-viewport-bug-workaround');
    var WOW = require('wow');

    exports.init = function init() {
        log.setLevel(0);
        new WOW().init();
    };
});
