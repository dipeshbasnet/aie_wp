<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class EssentialBlocksEnqueue
{
    private $is_gutenberg_editor;

    public function __construct()
    {
        global $pagenow;
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $this->is_gutenberg_editor = EBHelpers::eb_is_gutenberg_editor($pagenow, isset($parsed_url['query']) ? $parsed_url['query'] : '');

        add_action('admin_init', array($this, 'enqueue_styles'));
        add_action('admin_init', array($this, 'enqueue_scripts'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_assets'));

        //Localize for both frontend and backend
        add_action('init', array($this, 'localize_enqueue_scripts'));

        add_action('enqueue_block_editor_assets', array($this, 'fronend_backend_assets'));
        add_action('wp_enqueue_scripts', array($this, 'fronend_backend_assets'));
    }

    public function enqueue_block_assets()
    {
        /**
         * Scripts
         */
        wp_register_script(
            'essential-blocks-twenty-move',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/jquery.event.move.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-image-loaded',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/images-loaded.min.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-isotope',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/isotope.pkgd.min.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-twenty-twenty',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/jquery.twentytwenty.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'fslightbox-js',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/fslightbox.min.js',
            array('jquery'),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-masonry',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/masonry.min.js',
            array('jquery'),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-typedjs',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/typed.min.js',
            array('jquery'),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-slickjs',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/slick.min.js',
            array('jquery'),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        wp_register_script(
            'essential-blocks-patterns',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/eb-patterns.js',
            [],
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        $controls_dependencies = include_once ESSENTIAL_BLOCKS_DIR_PATH . 'dist/controls.asset.php';
        $controls_dependencies['dependencies'][] = ESSENTIAL_BLOCKS_NAME . '-blocks-localize';
        wp_register_script(
            "essential-blocks-controls-util",
            ESSENTIAL_BLOCKS_ADMIN_URL . 'dist/controls.js',
            $controls_dependencies['dependencies'],
            $controls_dependencies['version'],
            true
        );

        /**
         * Combined All Block Dependencies
         */
        $blocks_dependencies = include_once ESSENTIAL_BLOCKS_DIR_PATH . 'dist/index.asset.php';
        $blocks_dependencies_thirdparty = array(
            'essential-blocks-vendor-bundle',
            'essential-blocks-controls-util',
            'essential-blocks-twenty-move',
            'essential-blocks-image-loaded',
            'essential-blocks-isotope',
            'essential-blocks-twenty-twenty',
            'fslightbox-js',
            'essential-blocks-masonry',
            'essential-blocks-typedjs',
            'essential-blocks-slickjs',
            'essential-blocks-patterns',
        );
        $blocks_dependencies_marged = array_merge(
            $blocks_dependencies['dependencies'],
            $blocks_dependencies_thirdparty
        );

        /**
         * Register All Block Dependencies
         */
        wp_register_script(
            'essential-blocks-editor-script',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'dist/index.js',
            $blocks_dependencies_marged,
            $blocks_dependencies['version'],
            true
        );

        /**
         * Blocks Enable Disable JS
         */
        $enabledisable_dependencies = include_once ESSENTIAL_BLOCKS_DIR_PATH . 'lib/enable-disable-blocks/index.asset.php';
        $enabledisable_dependencies['dependencies'][] = ESSENTIAL_BLOCKS_NAME . '-blocks-localize';
        $enabledisable_dependencies['dependencies'][] = 'essential-blocks-editor-script';
        wp_enqueue_script(
            "essential-blocks-enable-disable",
            ESSENTIAL_BLOCKS_ADMIN_URL . 'lib/enable-disable-blocks/index.js',
            $enabledisable_dependencies['dependencies'],
            $enabledisable_dependencies['version'],
            true
        );

        /**
         * Styles
         */
        //If vendor files has css and extists
        if (file_exists(plugin_dir_path(__FILE__) . 'vendor-bundle/style.css')) {
            wp_enqueue_style(
                ESSENTIAL_BLOCKS_NAME . '-admin-vendor-style',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'vendor-bundle/style.css',
                array(),
                ESSENTIAL_BLOCKS_VERSION,
                'all'
            );
        }

        /**
         * Register All third party CSS here
         */
        wp_register_style(
            ESSENTIAL_BLOCKS_NAME . '-editor-css',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'dist/controls.css',
            array(
                'slick-style',
                'fslightbox-style',
                'twenty-twenty-style-image-comparison',
                'hover-effects-style',
                'essential-blocks-hover-css',
                'fontpicker-material-theme',
                'fontpicker-default-theme',
                'eb-fontawesome-admin',
                'essential-blocks-frontend-style',
            ),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );
    }

    public function enqueue_scripts()
    {
        //Vendor Bundle
        wp_register_script(
            'essential-blocks-vendor-bundle',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'vendor-bundle/index.js',
            [],
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        global $pagenow;

        /**
         * For Essential Blocks Admin Settings Page
         */
        if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'essential-blocks') {
            wp_enqueue_script(
                ESSENTIAL_BLOCKS_NAME . '-admin',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/essential-blocks.js',
                array('jquery', ESSENTIAL_BLOCKS_NAME . '-swal'),
                ESSENTIAL_BLOCKS_VERSION,
                true
            );

            wp_enqueue_script(
                ESSENTIAL_BLOCKS_NAME . '-swal',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/sweetalert.min.js',
                array('jquery'),
                ESSENTIAL_BLOCKS_VERSION,
                true
            );

            wp_enqueue_script(
                ESSENTIAL_BLOCKS_NAME . '-admin-blocks',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'admin/index.js',
                array('wp-i18n', 'wp-element', 'wp-hooks', 'wp-util', 'wp-components', 'essential-blocks-vendor-bundle'),
                ESSENTIAL_BLOCKS_VERSION,
                true
            );

            wp_enqueue_script(
                'essential-blocks-category-icon',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'lib/update-category-icon/index.js',
                array('wp-blocks'),
                ESSENTIAL_BLOCKS_VERSION,
                true
            );

            wp_localize_script(ESSENTIAL_BLOCKS_NAME . '-admin-blocks', 'EssentialBlocksAdmin', array(
                'all_blocks' => EBBlocks::get_blocks(),
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('eb-save-admin-options'),
            ));
        }

        /**
         * Only for Blocks Pages
         */
        if ($this->is_gutenberg_editor) {
        }
    }

    public function enqueue_styles()
    {
        //Admin General CSS for Admin page design
        wp_enqueue_style(
            ESSENTIAL_BLOCKS_NAME,
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/admin.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        global $pagenow;

        if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'essential-blocks') {
            //Admin General CSS for Admin page design
            wp_enqueue_style(
                ESSENTIAL_BLOCKS_NAME,
                ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/admin.css',
                array(),
                ESSENTIAL_BLOCKS_VERSION,
                'all'
            );

            //Admin Page custom css
            wp_enqueue_style(
                ESSENTIAL_BLOCKS_NAME . '-admin',
                ESSENTIAL_BLOCKS_ADMIN_URL . 'admin/style.css',
                array(),
                ESSENTIAL_BLOCKS_VERSION,
                'all'
            );
        }

        /**
         * Only for Admin Add/Edit Pages
         */


        if ($this->is_gutenberg_editor) {
        }
    }


    public function fronend_backend_assets()
    {
        //Vendor Bundle
        wp_register_script(
            'essential-blocks-vendor-bundle',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'vendor-bundle/index.js',
            [],
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        /**
         * Enqueue resources for Animation ||Start||
         */
        //Animate JS
        wp_enqueue_script(
            'essential-blocks-eb-animation',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/eb-animation-load.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            true
        );

        //Animate CSS
        wp_enqueue_style(
            ESSENTIAL_BLOCKS_NAME . '-animation',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/animate.min.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );
        /**
         * Enqueue resources for Animation ||End||
         */

        //Blocks Common Style from Dist
        wp_register_style(
            'essential-blocks-frontend-style',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'dist/style.css',
            array(),
            EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'dist/style.css'),
            'all'
        );

        wp_register_style(
            'eb-fontawesome-admin',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/font-awesome5.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'fontpicker-default-theme',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/fonticonpicker.base-theme.react.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'fontpicker-material-theme',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/fonticonpicker.material-theme.react.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'essential-blocks-hover-css',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/hover-min.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'hover-effects-style',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/hover-effects.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'twenty-twenty-style-image-comparison',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/twentytwenty.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'fslightbox-style',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/fslightbox.min.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );

        wp_register_style(
            'slick-style',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/slick.css',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            'all'
        );
    }

    public function localize_enqueue_scripts()
    {
        

        wp_enqueue_script(
            ESSENTIAL_BLOCKS_NAME . '-blocks-localize',
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/eb-blocks-localize.js',
            array(),
            ESSENTIAL_BLOCKS_VERSION,
            false
        );

        global $pagenow;

        if ($pagenow == 'post-new.php' || $pagenow == 'post.php') {
            wp_localize_script(ESSENTIAL_BLOCKS_NAME . '-blocks-localize', 'eb_conditional_localize', array(
                'editor_type' => 'edit-post'
            ));
        } else if ($pagenow == 'site-editor.php' || ($pagenow == 'themes.php' && isset($_GET['page']) && $_GET['page'] == 'gutenberg-edit-site')) {
            wp_localize_script(ESSENTIAL_BLOCKS_NAME . '-blocks-localize', 'eb_conditional_localize', array(
                'editor_type' => 'edit-site'
            ));
        }
        wp_localize_script(ESSENTIAL_BLOCKS_NAME . '-blocks-localize', 'EssentialBlocksLocalize', array(
            'eb_plugins_url' => ESSENTIAL_BLOCKS_URL,
            'eb_wp_version' => ESSENTIAL_BLOCKS_WP_VERSION,
            'eb_admin_url' => get_admin_url(),
            'rest_rootURL' => get_rest_url(),
            'enabled_blocks' => EBBlocks::get_blocks(),
            'is_fluent_form_active' => defined('FLUENTFORM') ? true : false,
            'fluent_form_lists' => json_encode(EBHelpers::get_fluent_forms_list()),
            'is_wpforms_active' => class_exists('\WPForms\WPForms') ? 'true' : 'false',
            'wpforms_lists' => json_encode(EBHelpers::get_wpforms_list()),
            'is_templately_installed' => file_exists(ESSENTIAL_BLOCKS_DIR_PATH . '../templately/templately.php'),
            'is_templately_active' => class_exists('Templately\Plugin'),
            'woocommerce_active' => in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ? 'true' : 'false'
        ));
    }
}
