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
function slider_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	$frontend_dependencies = include_once ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/slider/frontend/index.asset.php';
	$frontend_dependencies['dependencies'][] = 'essential-blocks-vendor-bundle';

	/* Frontend Script */
	wp_register_script(
		'essential-blocks-slider-frontend',
		ESSENTIAL_BLOCKS_ADMIN_URL . 'blocks/slider/frontend/index.js',
		$frontend_dependencies['dependencies'],
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/slider/frontend/index.js'),
		true
	);

	register_block_type(
		EssentialBlocks::get_block_register_path("slider"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_script('essential-blocks-slider-frontend');
					wp_enqueue_style('essential-blocks-frontend-style');
					wp_enqueue_style(
						'slick-style',
						plugins_url('assets/css/slick.css', dirname(__FILE__)),
						array(),
						ESSENTIAL_BLOCKS_VERSION
					);

					wp_enqueue_script(
						'essential-blocks-slickjs',
						plugins_url("assets/js/slick.min.js", dirname(__FILE__)),
						array("jquery"),
						ESSENTIAL_BLOCKS_VERSION,
						true
					);
				}
				return $content;
			}
		)
	);
}
add_action('init', 'slider_block_init');
