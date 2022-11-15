<?php

namespace MPHBTemplates\Blocks;

use MPHB\Views\LoopRoomTypeView;
use MPHB\Views\SingleRoomTypeView;

class Gallery {

    public $slug = 'gallery';
    private $galleryParams;
    private $isSlider = false;

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

        $defaults = array(
            'link' => '',
            'columns' => '',
            'size' => '',
            'lightbox' => ''
        );

        $this->galleryParams = wp_parse_args($attributes, $defaults);
        $this->isSlider = isset($attributes['slider']) ? boolval($attributes['slider']) : false;

        if ('mphb_room_type' != get_post_type($id)) {
            return '';
        }

        $currentRoomType = MPHB()->getCurrentRoomType();

        MPHB()->setCurrentRoomType($id);
        $this->applyGalleryParams();

        $galleryHTML = '';
        ob_start();

        if ($this->isSlider) {
            LoopRoomTypeView::renderGallery();
        } else {
            SingleRoomTypeView::renderGallery();
        }

        $galleryHTML = ob_get_clean();

        $this->restoreGalleryParams();
        MPHB()->setCurrentRoomType($currentRoomType ? $currentRoomType->getId() : get_the_ID());

        return $galleryHTML;
    }

    private function applyGalleryParams() {
        if($this->isSlider) {
            add_filter('mphb_loop_room_type_gallery_main_slider_image_link', array($this, 'filterGalleryLink'));
            add_filter('mphb_loop_room_type_gallery_main_slider_columns', array($this, 'filterGalleryColumns'));
            add_filter('mphb_loop_room_type_gallery_main_slider_image_size', array($this, 'filterGalleryImageSize'));
            add_filter('mphb_loop_room_type_gallery_use_nav_slider', array($this, 'filterGalleryNavSlider'));

            add_action('mphb_render_loop_room_type_before_gallery', array($this, 'removeDefaultSliderWrapper'), 1);
            add_action('mphb_render_loop_room_type_before_gallery', array($this, 'renderSliderWrapperOpen'));
            add_action('mphb_render_loop_room_type_after_gallery', array($this, 'renderSliderWrapperClose'));
            add_filter('mphb_loop_room_type_gallery_main_slider_wrapper_class', array($this, 'filterSliderClasses'));
            add_filter('mphb_loop_room_type_gallery_main_slider_flexslider_options', array($this, 'filterSliderAttributes'));
        } else {
            add_filter('mphb_single_room_type_gallery_image_link', array($this, 'filterGalleryLink'));
            add_filter('mphb_single_room_type_gallery_columns', array($this, 'filterGalleryColumns'));
            add_filter('mphb_single_room_type_gallery_image_size', array($this, 'filterGalleryImageSize'));
            add_filter('mphb_single_room_type_gallery_use_magnific', array($this, 'filterGalleryLightbox'));
        }
    }

    private function restoreGalleryParams() {
        if($this->isSlider) {
            remove_filter('mphb_loop_room_type_gallery_main_slider_image_link', array($this, 'filterGalleryLink'));
            remove_filter('mphb_loop_room_type_gallery_main_slider_columns', array($this, 'filterGalleryColumns'));
            remove_filter('mphb_loop_room_type_gallery_main_slider_image_size', array($this, 'filterGalleryImageSize'));
            remove_filter('mphb_loop_room_type_gallery_use_nav_slider', array($this, 'filterGalleryNavSlider'));

            remove_action('mphb_render_loop_room_type_before_gallery', array($this, 'removeDefaultSliderWrapper'), 1);
            remove_action('mphb_render_loop_room_type_before_gallery', array($this, 'renderSliderWrapperOpen'));
            remove_action('mphb_render_loop_room_type_after_gallery', array($this, 'renderSliderWrapperClose'));
            remove_filter('mphb_loop_room_type_gallery_main_slider_wrapper_class', array($this, 'filterSliderClasses'));
            remove_filter('mphb_loop_room_type_gallery_main_slider_flexslider_options', array($this, 'filterSliderAttributes'));
        } else {
            remove_filter('mphb_single_room_type_gallery_image_link', array($this, 'filterGalleryLink'));
            remove_filter('mphb_single_room_type_gallery_columns', array($this, 'filterGalleryColumns'));
            remove_filter('mphb_single_room_type_gallery_image_size', array($this, 'filterGalleryImageSize'));
            remove_filter('mphb_single_room_type_gallery_use_magnific', array($this, 'filterGalleryLightbox'));
        }
    }

    public function filterGalleryLink($link) {
        if($this->galleryParams['link']) {
            $link = $this->galleryParams['link'];
        }

        if($this->isSlider) {
            $link = 'none';
        }

        return $link;
    }

    public function filterGalleryColumns($columns) {
        if($this->galleryParams['columns']) {
            $columns = $this->galleryParams['columns'];
        }

        return $columns;
    }

    public function filterGalleryImageSize($size) {
        if($this->galleryParams['size']) {
            return $this->galleryParams['size'];
        }

        return $size;
    }

    public function filterGalleryLightbox($lightbox) {
        if($this->galleryParams['lightbox']) {
            return $this->galleryParams['lightbox'] == 'yes';
        }

        return $lightbox;
    }

    public function filterGalleryNavSlider() {
        return false;
    }

    public function removeDefaultSliderWrapper() {
        remove_action( 'mphb_render_loop_room_type_before_gallery', array( '\MPHB\Views\LoopRoomTypeView', '_renderImagesWrapperOpen' ), 10 );
		remove_action( 'mphb_render_loop_room_type_after_gallery', array( '\MPHB\Views\LoopRoomTypeView', '_renderImagesWrapperClose' ), 20 );
    }

    public function filterSliderClasses($class) {
        return 'mphb-flexslider-gallery-wrapper';
    }

    public function renderSliderWrapperOpen() {
        ?>
        <div class="mphb-room-type-gallery-wrapper mphb-single-room-type-gallery-wrapper">
        <?php
    }

    public function renderSliderWrapperClose() {
        ?>
        </div>
        <?php
    }

    public function filterSliderAttributes($atts) {
        $atts['minItems'] = 1;
        $atts['maxItems'] = (int)$this->galleryParams['columns'];
        $atts['move'] = 1;
        $atts['itemWidth'] = floor(100/(int)$this->galleryParams['columns']);

        return $atts;
    }
}

new Gallery();
