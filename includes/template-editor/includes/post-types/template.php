<?php

namespace MPHBTemplates\PostTypes;

class AccommodationTemplate {

    private $postType = 'mphb_template';

    public function __construct() {
        add_action('init', array($this, 'register'));
        add_action('admin_menu', array($this, 'addMenuPage'), 99);
        add_action('admin_footer', array($this, 'addPageDescription'));
    }

    public function register() {
        register_post_type($this->postType, array(
            'labels'      => array(
                'name' => __('Templates (beta)', 'mphb-styles'),
                'singular_name' => __('Template', 'mphb-styles'),
                'add_new' => __('Add New Template', 'mphb-styles'),
                'add_new_item' => __('Add New Template', 'mphb-styles'),
                'edit_item' => __('Edit Template', 'mphb-styles'),
                'new_item' => __('New Template', 'mphb-styles'),
                'view_item' => __('View Template', 'mphb-styles'),
                'search_items' => __('Search Templates', 'mphb-styles')
            ),
            'public' => true,
            'show_in_rest' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => false,
            'show_in_admin_bar' => false,
            'template' => array(
                array( 'motopress-hotel-booking/wrapper',
                    array(
                        'maxWidth' => 600
                    ),
                    array(
                        array( 'motopress-hotel-booking/featured-image', array() ),
                        array( 'motopress-hotel-booking/title', array() ),
                        array( 'motopress-hotel-booking/gallery', array() ),
                        array( 'motopress-hotel-booking/content', array() ),
                        array( 'motopress-hotel-booking/price', array() ),
                        array( 'motopress-hotel-booking/attributes', array() ),
                        array( 'motopress-hotel-booking/availability-calendar', array() ),
                        array( 'motopress-hotel-booking/availability', array() )
                    )
                )
            ),
		));
    }

    public function addMenuPage() {
        add_submenu_page(
            MPHB()->postTypes()->roomType()->getMenuSlug(),
            __('Templates', 'mphb-styles'),
            __('Templates', 'mphb-styles'),
            'manage_options' ,
            'edit.php?post_type=' . $this->postType,
            '',
            99
        );
    }

    public function addPageDescription() {
        global $typenow, $pagenow;

        if(!is_admin() || $pagenow !== 'edit.php' || $typenow !== $this->postType) {
            return;
        }

        ?>
        <script type="text/javascript">
            jQuery(function () {
                var pageDescription = "<?php echo esc_html__('Сhange the look of your accommodation type pages by creating custom templates. You can apply your templates to the chosen properties via Accommodation Type > Template selector.', 'mphb-styles'); ?>";
                var description = jQuery('<p />', {'html': pageDescription});

                jQuery('#wpbody-content > .wrap > ul.subsubsub').first().before(description);
            });
        </script>
        <?php
    }
}

new AccommodationTemplate();