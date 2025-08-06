<?php

namespace MPHBTemplates;

class TemplatesRegistrar {

    private $templates = array();
    private $customTemplates = array();
    private $accommodationPostType;
    private $selectedTemplateID;
    private $autopPriority = false;

    public function __construct() {

        add_action('init', array($this, 'addTemplates'));
        add_filter('single_template', array($this, 'maybeReplaceAccommodationTemplate'), 20);
        add_filter('single_template', array($this, 'maybeReplaceTemplateTemplate'), 20);
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
		$this->setupTemplates();
        add_filter("theme_{$this->accommodationPostType}_templates", [$this, 'filterAccommodationTypeTemplatesDropdown'], 10, 4);
        add_filter('theme_mphb_template_templates', [$this, 'filterTemplatesDropdown'], 10, 4);
    }

    public function filterTemplatesDropdown($templates) {
        return $templates + $this->templates;
    }

    public function filterAccommodationTypeTemplatesDropdown($templates) {
        return $templates + $this->customTemplates;
    }

    public function maybeReplaceTemplateTemplate($template) {
        global $post;

        if(!$post || $post->post_type != 'mphb_template') {
            return $template;
        }

        $phpTemplate = get_post_meta($post->ID, '_wp_page_template', true);
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
        // remove the filter to ensure that the filter only runs once
        remove_filter('the_content', array($this, 'replaceAccommodationContent'), -1);

        // replace accommodation content with selected Template content
        if ($this->shouldReplaceWithElementor()) {
            $content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($this->selectedTemplateID, true);
            $this->removeAutopFilter();
        } else {
            $content = get_post($this->selectedTemplateID)->post_content;
        }

        return $content;
    }

    public function stopReplaceAccommodationContent() {
        // remove filter if some reason the_content don't used by theme's loop
        remove_filter('the_content', array($this, 'replaceAccommodationContent'));
        remove_action('loop_end', array($this, 'stopReplaceAccommodationContent'));
    }

    private function shouldReplaceWithElementor() {
        $should_replace = false;

        if (class_exists('\Elementor\Plugin')) {
            $should_replace = \Elementor\Plugin::instance()->documents->get($this->selectedTemplateID)->is_built_with_elementor();
        }

        return $should_replace;
    }

    public function removeAutopFilter() {
        $this->autopPriority = has_filter('the_content', 'wpautop');

        if (false !== $this->autopPriority) {
            remove_filter('the_content', 'wpautop');
            add_filter('the_content', array($this, 'restoreAutopFilter'), $this->autopPriority + 1);
        }
    }

    public function restoreAutopFilter($content) {
        remove_filter('the_content', array($this, 'restoreAutopFilter'), $this->autopPriority + 1);
        add_filter('the_content', 'wpautop', $this->autopPriority, $this->autopPriority);

        return $content;
    }

}

new TemplatesRegistrar();