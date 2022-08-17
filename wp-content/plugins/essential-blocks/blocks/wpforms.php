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
function eb_wpforms_block_init()
{
    // Skip block registration if Gutenberg is not enabled/merged.
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type(
        EssentialBlocks::get_block_register_path("wpforms"),
        array(
            'editor_script' => 'essential-blocks-editor-script',
            'render_callback' => 'essential_blocks_wpforms_render_callback',
            'attributes' => array(
                'blockId' => array(
                    'type' => "string",
                ),
                'formId' => array(
                    'type' => 'string',
                ),
            ),
        )
    );
}
add_action('init', 'eb_wpforms_block_init');

// render callback function 
function essential_blocks_wpforms_render_callback($attributes)
{


    if (!class_exists('\WPForms\WPForms')) {
        return;
    }

    if (!is_admin()) {

        wp_enqueue_style('essential-blocks-frontend-style');

        $formId = isset($attributes['formId']) ? absint($attributes['formId']) : '';
        $blockId = isset($attributes['blockId']) ? $attributes['blockId'] : '';
        $classHook = isset($attributes['classHook']) ? $attributes['classHook'] : '';
        $customCheckboxStyle = isset($attributes['customCheckboxStyle']) ? $attributes['customCheckboxStyle'] : false;
        $formAlignment = isset($attributes['formAlignment']) ? $attributes['formAlignment'] : 'none';
        $showLabels = isset($attributes['showLabels']) ? $attributes['showLabels'] : true;
        $showPlaceholder = isset($attributes['showPlaceholder']) ? $attributes['showPlaceholder'] : true;
        $showErrorMessage = isset($attributes['showErrorMessage']) ? $attributes['showErrorMessage'] : true;
        $wrapperClasses = array('eb-wpforms-wrapper');

        $alignment = array('left' => 'eb-wpforms-alignment-left', 'center' => 'eb-wpforms-alignment-center', 'right' => 'eb-wpforms-alignment-right');

        if (array_key_exists($formAlignment, $alignment)) {
            array_push($wrapperClasses, $alignment[$formAlignment]);
        }

        if ($customCheckboxStyle) {
            array_push($wrapperClasses, 'eb-wpforms-custom-radio-checkbox');
        }

        if (!$showLabels) {
            array_push($wrapperClasses, 'eb-wpforms-hide-labels');
        }

        if (!$showPlaceholder) {
            array_push($wrapperClasses, 'eb-wpforms-hide-placeholder');
        }

        if (!$showErrorMessage) {
            array_push($wrapperClasses, 'eb-wpforms-hide-errormessage');
        }


        ob_start();
        echo sprintf(
            '<div class="eb-parent-wrapper eb-parent-%1$s %2$s">',
            $blockId,
            $classHook
        );

        echo '<div class="' . $blockId . " " . implode(" ", $wrapperClasses) . '">';
        wpforms_display($formId);
        echo '</div>';
        echo '</div>';

        return ob_get_clean();
    }
}
