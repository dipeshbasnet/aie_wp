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
function dual_button_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	register_block_type(
		EssentialBlocks::get_block_register_path("dual-button"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_style('essential-blocks-frontend-style');
					if (isset($attributes["connectorType"]) && $attributes["connectorType"] === "icon") {
						wp_enqueue_style(
							'eb-fontawesome-frontend',
							plugins_url('assets/css/font-awesome5.css', dirname(__FILE__)),
							array()
						);
					}
				}
				return $content;
			}
		)
	);
}
add_action('init', 'dual_button_block_init');