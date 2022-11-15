<?php

namespace MPHBTemplates\Blocks;

use MPHB\Views\SingleRoomTypeView;

class Title {

    public $slug = 'title';
    private $id = false;
    private $linkToPost = false;

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

        if (isset($attributes['id'])) {
            $this->id = (int) $attributes['id'];
        }

        $this->linkToPost = isset($attributes['linkToPost']) ? $attributes['linkToPost'] : false;

        if ('mphb_room_type' != get_post_type($this->id)) {
            return '';
        }

        $titleHTML = '';

        $this->applyTitleParams();


        if ($this->id) {
            $query = new \WP_Query(array(
                'p' => $this->id,
                'post_type' => 'mphb_room_type',
            ));

            if($query->have_posts()) {
                ob_start();

                while ($query->have_posts()) {
                    $query->the_post();
                    SingleRoomTypeView::renderTitle();
                }

                $titleHTML = ob_get_clean();
            }
            wp_reset_postdata();
        } else {
            ob_start();
                SingleRoomTypeView::renderTitle();
            $titleHTML = ob_get_clean();
        }

        $this->restoreTitleParams();

        return $titleHTML;
    }

    private function applyTitleParams() {
        if($this->linkToPost) {
            add_action('mphb_render_single_room_type_before_title', array($this, 'renderLinkOpen'), 15);
            add_action('mphb_render_single_room_type_after_title', array($this, 'renderLinkClose'), 5);
        }
    }

    private function restoreTitleParams() {
        if($this->linkToPost) {
            remove_action('mphb_render_single_room_type_before_title', array($this, 'renderLinkOpen'), 15);
            remove_action('mphb_render_single_room_type_after_title', array($this, 'renderLinkClose'), 5);
        }
    }

    public function renderLinkOpen() {
        $permalink = get_permalink($this->id);
        ?>
        <a href="<?php echo esc_url($permalink);?>">
        <?php
    }

    public function renderLinkClose() {
        ?>
        </a>
        <?php
    }

}

new Title();
