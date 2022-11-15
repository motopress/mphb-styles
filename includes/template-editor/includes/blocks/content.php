<?php

namespace MPHBTemplates\Blocks;

class Content {

    public $slug = 'content';

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

        $id = false;

        if (isset($attributes['id'])) {
            $id = (int) $attributes['id'];
        }

        if ('mphb_room_type' != get_post_type($id)) {
            return '';
        }

        $contentHTML = '';

        if ($id) {
            $query = new \WP_Query(array(
                'p' => $id,
                'post_type' => 'mphb_room_type',
            ));

            if($query->have_posts()) {
                ob_start();

                while ($query->have_posts()) {
                    $query->the_post();
                    the_content();
                }

                $contentHTML = ob_get_clean();
            }
            wp_reset_postdata();
        } else {
            ob_start();
                the_content();
            $contentHTML = ob_get_clean();
        }

        return $contentHTML;
    }

}

new Content();
