# Hotel Booking Styles: Extra Styles for MotoPress Hotel Booking Plugin

The Hotel Booking Styles plugin allows you to further customize the styling of the WordPress [MotoPress Hotel Booking plugin](https://motopress.com/products/hotel-booking/). This is a helpful utility if you use the Hotel Booking plugin in the themes other than those by MotoPress.

The plugin ships with a bundle of ready-made CSS classes for tailoring such essentials as the property search form, booking forms, and other shortcodes/blocks sourced by Hotel Booking. Since this is a user-friendly list of styles, the Hotel Booking Styles plugin can be especially beneficial for non-tech users.

Useful links: [Hotel Booking Styles Download](https://wordpress.org/plugins/mphb-styles/) | [Read More About Hotel Booking Styles](https://motopress.com/blog/motopress-hotel-booking-search-forms-horizontal/)

## Getting Started
The list of styles available with this plugin:

`is-style-horizontal-form` - to make a default property search form horizontal  
`mphbs-hide-labels` - to remove field labels from the form  
`mphbs-no-paddings` - to remove paddings for the form fields  
`mphbs-hide-rf-tip` - to remove required fields tip   
`mphbs-wrap` - to wrap a form fields on a new line  
`mphbs-fluid-button` - to stretch the ‘search’ button to fit available space  
`mphbs-fw-20`, `mphbs-fw-25`, `mphbs-fw-33`, `mphbs-fw-50`, `mphbs-fw-100` - to change the width of the default form fields  
`is-direct-booking` - to enable horizontal form style for direct booking form for an individual property (works only with the is-style-horizontal-form class and ‘direct bookings’ enabled in the plugin settings).

### Build styles
* In the plugin directory run `npm install`.
* Run `npm run dev` to compile your files automatically whenever you've made changes to the associated files.
* Run `npm run build` to compile your files once.

### Update/generate POT(languages) file
1. Install WP-CLI and add it to PATH (check out [official guide](https://wp-cli.org/#installing))
1. Navigate to ./languages
1. Run `wp i18n make-pot ./..`
1. To subtract new strings run `wp i18n make-pot ./.. mphb-styles-new.pot --subtract="mphb-styles.pot"`

## Support
This is a developer's portal for the Hotel Booking Styles plugin and should not be used for support. Please visit the support page if you need to submit a support request.

## License
Hotel Booking Styles WordPress Plugin, Copyright (C) 2020, MotoPress.
Hotel Booking Styles is distributed under the terms of the GNU GPL.

## Contributions
Anyone is welcome to contribute.

<p align="center">
    <br/>
    Made with 💙 by <a href="https://motopress.com/">MotoPress</a>.<br/>
</p>
