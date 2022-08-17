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
function tab_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}
	$dir = dirname(__FILE__);

	register_block_type(
		EssentialBlocks::get_block_register_path("tab"), 
		array(
		'editor_script' => 'essential-blocks-editor-script',
		// 'render_callback' => function ($attributes, $content) {
		// 	if (!is_admin()) {
		// 		wp_enqueue_script('essential-blocks-tab-frontend');
		// 	}
		// 	return $content;
		// }

	));
}
add_action('init', 'tab_block_init');
