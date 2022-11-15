<?php

namespace MPHBTemplates;

class TemplatesRegistrar {

    private $templates = array();
    private $customTemplates = array();
    private $accommodationPostType;
    private $selectedTemplateID;

    public function __construct() {

        $this->setupTemplates();

        add_action('init', array($this, 'addTemplates'));
        add_filter('single_template', array($this, 'maybeReplaceAccommodationTemplate'), 20);
    }

    private function setupTemplates() {
        $this->accommodationPostType = MPHB()->postTypes()->roomType()->getPostType();

        $this->templates = array(
            'header-footer' => esc_html__('Hotel Booking Full Width', 'mphb-styles'),
            'canvas' => esc_html__('Hotel Booking Canvas', 'mphb-styles')
        );

        $customTemplates = array();

        $posts = get_posts(array(
            'post_type' => 'mphb_template',
            'numberposts' => -1,
        ));

        foreach ($posts as $post) {
            $customTemplates[$post->ID] = $post->post_title;
        }

        $this->customTemplates = $customTemplates;
    }

    public function addTemplates() {
        add_filter("theme_{$this->accommodationPostType}_templates", [$this, 'filterAccommodationTypeTemplatesDropdown'], 10, 4);
        add_filter('theme_mphb_template_templates', [$this, 'filterTemplatesDropdown'], 10, 4);
    }

    public function filterTemplatesDropdown($templates) {
        return $templates + $this->templates;
    }

    public function filterAccommodationTypeTemplatesDropdown($templates) {
        return $templates + $this->customTemplates;
    }

    public function maybeReplaceAccommodationTemplate($template) {
        global $post;

        if(!$post || $post->post_type != $this->accommodationPostType) {
            return $template;
        }

        // get chosen Template for Acc. Type
        $templateID = get_post_meta($post->ID, '_wp_page_template', true);
        $hasTemplate = isset($this->customTemplates[$templateID]);

        $this->selectedTemplateID = $templateID;

        if (!$hasTemplate) {
            return $template;
        }

        // preform some actions to replace content of Acc. Type
        add_action('loop_start', array($this, 'applyTemplate'), 0);

        // get chosen template for selected Template
        $phpTemplate = get_post_meta($templateID, '_wp_page_template', true);
        $hasPHPTemplate = isset($this->templates[$phpTemplate]);

        if(!$hasPHPTemplate) {
            return $template;
        }

        // try to apply template for selected Template(Full Width or Canvas)
        $file = locate_template(MPHB()->getTemplatePath() . 'templates/single/' . $phpTemplate . '.php');

        if(empty($file)) {
            $file = MPHB_TEMPLATES_PATH . 'includes/templates/single/' . $phpTemplate . '.php';
        }

        if(file_exists($file)) {
            return $file;
        }

        return $template;
    }

    public function applyTemplate($query) {

        if($query->is_main_query()) {
            // remove HB filter that appends Acc. Type additional info(gallery, price, calendar, form)
            remove_action('loop_start', array(MPHB()->postTypes()->roomType(), 'setupPseudoTemplate'));

            // try to make sure that our filter is almost certainly the first (-1 priority), content will be replaced in replaceAccommodationContent
			add_filter('the_content', array($this, 'replaceAccommodationContent'), -1);

            // next actions
			remove_action('loop_start', array($this, 'applyTemplate'), 0);
			add_action('loop_end', array($this, 'stopReplaceAccommodationContent'));
		}
    }

    public function replaceAccommodationContent($content) {
        if(is_main_query()) {
            // remove the filter to ensure that the filter only runs once
            remove_filter('the_content', array($this, 'replaceAccommodationContent'), -1);
            // replace accommodation content with selected Template content
            $content = get_post($this->selectedTemplateID)->post_content;
        }

        return $content;
    }

    public function stopReplaceAccommodationContent($query) {
        if ($query->is_main_query()) {
            // remove filter if some reason the_content don't used by theme's loop
            remove_filter('the_content', array($this, 'replaceAccommodationContent'));
            remove_action('loop_end', array($this, 'stopReplaceAccommodationContent'));
        }
    }
}

new TemplatesRegistrar();