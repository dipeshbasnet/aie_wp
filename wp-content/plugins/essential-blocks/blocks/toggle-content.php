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
function toggle_content_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	/* Frontend Script */
	wp_register_script(
		'essential-blocks-toggle-content-frontend',
		ESSENTIAL_BLOCKS_ADMIN_URL . 'blocks/toggle-content/frontend/index.js',
		array(),
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/toggle-content/frontend/index.js'),
		true
	);

	register_block_type(
		EssentialBlocks::get_block_register_path("toggle-content"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'  => ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_script('essential-blocks-toggle-content-frontend');
					wp_enqueue_style('essential-blocks-frontend-style');
				}
				return $content;
			}
		)
	);
}
add_action('init', 'toggle_content_block_init');
