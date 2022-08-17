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
function eb_woo_product_grid()
{
    // Skip block registration if Gutenberg is not enabled/merged.
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type(
        EssentialBlocks::get_block_register_path("woo-product-grid"),
        array(
            'editor_script' => 'essential-blocks-editor-script',
            'editor_style'        => ESSENTIAL_BLOCKS_NAME . '-editor-css',
            'render_callback' =>  'eb_woo_product_grid_callback'
        )
    );
}
add_action('init', 'eb_woo_product_grid');

/**
 * render callback function
 */
function eb_woo_product_grid_callback($attributes)
{

    if (!function_exists('WC')) {
        return;
    }

    if (!is_admin()) {
        wp_enqueue_style("essential-blocks-frontend-style");
        wp_enqueue_style(
            'eb-fontawesome-frontend',
            plugins_url('assets/css/font-awesome5.css', dirname(__FILE__)),
            array()
        );
    }


    $blockId        = EBHelpers::get_data($attributes, 'blockId', '');
    $layout         = EBHelpers::get_data($attributes, 'layout', 'grid');
    $gridPreset     = EBHelpers::get_data($attributes, 'gridPreset', 'grid-preset-1');
    $listPreset     = EBHelpers::get_data($attributes, 'listPreset', 'list-preset-1');
    $saleBadgeAlign = EBHelpers::get_data($attributes, 'saleBadgeAlign', 'align-left');
    $saleText       = EBHelpers::get_data($attributes, 'saleText', 'sale');
    $showRating     = isset($attributes["showRating"]) ? $attributes["showRating"] : true;
    $showPrice      = isset($attributes["showPrice"]) ? $attributes["showPrice"] : true;
    $showSaleBadge  = EBHelpers::get_data($attributes, 'showSaleBadge', true);
    $queryData      = EBHelpers::get_data($attributes, 'queryData', array());
    $productDescLength = EBHelpers::get_data($attributes, 'productDescLength', 5);

    $isCustomCartBtn    = EBHelpers::get_data($attributes, 'isCustomCartBtn', false);
    $simpleCartText     = EBHelpers::get_data($attributes, 'simpleCartText', 'Buy Now');
    $variableCartText   = EBHelpers::get_data($attributes, 'variableCartText', 'Select options');
    $groupedCartText    = EBHelpers::get_data($attributes, 'groupedCartText', 'View products');
    $externalCartText   = EBHelpers::get_data($attributes, 'externalCartText', 'Buy now');
    $defaultCartText    = EBHelpers::get_data($attributes, 'defaultCartText', 'Read more');

    $customCartText = array('simple' => $simpleCartText, 'variable' => $variableCartText, 'group' => $groupedCartText, 'external' => $externalCartText, 'default' => $defaultCartText);

    $args = [];
    $args['per_page']   = isset($queryData['per_page']) ? $queryData['per_page'] : 10;
    $args['orderby']    = isset($queryData['orderby']) && !empty($queryData['orderby']) ? implode(",", EBHelpers::array_column_from_json($queryData['orderby'], 'value')) : 'date';
    $args['order']      = isset($queryData['order']) && !empty($queryData['order']) ? implode(",", EBHelpers::array_column_from_json($queryData['order'], 'value')) : 'desc';
    $args['offset']     = isset($queryData['offset']) ? $queryData['offset'] : 0;
    $args['categories'] = isset($queryData['categories']) && !empty($queryData['categories']) ? implode(",", EBHelpers::array_column_from_json($queryData['categories'], 'value')) : array();
    $args['tags']       = isset($queryData['tags']) && !empty($queryData['tags']) ? implode(",", EBHelpers::array_column_from_json($queryData['tags'], 'value')) : array();

    $args = EBHelpers::woo_products_query_builder($args);

    $query = new \WP_Query($args);
    $presetClass = "grid" === $layout ? $gridPreset : $listPreset;

    if ($isCustomCartBtn) {
        add_filter('woocommerce_product_add_to_cart_text', function () use ($isCustomCartBtn, $customCartText) {

            global $product;
            switch ($product->get_type()) {
                case 'external':
                    return $customCartText['external'];
                case 'grouped':
                    return $customCartText['group'];
                case 'simple':
                    if (!$product->is_in_stock()) {
                        return $customCartText['default'];
                    }
                    return $customCartText['simple'];
                case 'variable':
                    return $customCartText['variable'];
                default:
                    return $customCartText['default'];
            }

            if ('Read more' === $customCartText['default']) {
                return esc_html__('View More', 'essential-blocks');
            }

            return $customCartText['default'];
        });
    }

    ob_start();
?>

    <div class="eb-woo-products-wrapper <?php echo $blockId; ?>" data-id="<?php echo $blockId; ?>">
        <div class="eb-woo-products-gallery <?php echo $presetClass; ?>">
            <?php
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $product = wc_get_product(get_the_ID());
            ?>
                    <div class="eb-woo-products-col">
                        <div class="eb-woo-product">
                            <?php if ("grid" === $layout && 'grid-preset-3' === $gridPreset) { ?>
                                <a class="grid-preset-anchor" href="<?php echo esc_url(get_permalink()); ?>"></a>
                            <?php } ?>
                            <div class="eb-woo-product-image-wrapper">
                                <div class="eb-woo-product-image">
                                    <?php if ("list" === $layout) { ?><a href="<?php echo esc_url(get_permalink()); ?>"><?php } ?>
                                        <?php echo wp_kses_post($product->get_image('woocommerce_thumbnail'));
                                        if ($showSaleBadge && $product->is_on_sale()) { ?>
                                            <span class="eb-woo-product-ribbon <?php echo $saleBadgeAlign; ?>"><?php echo $saleText; ?></span>
                                        <?php } ?>
                                        <?php if ("list" === $layout) { ?></a><?php } ?>
                                </div>
                                <?php
                                if ('grid' === $layout) { ?>
                                    <div class="eb-woo-product-overlay">
                                        <div class="eb-woo-product-button-list">
                                            <?php woocommerce_template_loop_add_to_cart(); ?>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                            <?php if ('grid' === $layout) { ?>
                                <div class="eb-woo-product-content-wrapper">
                                    <div class="eb-woo-product-content">
                                        <?php if ($showRating) { ?>
                                            <div class="eb-woo-product-rating-wrapper">
                                                <?php for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $product->get_average_rating()) { ?>
                                                        <span class="eb-woo-product-rating filled"><i class="fas fa-star"></i></span>
                                                    <?php } else { ?>
                                                        <span class="eb-woo-product-rating"><i class="far fa-star"></i></span>
                                                <?php }
                                                } ?>
                                            </div>
                                        <?php } ?>
                                        <h3 class="eb-woo-product-title"><a href="<?php echo esc_url(get_permalink()) ?>"><?php echo get_the_title(); ?></a></h3>
                                        <?php if ($showPrice) { ?>
                                            <p class="eb-woo-product-price"><?php echo $product->get_price_html(); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                            }
                            if ('list' === $layout) { ?>
                                <div class="eb-woo-product-content-wrapper">
                                    <div class="eb-woo-product-content">
                                        <h3 class="eb-woo-product-title"><a href="<?php echo esc_url(get_permalink()) ?>"><?php echo get_the_title(); ?></a></h3>
                                        <?php if ($showPrice) { ?>
                                            <p class="eb-woo-product-price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
                                        <?php }
                                        if ($showRating) { ?>
                                            <div class="eb-woo-product-rating-wrapper">
                                                <?php for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $product->get_average_rating()) { ?>
                                                        <span class="eb-woo-product-rating filled"><i class="fas fa-star"></i></span>
                                                    <?php } else { ?>
                                                        <span class="eb-woo-product-rating"><i class="far fa-star"></i></span>
                                                <?php }
                                                } ?>
                                            </div>
                                        <?php } ?>
                                        <p class="eb-woo-product-details"><?php 
                                        $str_arr = str_word_count(get_the_content(),1);
                                        echo implode(" ", array_slice($str_arr,0,(int)$productDescLength));
                                        ?></p>
                                        <div class="eb-woo-product-button-list"><?php woocommerce_template_loop_add_to_cart(); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                }
                wp_reset_postdata();
            } else { ?>
                <p><?php _e('No product found', 'essential-blocks'); ?></p>
            <?php }
            ?>
        </div>
    </div>

<?php
    return ob_get_clean();
}
