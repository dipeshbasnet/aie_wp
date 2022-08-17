<?php
/**
 * Plugin Name: Essential Blocks
 * Plugin URI: https://essential-blocks.com
 * Description: The Ultimate Blocks Library for WordPress Gutenberg editor.
 * Author: WPDeveloper
 * Author URI: https://wpdeveloper.com
 * Version: 3.5.4
 * License: GPL3+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: essential-blocks
 *
 * @package Essential_Blocks
 */
if (!defined('ABSPATH')) {
    exit;
}

// Define things
define('ESSENTIAL_BLOCKS_VERSION', '3.5.4');
define('ESSENTIAL_BLOCKS_NAME', 'essensial-blocks');
define('ESSENTIAL_BLOCKS_DIR_PATH', plugin_dir_path(__FILE__));
define('ESSENTIAL_BLOCKS_ADMIN_URL', plugin_dir_url(__FILE__));
define('ESSENTIAL_BLOCKS_FILE', __FILE__);
define('ESSENTIAL_BLOCKS_URL', plugin_dir_url(__FILE__));
define('ESSENTIAL_BLOCKS_WP_VERSION', (float) get_bloginfo('version'));

if (!class_exists('EssentialBlocks')) {
    require_once ESSENTIAL_BLOCKS_DIR_PATH . '/includes/class-essential-blocks.php';
    require_once ESSENTIAL_BLOCKS_DIR_PATH . '/lib/style-handler/style-handler.php';

    EssentialBlocks::get_instance();
}
