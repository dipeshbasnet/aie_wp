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
function call_to_action_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	wp_register_style(
		'essential-blocks-hover',
		ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/css/hover-min.css',
		array(),
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'assets/css/hover-min.css'),
		'all'
	);

	register_block_type(
		EssentialBlocks::get_block_register_path("call-to-action"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_style('essential-blocks-frontend-style');
					wp_enqueue_style('essential-blocks-hover');
					wp_enqueue_style(
						'eb-fontawesome-frontend',
						plugins_url('assets/css/font-awesome5.css', dirname(__FILE__)),
						array()
					);
				}
				return $content;
			}
		)
	);
}
add_action('init', 'call_to_action_block_init');