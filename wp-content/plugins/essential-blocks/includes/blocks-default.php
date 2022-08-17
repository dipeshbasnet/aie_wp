<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class EBBlocks
{
    /**
     * Get Current Blocks
     */
    public static function get_blocks()
    {
        $all_blocks = get_option('essential_all_blocks');
        if (empty($all_blocks)) {
            return self::get_default_blocks();
        }

        if (count(self::get_default_blocks()) > count($all_blocks)) {
            return array_merge(self::get_default_blocks(), $all_blocks);
        }

        return $all_blocks;
    }


    /**
     * Enabled Blocks
     */
    public static function enabled_blocks()
    {
        $blocks = self::get_blocks();
        $enabled_blocks = array_filter($blocks, function ($a) {
            return $a['visibility'] === "true" ? $a : false;
        });
        return $enabled_blocks;
    }

    /**
     * Default Blocks
     */
    public static function get_default_blocks()
    {
        $default_blocks = [
            'accordion' => [
                'label' => __('Accordion', 'essential-blocks'),
                'value' => 'accordion',
                'visibility' => 'true',
            ],
            'button' => [
                'label' => __('Button', 'essential-blocks'),
                'value' => 'button',
                'visibility' => 'true',
            ],
            'call_to_action' => [
                'label' => __('Call To Action', 'essential-blocks'),
                'value' => 'call_to_action',
                'visibility' => 'true',
            ],
            'countdown' => [
                'label' => __('Countdown', 'essential-blocks'),
                'value' => 'countdown',
                'visibility' => 'true',
            ],
            'dual_button' => [
                'label' => __('Dual Button', 'essential-blocks'),
                'value' => 'dual_button',
                'visibility' => 'true',
            ],
            'flipbox' => [
                'label' => __('Flipbox', 'essential-blocks'),
                'value' => 'flipbox',
                'visibility' => 'true',
            ],
            'advanced_heading' => [
                'label' => __('Advanced Heading', 'essential-blocks'),
                'value' => 'advanced_heading',
                'visibility' => 'true',
            ],
            'image_comparison' => [
                'label' => __('Image Comparison', 'essential-blocks'),
                'value' => 'image_comparison',
                'visibility' => 'true',
            ],
            'image_gallery' => [
                'label' => __('Image Gallery', 'essential-blocks'),
                'value' => 'image_gallery',
                'visibility' => 'true',
            ],
            'infobox' => [
                'label' => __('Infobox', 'essential-blocks'),
                'value' => 'infobox',
                'visibility' => 'true',
            ],
            'instagram_feed' => [
                'label' => __('Instagram Feed', 'essential-blocks'),
                'value' => 'instagram_feed',
                'visibility' => 'true',
            ],
            'interactive_promo' => [
                'label' => __('Interactive Promo', 'essential-blocks'),
                'value' => 'interactive_promo',
                'visibility' => 'true',
            ],
            'notice' => [
                'label' => __('Notice', 'essential-blocks'),
                'value' => 'notice',
                'visibility' => 'true',
            ],
            'parallax_slider' => [
                'label' => __('Parallax Slider', 'essential-blocks'),
                'value' => 'parallax_slider',
                'visibility' => 'true',
            ],
            'pricing_table' => [
                'label' => __('Pricing Table', 'essential-blocks'),
                'value' => 'pricing_table',
                'visibility' => 'true',
            ],
            'progress_bar' => [
                'label' => __('Progress Bar', 'essential-blocks'),
                'value' => 'progress_bar',
                'visibility' => 'true',
            ],
            'slider' => [
                'label' => __('Slider', 'essential-blocks'),
                'value' => 'slider',
                'visibility' => 'true',
            ],
            'social' => [
                'label' => __('Social Icons', 'essential-blocks'),
                'value' => 'social',
                'visibility' => 'true',
            ],
            'team_member' => [
                'label' => __('Team Member', 'essential-blocks'),
                'value' => 'team_member',
                'visibility' => 'true',
            ],
            'testimonial' => [
                'label' => __('Testimonial', 'essential-blocks'),
                'value' => 'testimonial',
                'visibility' => 'true',
            ],
            'toggle_content' => [
                'label' => __('Toggle Content', 'essential-blocks'),
                'value' => 'toggle_content',
                'visibility' => 'true',
            ],
            'typing_text' => [
                'label' => __('Typing Text', 'essential-blocks'),
                'value' => 'typing_text',
                'visibility' => 'true',
            ],
            'wrapper' => [
                'label' => __('Wrapper', 'essential-blocks'),
                'value' => 'wrapper',
                'visibility' => 'true',
            ],
            'number_counter' => [
                'label' => __('Number Counter', 'essential-blocks'),
                'value' => 'number_counter',
                'visibility' => 'true',
            ],
            'post_grid' => [
                'label' => __('Post Grid', 'essential-blocks'),
                'value' => 'post_grid',
                'visibility' => 'true',
            ],
            'feature_list' => [
                'label' => __('Feature List', 'essential-blocks'),
                'value' => 'feature_list',
                'visibility' => 'true',
            ],
            'row' => [
                'label' => __('Row', 'essential-blocks'),
                'value' => 'row',
                'visibility' => 'true',
            ],
            'table_of_contents' => [
                'label' => __('Table Of Contents', 'essential-blocks'),
                'value' => 'table_of_contents',
                'visibility' => 'true',
            ],
            'fluent_forms' => [
                'label' => __('Fluent Forms', 'essential-blocks'),
                'value' => 'fluent_forms',
                'visibility' => 'true',
            ],
            'advanced_tabs' => [
                'label' => __('Advanced Tabs', 'essential-blocks'),
                'value' => 'advanced_tabs',
                'visibility' => 'true',
            ],
            'woo_product_grid' => [
                'label' => __('Woo Product Grid', 'essential-blocks'),
                'value' => 'woo_product_grid',
                'visibility' => 'true'
            ],
            'advanced_image' => [
                'label' => __('Advanced Image', 'essential-blocks'),
                'value' => 'advanced_image',
                'visibility' => 'true',
            ],
            'wpforms' => [
                'label' => __('WPForms', 'essential-blocks'),
                'value' => 'wpforms',
                'visibility' => 'true',
            ],
            'post_carousel' => [
                'label' => __('Post Carousel', 'essential-blocks'),
                'value' => 'post_carousel',
                'visibility' => 'true',
            ],
            'advanced_video' => [
                'label' => __('Advanced Video', 'essential-blocks'),
                'value' => 'advanced_video',
                'visibility' => 'true',
            ],
        ];

        $pro_blocks = apply_filters('essential_pro_blocks', []);
        $merged_blocks = array_merge($default_blocks, $pro_blocks);
        return $merged_blocks;
    }
}
