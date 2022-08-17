<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class EssentialAdmin
{

    public function __construct()
    {
        $this->migration_options_db();
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('wp_ajax_save_eb_admin_options', [$this, 'eb_save_blocks']);
        register_activation_hook(ESSENTIAL_BLOCKS_FILE, array($this, 'activate'));
    }

    public function migration_options_db()
    {
        $opt_db_migration = get_option('eb_opt_migration', false);
        if (version_compare(ESSENTIAL_BLOCKS_VERSION, '1.3.1', '==') && $opt_db_migration === false) {
            update_option('eb_opt_migration', true);
            $all_blocks = get_option('essential_all_blocks', []);
            $blocks = [];
            if (!empty($all_blocks)) {
                foreach ($all_blocks as $block) {
                    $blocks[$block['value']] = $block;
                }
            }
            update_option('essential_all_blocks', $blocks);
        }
    }

    public function add_menu_page()
    {
        add_menu_page(
            __('Essential Blocks', 'essential-blocks'),
            __('Essential Blocks', 'essential-blocks'),
            'delete_user',
            'essential-blocks',
            array($this, 'menu_page_display'),
            ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/images/eb-icon-21x21.svg',
            100
        );
    }

    public function menu_page_display()
    {
        include ESSENTIAL_BLOCKS_DIR_PATH . 'includes/menu-page-display.php';
    }

    public function activate()
    {
        update_option('essential_all_blocks', EBBlocks::get_default_blocks());
    }

    public function eb_save_blocks()
    {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'eb-save-admin-options')) {
            die('Security check');
        } else {
            update_option('essential_all_blocks', $_POST['all_blocks']);
        }
        die();
    }

    /**
     * Get the version number
     */
    public static function get_version($path)
    {
        if (defined('EB_DEV') && EB_DEV === true) {
            return filemtime($path);
        } else {
            return ESSENTIAL_BLOCKS_VERSION;
        }
    }
}
