<?php

namespace MPHBTemplates\Blocks;

use MPHB\Views\SingleRoomTypeView;

class Price {

    public $slug = 'price';

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
            $id = (int) $attributes['id'];
        } else {
            $id = get_the_ID();
        }

        if ('mphb_room_type' != get_post_type($id)) {
            return '';
        }

        $currentRoomType = MPHB()->getCurrentRoomType();

        MPHB()->setCurrentRoomType($id);

        $priceHTML = '';
        ob_start();
        SingleRoomTypeView::renderDefaultOrForDatesPrice();
        $priceHTML = ob_get_clean();

        MPHB()->setCurrentRoomType($currentRoomType ? $currentRoomType->getId() : get_the_ID());

        return $priceHTML;
    }

}

new Price();
