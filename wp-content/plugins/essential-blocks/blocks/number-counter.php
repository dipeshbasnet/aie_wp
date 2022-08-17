<?php

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */


function counter_block_init()
{
	// Skip block registration if Gutenberg is not enabled/merged.
	if (!function_exists('register_block_type')) {
		return;
	}

	/* Frontend Script */
	wp_register_script(
		'essential-blocks-number-counter-frontend',
		ESSENTIAL_BLOCKS_ADMIN_URL . 'blocks/number-counter/frontend/index.js',
		array(),
		EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/number-counter/frontend/index.js'),
		true
	);

	register_block_type(
		EssentialBlocks::get_block_register_path("number-counter"),
		array(
			'editor_script' => 'essential-blocks-editor-script',
			'editor_style'  => ESSENTIAL_BLOCKS_NAME . '-editor-css',
			'render_callback' => function ($attributes, $content) {
				if (!is_admin()) {
					wp_enqueue_script('essential-blocks-number-counter-frontend');
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
add_action('init', 'counter_block_init');
