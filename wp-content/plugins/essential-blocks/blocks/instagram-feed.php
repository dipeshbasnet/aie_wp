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
function instagram_feed_block_init()
{
  // Skip block registration if Gutenberg is not enabled/merged.
  if (!function_exists('register_block_type')) {
    return;
  }

  // isotope
  wp_register_script(
    'essential-blocks-isotope',
    ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/isotope.pkgd.min.js',
    array(),
    ESSENTIAL_BLOCKS_VERSION,
    true
  );

  // imageloaded
  wp_register_script(
    'essential-blocks-image-loaded',
    ESSENTIAL_BLOCKS_ADMIN_URL . 'assets/js/images-loaded.min.js',
    array(),
    ESSENTIAL_BLOCKS_VERSION,
    true
  );

  // frontend js
  $frontend_js = 'instagram-feed/frontend/index.js';
  wp_register_script(
    'essential-blocks-instagram-feed-block-script',
    plugins_url($frontend_js, __FILE__),
    array(
      'essential-blocks-isotope',
      'essential-blocks-image-loaded',
    ),
    EssentialAdmin::get_version(ESSENTIAL_BLOCKS_DIR_PATH . 'blocks/instagram-feed/frontend/index.js'),
    true
  );

  register_block_type(
    EssentialBlocks::get_block_register_path("instagram-feed"),
    array(
      'editor_script' => 'essential-blocks-editor-script',
			'editor_style'    	=> ESSENTIAL_BLOCKS_NAME . '-editor-css',
      'render_callback' => 'essential_blocks_instagram_render_callback',
      'attributes' => array(
        'blockId' => array(
          'type' => "string",
        ),
        'layout' => array(
          'type' => "string",
          'default' => "overlay",
        ),
        'overlayStyle' => array(
          'type' => "string",
          'default' => "overlay__simple",
        ),
        'cardStyle' => array(
          'type' => "string",
          'default' => "content__outter",
        ),
        'token' => array(
          'type' => 'string',
          'default' => '',
        ),
        'columns' => array(
          'type' => 'number',
          'default' => "4",
        ),
        'numberOfImages' => array(
          'type' => 'number',
          'default' => 6,
        ),
        'thumbs' => array(
          'type' => 'array',
          'default' => [],
        ),
        'hasEqualImages' => array(
          'type' => 'boolean',
          'default' => true,
        ),
        'showCaptions' => array(
          'type' => 'boolean',
          'default' => true,
        ),
        'showProfileName' => array(
          'type' => 'boolean',
          'default' => true,
        ),
        'showProfileImg' => array(
          'type' => 'boolean',
          'default' => true,
        ),
        'profileImg' => array(
          'type' => 'string',
        ),
        'profileName' => array(
          'type' => 'string',
        ),
        'showMeta' => array(
          'type' => 'boolean',
          'default' => true,
        ),
        'enableLink' => array(
          'type' => 'boolean',
          'default' => false,
        ),
        'openInNewTab' => array(
          'type' => 'boolean',
          'default' => false,
        ),
        'sortBy' => array(
          'type' => "string",
          'default' => "most_recent",
        ),
      ),
    )
  );
}
add_action('init', 'instagram_feed_block_init');
