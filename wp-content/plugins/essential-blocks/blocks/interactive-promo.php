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
function interactive_promo_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	register_block_type(
		EssentialBlocks::get_block_register_path("interactive-promo"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_style(
						'hover-effects-style',
						plugins_url('assets/css/hover-effects.css', dirname(__FILE__)),
						array(),
						ESSENTIAL_BLOCKS_VERSION,
						'all'
					);
				}
				return $content;
			}
		)
	);
}
add_action('init', 'interactive_promo_block_init');
