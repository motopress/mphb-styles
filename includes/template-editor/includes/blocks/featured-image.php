<?php

namespace MPHBTemplates\Blocks;

class FeaturedImage {

    public $slug = 'featured-image';

    public function __construct() {
        add_action('init', array($this, 'register'));
    }

    public function register() {
        register_block_type(
            MPHB_TEMPLATES_PATH . 'build/' . $this->slug,
            array(
                'render_callback' => array($this, 'render'),
            )
        );
    }

    public function render($attributes, $content) {
        $id = isset($attributes['id']) ? (int) $attributes['id'] : get_the_ID();
        $size = isset($attributes['size']) ? $attributes['size'] : null;
        $linkToPost = isset($attributes['linkToPost']) ? $attributes['linkToPost'] : false;

        if ('mphb_room_type' != get_post_type($id)) {
            return '';
        }

        $featuredImageHTML = '';
        ob_start();
        ?>
        <div class="mphb-single-room-type-thumbnails">
            <?php if($linkToPost) : ?>
                <a href="<?php echo esc_url(get_permalink($id));?>">
            <?php endif; ?>
                <?php echo mphb_tmpl_get_room_type_image($id, $size); ?>
            <?php if($linkToPost) : ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
        $featuredImageHTML = ob_get_clean();

        return $featuredImageHTML;
    }

}

new FeaturedImage();
