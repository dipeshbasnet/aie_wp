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
function image_gallery_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	register_block_type(
		EssentialBlocks::get_block_register_path("image-gallery"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					$disableLightBox = false;
					if (isset($attributes["disableLightBox"]) && $attributes["disableLightBox"] == true) {
						$disableLightBox = true;
					}

					wp_enqueue_style('essential-blocks-frontend-style');
					//Load Lighbox Resource if Lightbox isn't disbaled
					if (!$disableLightBox) {
						wp_enqueue_style(
							'fslightbox-style',
							plugins_url('assets/css/fslightbox.min.css', dirname(__FILE__)),
							array()
						);

						wp_enqueue_script(
							'fslightbox-js',
							plugins_url("assets/js/fslightbox.min.js", dirname(__FILE__)),
							array('jquery'),
							true,
							true
						);
					}
				}
				return $content;
			}
		)
	);
}
add_action('init', 'image_gallery_block_init');