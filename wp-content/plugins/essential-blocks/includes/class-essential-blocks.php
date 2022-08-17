<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class EssentialBlocks
{

    protected static $_instance = null;

    private $enabled_blocks = [];

    public static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        // Load Admin Files
        $this->load_admin_dependencies();

        // Fetch Enabled Blocks if not than Default Block List
        $this->enabled_blocks = EBBlocks::enabled_blocks();

        // Load All Block Files
        $this->load_block_dependencies();

        // Load Admin Panel
        new EssentialAdmin();

        //Enqueues
        new EssentialBlocksEnqueue();

        // Templates
        Essential_Blocks_Page_Template::get_instance();

        // load rest api
        new EBRestApi();

        // Patterns

        new EssentialBlocksPatterns();
    }

    private function load_admin_dependencies()
    {
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-essential-admin.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-essential-blocks-enqueues.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/blocks-default.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-helpers.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-essential-blocks-page-template.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-essential-blocks-patterns.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/rest-api.php';
    }
    private function load_block_dependencies()
    {
        if ($this->is_block_enabled('accordion')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/accordion.php';
        }
        if ($this->is_block_enabled('button')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/button.php';
        }
        if ($this->is_block_enabled('call_to_action')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/call-to-action.php';
        }
        if ($this->is_block_enabled('countdown')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/countdown.php';
        }
        if ($this->is_block_enabled('number_counter')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/number-counter.php';
        }
        if ($this->is_block_enabled('dual_button')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/dual-button.php';
        }
        if ($this->is_block_enabled('flipbox')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/flipbox.php';
        }
        if ($this->is_block_enabled('advanced_heading')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/advanced-heading.php';
        }
        if ($this->is_block_enabled('advanced_tabs')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/advanced-tabs.php';
        }
        if ($this->is_block_enabled('advanced_tabs')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/tab.php';
        }
        if ($this->is_block_enabled('image_comparison')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/image-comparison.php';
        }
        if ($this->is_block_enabled('image_gallery')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/image-gallery.php';
        }
        if ($this->is_block_enabled('infobox')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/infobox.php';
        }
        if ($this->is_block_enabled('instagram_feed')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/instagram-feed.php';
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/instagram-feed.php';
        }
        if ($this->is_block_enabled('interactive_promo')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/interactive-promo.php';
        }
        if ($this->is_block_enabled('notice')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/notice.php';
        }
        if ($this->is_block_enabled('row')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/row.php';
        }
        if ($this->is_block_enabled('row')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/column.php';
        }
        if ($this->is_block_enabled('parallax_slider')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/parallax-slider.php';
        }
        if ($this->is_block_enabled('pricing_table')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/pricing-table.php';
        }
        if ($this->is_block_enabled('progress_bar')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/progress-bar.php';
        }
        if ($this->is_block_enabled('social')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/social.php';
        }
        if ($this->is_block_enabled('table_of_contents')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/table-of-contents.php';
        }
        if ($this->is_block_enabled('team_member')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/team-member.php';
        }
        if ($this->is_block_enabled('testimonial')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/testimonial.php';
        }
        if ($this->is_block_enabled('typing_text')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/typing-text.php';
        }
        if ($this->is_block_enabled('wrapper')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/wrapper.php';
        }
        if ($this->is_block_enabled('slider')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/slider.php';
        }
        if ($this->is_block_enabled('post_grid')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/post-grid.php';
        }
        if ($this->is_block_enabled('toggle_content')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/toggle-content.php';
        }
        if ($this->is_block_enabled('feature_list')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/feature-list.php';
        }
        if ($this->is_block_enabled('fluent_forms')) {
            if (in_array('fluentform/fluentform.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/fluent-forms.php';
            }
        }

        if ($this->is_block_enabled('woo_product_grid')) {
            if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/woo-product-grid.php';
            }
        }

        if ($this->is_block_enabled(('wpforms'))) {
            if (count(array_intersect(array('wpforms-lite/wpforms.php', 'wpforms/wpforms.php'), apply_filters('active_plugins', get_option('active_plugins'))))) {
                require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/wpforms.php';
            }
        }

        if ($this->is_block_enabled('advanced_image')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/advanced-image.php';
        }
        if ($this->is_block_enabled('post_carousel')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/post-carousel.php';
        }
        if ($this->is_block_enabled('advanced_video')) {
            require_once ESSENTIAL_BLOCKS_DIR_PATH . '/blocks/advanced-video.php';
        }

        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/category.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/font-loader.php';
        require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/post-meta.php';
    }

    private function is_block_enabled($key = null)
    {
        if (is_null($key)) {
            return true;
        }
        if (isset($this->enabled_blocks[$key])) {
            return true;
        }
        return false;
    }

    public static function get_block_register_path($folder_name)
    {
        if (ESSENTIAL_BLOCKS_WP_VERSION < 5.8) {
            return 'essential-blocks/' . $folder_name;
        } else {
            return ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/' . $folder_name;
        }
    }
}
