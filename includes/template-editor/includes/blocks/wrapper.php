<?php

namespace MPHBTemplates\Blocks;

class Wrapper {

    public $slug = 'wrapper';

    public function __construct() {
        add_action('init', array($this, 'register'));
    }

    public function register() {
        register_block_type_from_metadata(
            MPHB_TEMPLATES_PATH . 'build/' . $this->slug
        );
    }
}

new Wrapper();
