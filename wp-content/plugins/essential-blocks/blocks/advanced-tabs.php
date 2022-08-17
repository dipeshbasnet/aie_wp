<?php

/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package essential-blocks
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function advanced_tabs_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}
	$dir = dirname(__FILE__);

	//  Frontend Script
	$frontEnd_js = 'advanced-tabs/frontend/index.js';
	wp_register_script(
		'essential-blocks-advanced-tabs-frontend',
		ESSENTIAL_BLOCKS_ADMIN_URL . 'blocks/advanced-tabs/frontend/index.js',
		array(),
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/advanced-tabs/frontend/index.js'),
		true
	);


	register_block_type(
		EssentialBlocks::get_block_register_path("advanced-tabs"), 
		array(
		'editor_script' => 'essential-blocks-editor-script',
		'editor_style'  => ESSENTIAL_BLOCKS_NAME . '-editor-css',
		'render_callback' => function ($attributes, $content) {
			if (!is_admin()) {
				wp_enqueue_script('essential-blocks-advanced-tabs-frontend');
				wp_enqueue_style('essential-blocks-frontend-style');
				wp_enqueue_style(
					'eb-fontawesome-frontend',
					plugins_url('assets/css/font-awesome5.css', dirname(__FILE__)),
					array()
				);
			}
			return $content;
		}
	));
}
add_action('init', 'advanced_tabs_block_init');
