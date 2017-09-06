## Installation

Install with [Bower](http://bower.io): `bower install dcjqaccordion`.

## Overview

The plugin takes standard html nested lists and turns them into vertical accordion menus.

Some features include:

 - Ability to handle any number of levels
 - Select either “click” or “hover” event
 - State saving using cookies
 - Set sub-menus to auto-expand on page load based on CSS class
 - Allow all sub-menus to be expanded or auto-close open sub-menus
 - Disable parent links
 - Add count of number of child links
 - Uses the jquery cookie plugin by Klaus Hartl for saving the menu state and the hoverIntent plugin by Brian Cherne if the “hover” event is selected.

## Quick Start

### 1. Create a HTML Nested List

```
<ul id="accordion" class="menu">
    <li><a href="#">Home</a></li>
    <li>
        <a href="#">Products</a>
        <ul>
            <li>
                <a href="#">Mobile Phones &#038; Accessories</a>
                <ul>
                    <li><a href="#">Product 1</a></li>
                    <li><a href="#">Product 2</a></li>
                    <li><a href="#">Product 3</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Desktop</a>
                <ul>
                    <li><a href="#">Product 4</a></li>
                    <li><a href="#">Product 5</a></li>
                    <li><a href="#">Product 6</a></li>
                    <li><a href="#">Product 7</a></li>
                    <li><a href="#">Product 8</a></li>
                    <li><a href="#">Product 9</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Laptop</a>
                <ul>
                    <li><a href="#">Product 10</a></li>
                    <li><a href="#">Product 11</a></li>
                    <li><a href="#">Product 12</a></li>
                    <li><a href="#">Product 13</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Accessories</a>
                <ul>
                    <li><a href="#">Product 14</a></li>
                    <li><a href="#">Product 15</a></li>
                </ul>
            </li>
            <li><a href="#">Software</a>
                <ul>
                    <li><a href="#">Product 16</a></li>
                    <li><a href="#">Product 17</a></li>
                    <li><a href="#">Product 18</a></li>
                    <li><a href="#">Product 19</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#">Sale</a>
        <ul>
            <li><a href="#">Special Offers</a>
        <ul>
            <li><a href="#">Offer 1</a></li>
            <li><a href="#">Offer 2</a></li>
            <li><a href="#">Offer 3</a></li>
        </ul>
    </li>
    <li>
        <a href="#">Reduced Price</a>
        <ul>
            <li><a href="#">Offer 4</a></li>
            <li><a href="#">Offer 5</a></li>
            <li><a href="#">Offer 6</a></li>
            <li><a href="#">Offer 7</a></li>
        </ul>
    </li>
    <li>
        <a href="#">Clearance Items</a>
        <ul>
            <li><a href="#">Offer 9</a></li>
        </ul>
    </li>
    <li class="menu-item-129">
        <a href="#">Ex-Stock</a>
        <ul>
            <li><a href="#">Offer 10</a></li>
            <li><a href="#">Offer 11</a></li>
            <li><a href="#">Offer 12</a></li>
            <li><a href="#">Offer 13</a></li>
        </ul>
    </li>
    <li>
        <a href="#">About Us</a>
        <ul>
            <li><a href="#">About Page 1</a></li>
            <li><a href="#">About Page 2</a></li>
        </ul>
    </li>
    <li>
        <a href="#">Services</a>
        <ul>
            <li>
                <a href="#">Service 1</a>
                <ul>
                    <li><a href="#">Service Detail A</a></li>
                    <li><a href="#">Service Detail B</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Service 2</a>
                <ul>
                    <li><a href="#">Service Detail C</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Service 3</a>
                <ul>
                    <li><a href="#">Service Detail D</a></li>
                    <li><a href="#">Service Detail E</a></li>
                    <li><a href="#">Service Detail F</a></li>
                </ul>
            </li>
            <li><a href="#">Service 4</a></li>
        </ul>
    </li>
    <li><a href="#">Contact us</a></li>
</ul>
```

### 2. Include The jQuery Vertical Accordion Menu Plugin

Add the jQuery plugin to the head of your document – also add the cookie plugin and hoverIntent plugin if required:

```
<script type='text/javascript' src='js/jquery.cookie.js'></script>
<script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='js/jquery.dcjqaccordion.2.7.min.js'></script>
```

### 3. Vertical Accordion CSS

The plugin doesn’t require any essential CSS styling in order to create the vertical accordion effect and will create the menu from any standard list. One benefit of this is that in the event that the users browser does not have javascript enabled the menu will still be available.

See the jQuery vertical accordion menu examples page for samples skins.

### 4. Initialise The Vertical Accordion Menu

The menu can be quickly and easily initialised using the default options by adding the following code to the head of your document:

```
jQuery(document).ready(function($) {
    jQuery('#accordion').dcAccordion();
});
```

For more information on changing the menu settings refer to the Options page.

## Options

### Plugin Defaults

The jQuery vertical accordion menu plugin defaults are:

```
$.fn.dcAccordion = function(options) {
    //set default options
    var defaults = {
        classParent : 'dcjq-parent',         //Class of parent menu item
        classActive : 'active',              // Class of active parent link
        classArrow  : 'dcjq-icon',           // Class of span tag for parent arrows
        classCount  : 'dcjq-count',          // Class of span tag containing count (if addCount: true)
        classExpand : 'dcjq-current-parent', // Class of parent li tag for auto-expand option
        eventType   : 'click',               // Event for activating menu - options are "click" or "hover"
        hoverDelay  : 300,                   // Hover delay for hoverIntent plugin
        menuClose   : true,                  // If set "true" with event "hover" menu will close fully when mouseout
        autoClose   : true,                  // If set to "true" only one sub-menu open at any time
        autoExpand  : false,                 // If set to "true" all sub-menus of parent tags with class 'classExpand' will expand on page load
        speed       : 'slow',                // Speed of animation
        saveState   : true,                  // Save menu state using cookies
        disableLink : true,                  // Disable all links of parent items
        showCount   : true,                  // If "true" will add a count of the number of links under each parent menu item
        cookie      : 'dcjq-accordion'       // Sets the cookie name for saving menu state - each menu instance on a single page requires a unique cookie name.
};
```

### Overiding Default Options
All of the default options can be overidden by passing an object into the Vertical Accordion Menu method upon initialisation – e.g:

```
$('#accordion').dcAccordion({
        eventType   : 'hover',
        hoverDelay  : 600,
        menuClose   : false,
        autoClose   : false,
        autoExpand  : true,
        classExpand : 'parent-item',
        speed       : 'fast',
        cookie      : 'my-cookie'
});
```
