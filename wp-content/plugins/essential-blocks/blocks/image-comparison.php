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
function image_comparison_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	$frontend_dependencies = include_once ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/image-comparison/frontend/index.asset.php';
	$frontend_dependencies['dependencies'][] = 'essential-blocks-vendor-bundle';

	$frontend_js = 'image-comparison/frontend/index.js';
	wp_register_script(
		'essential-blocks-image-comparison-frontend',
		plugins_url($frontend_js, __FILE__),
		$frontend_dependencies['dependencies'],
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/image-comparison/frontend/index.js'),
		true
	);

	register_block_type(
		EssentialBlocks::get_block_register_path("image-comparison"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_script('essential-blocks-image-comparison-frontend');
				}
				return $content;
			}

		)
	);
}
add_action('init', 'image_comparison_block_init');
