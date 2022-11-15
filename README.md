# Hotel Booking Styles & Templates: Extra Styles and Tools for MotoPress Hotel Booking Plugin

![](https://img.shields.io/wordpress/plugin/v/mphb-styles)
![](https://img.shields.io/wordpress/plugin/wp-version/mphb-styles)
![](https://img.shields.io/wordpress/plugin/dm/mphb-styles)
![](https://img.shields.io/wordpress/plugin/installs/mphb-styles)
![](https://img.shields.io/wordpress/plugin/rating/mphb-styles)
![](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg?style=flat)

The Hotel Booking Styles plugin allows you to further customize the styling of the WordPress [MotoPress Hotel Booking plugin](https://motopress.com/products/hotel-booking/). This is a helpful utility if you use the Hotel Booking plugin in the themes other than those by MotoPress.

The plugin ships with a bundle of ready-made CSS classes for tailoring such essentials as the property search form, booking forms, and other shortcodes/blocks sourced by Hotel Booking. Since this is a user-friendly list of styles, the Hotel Booking Styles & Templates plugin can be especially beneficial for non-tech users.

You can also create custom templates for the accommodation type pages, which will allow you to change the default look of the individual accommodation listings. For example, you can change the order of the accommodation details, turn an image gallery into a slider, choose which extra attributes to show, and do even more tweaks via a user-friendly interface.

Useful links: [Hotel Booking Styles & Templates Download](https://wordpress.org/plugins/mphb-styles/) | [Read More About Hotel Booking Styles & Templates](https://motopress.com/blog/motopress-hotel-booking-search-forms-horizontal/)

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

Working with templates:

1. To add a new template, go to Accommodation > Templates > Add New > Give it a name.
2. Click on every block to see its customization panel from the right and make the needed edits. You can optionally change the order of the blocks or even delete unneeded ones.
3. Once you customized and saved your template, go to Accommodation types > sel ect the one you want to apply a new look to > choose the needed one fr om the Template selector > save the changes.

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
