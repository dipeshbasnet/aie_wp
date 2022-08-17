<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class EBHelpers
{
    /**
     * Filter Blocks
     */
    public static function filter_blocks($block)
    {
        return isset($block['visibility']) ? $block['visibility'] : false;
    }

    /**
     * Disable Nonce
     */
    public static function disabling_nonce()
    {
        return wp_create_nonce('essential_disabling_nonce');
    }

    /**
     * Get FluentForms List
     *
     * @return array
     */
    public static function get_fluent_forms_list()
    {

        $options = array();

        if (defined('FLUENTFORM')) {
            global $wpdb;
            $options[0]['value'] = '';
            $options[0]['label'] = __('Select a form', 'essential-blocks');
            $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fluentform_forms");
            if ($result) {
                foreach ($result as $key => $form) {
                    $options[$key + 1]['value'] = $form->id;
                    $options[$key + 1]['label'] = $form->title;
                    $options[$key + 1]['attr'] = self::get_form_attr($form->id);
                }
            }
        }
        return $options;
    }

    /**
     * Get Form Attribute
     */
    public static function get_form_attr($form_id)
    {
        return  \FluentForm\App\Helpers\Helper::getFormMeta($form_id, 'template_name');
    }

    /**
     * Get WPForms List
     *
     * @return array
     */
    public static function get_wpforms_list()
    {
        $options = array();

        if (class_exists('\WPForms\WPForms')) {
            $args = array(
                'post_type' => 'wpforms',
                'posts_per_page' => -1,
            );

            $contact_forms = get_posts($args);

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {
                $options[0]['value'] = '';
                $options[0]['label'] = esc_html__('Select a WPForm', 'essential-blocks');
                foreach ($contact_forms as $key => $post) {
                    $options[$key + 1]['value'] = $post->ID;
                    $options[$key + 1]['label'] = $post->post_title;
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'essential-blocks');
        }

        return $options;
    }

    /**
     * API Query Builder
     */
    public static function woo_products_query_builder($attr)
    {

        $query_args = array(
            'post_status' => 'publish',
            'post_type' => 'product',
            'posts_per_page' => isset($attr['per_page']) ? $attr['per_page'] : 10,
            'orderby' => isset($attr['orderby']) ? $attr['orderby'] : 'date',
            'order' => isset($attr['order']) ? $attr['order'] : 'desc',
            'offset' => isset($attr['offset']) ? $attr['offset'] : 0,
        );

        if (isset($attr['orderby'])) {
            switch ($attr['orderby']) {
                case 'price':
                    $query_args['meta_key'] = '_price';
                    $query_args['orderby'] = 'meta_value_num';
                    break;
                case 'popular':
                    $query_args['meta_key'] = 'total_sales';
                    $query_args['orderby'] = 'meta_value_num';
                    $query_args['order']    = 'desc';
                    break;
                case 'rating';
                    $query_args['meta_key'] = '_wc_average_rating';
                    $query_args['orderby'] = 'meta_value_num';
                    break;
                default:
                    $query_args['orderby'] = $attr['orderby'];
                    break;
            }
        }

        if (isset($attr['tags']) && !empty($attr['tags'])) {
            $query_args['tax_query'] = ['relation' => 'OR'];
            $query_args['tax_query'][] = [
                [
                    'taxonomy' => 'product_tag',
                    'field' => 'term_id',
                    'terms' => explode(',', $attr['tags']),
                ]
            ];
        }

        if (isset($attr['categories']) && !empty($attr['categories'])) {

            $query_args['tax_query'][] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => explode(',', $attr['categories']),
                ],
            ];
        }

        return $query_args;
    }

    /**
     * array of object to string
     */
    public static function array_column_from_json($arr, $handle, $json = true)
    {
        $arr = $json ? json_decode($arr, true) : $arr;
        $arr = array_column($arr, $handle);

        return $arr;
    }

    /**
     * check isset & not empty and return data
     */
    public static function get_data($arr, $key, $default = null)
    {
        return isset($arr[$key]) && !empty($arr[$key]) ? $arr[$key] : $default;
    }

    /**
     * Is Gutenberg Editor
     */
    public static function eb_is_gutenberg_editor($pagenow, $param)
    {
        if ($pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'site-editor.php') {
            return true;
        }

        if ($pagenow == 'themes.php' && !empty($param) && str_contains($param, 'gutenberg-edit-site')) {
            return true;
        }

        return false;
    }

    /**
     * EB Template: Header Area
     */
    public static function eb_template_header()
    {
        if (function_exists('wp_is_block_theme') && wp_is_block_theme()) { ?>
            <!doctype html>
            <html <?php language_attributes(); ?>>

            <head>
                <meta charset="<?php bloginfo('charset'); ?>">
                <?php wp_head(); ?>
            </head>

            <body <?php body_class(); ?>>
    <?php
            wp_body_open();

            block_header_area();
        } else {
            get_header();
        }
    }

    /**
     * EB Template: Footer Area
     */
    public static function eb_template_footer()
    {
        if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {

            block_footer_area();

            wp_footer();

            echo "</body></html>";
        } else {
            get_footer();
        }
    }
}
