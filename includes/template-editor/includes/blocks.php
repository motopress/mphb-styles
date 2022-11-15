<?php

namespace MPHBTemplates;

class BlocksRegistrar {

    private $blocks = array(
        'template',
        'price',
        'gallery',
        'attributes',
        'featured-image',
        'content',
        'title',
        'attribute',
        'wrapper',
    );

    public function __construct() {
        $this->includeBlocks();
    }

    private function includeBlocks() {
        foreach($this->blocks as $block) {
            $path = MPHB_TEMPLATES_PATH . 'includes/blocks/' . $block . '.php';

            if(file_exists($path)) {
                include_once $path;
            }
        }
    }
}

new BlocksRegistrar();