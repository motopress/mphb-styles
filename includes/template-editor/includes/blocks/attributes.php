<?php

namespace MPHBTemplates\Blocks;

use MPHB\Views\SingleRoomTypeView;

class Attributes {

    public $slug = 'attributes';
    private $hiddenAttributes = [];
    private $customAttributes = [];

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

        add_action('admin_enqueue_scripts', array($this, 'blockScript'));

        global $mphbAttributes;

        $this->customAttributes = $mphbAttributes;
    }

    public function render($attributes, $content) {

        $id = isset($attributes['id']) ? (int) $attributes['id'] : get_the_ID();
        $this->hiddenAttributes = isset($attributes['hiddenAttributes']) ? explode(',', $attributes['hiddenAttributes']) : [];

        if ('mphb_room_type' != get_post_type($id)) {
            return '';
        }

        $currentRoomType = MPHB()->getCurrentRoomType();

        MPHB()->setCurrentRoomType($id);
        $this->applyAttributesParams();

        $attributesHTML = '';
        ob_start();
        SingleRoomTypeView::renderAttributes();
        $attributesHTML = ob_get_clean();

        $this->restoreAttributesParams();
        MPHB()->setCurrentRoomType($currentRoomType ? $currentRoomType->getId() : get_the_ID());

        return $attributesHTML;
    }

    public function blockScript() {
        $data = 'window.MPHBTemplates = window.MPHBTemplates || {};';
        $data .= 'window.MPHBTemplates.roomTypeAttributes = ' . json_encode(array_values($this->customAttributes)) . ';';

        wp_add_inline_script('motopress-hotel-booking-attributes-editor-script', $data, 'before');
    }

    private function applyAttributesParams() {
        add_action('mphb_render_single_room_type_before_attributes', array($this, 'removeAttributesTitle'), 0);
        add_action('mphb_render_single_room_type_before_attributes', array($this, 'filterAttributes'));

        global $mphbAttributes;
        foreach($this->customAttributes as $key => $attribute) {
            if($this->shouldHideAttr($attribute['attributeName'])) {
                $mphbAttributes[$key]['visible'] = false;
            }
        }
    }

    private function restoreAttributesParams() {
        remove_action('mphb_render_single_room_type_before_attributes', array($this, 'removeAttributesTitle'), 0);
        remove_action('mphb_render_single_room_type_before_attributes', array($this, 'filterAttributes'));

        global $mphbAttributes;
        $mphbAttributes = $this->customAttributes;
    }

    public function removeAttributesTitle() {
        remove_action( 'mphb_render_single_room_type_before_attributes', array( '\MPHB\Views\SingleRoomTypeView', '_renderAttributesTitle' ), 10 );
    }

    public function filterAttributes() {
        if($this->shouldHideAttr('capacity')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderTotalCapacity' ), 5 );
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderAdults' ), 10 );
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderChildren' ), 20 );
        }

        if($this->shouldHideAttr('amenities')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderFacilities' ), 30 );
        }

        if($this->shouldHideAttr('view')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderView' ), 40 );
        }

        if($this->shouldHideAttr('size')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderSize' ), 50 );
        }

        if($this->shouldHideAttr('bed-types')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderBedType' ), 60 );
        }

        if($this->shouldHideAttr('categories')) {
            remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderCategories' ), 70 );
        }
    }

    private function shouldHideAttr($attr) {
        return in_array($attr, $this->hiddenAttributes);
    }
}

new Attributes();
