<?php

defined('ABSPATH') || exit;


class EBRestApi
{

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'eb_register_route'));
    }


    /**
     * REST API Action
     */
    public function eb_register_route()
    {
        register_rest_route(
            'essential-blocks/v1',
            'products',
            array(
                'methods' => \WP_REST_Server::READABLE,
                'args' => array(
                    'order_by' => [], "order" => [], "per_page" => [], "offset" => [], "categories" => [], "tags" => []
                ),
                'callback' => array($this, 'eb_route_product_data'),
                'permission_callback' => '__return_true'
            )
        );
    }

    public function eb_route_product_data($prams, $local = false)
    {
        $data = [];
        $loop = new \WP_Query(EBHelpers::woo_products_query_builder($prams));

        if ($loop->have_posts()) {
            while ($loop->have_posts()) {
                $loop->the_post();

                $products                = array();
                $post_id                 = get_the_ID();
                $product                 = wc_get_product($post_id);
                $products['id']          = $post_id;
                $products['title']       = get_the_title();
                $products['permalink']   = get_permalink();
                $products['excerpt']     = strip_tags(get_the_content());
                $products['excerpt_full'] = strip_tags(get_the_excerpt());
                $products['time']        = get_the_date();
                $products['price']       = $product->get_price();
                $products['price_sale']  = $product->get_sale_price();
                $products['price_regular'] = $product->get_regular_price();
                $products['discount']    = ($products['price_sale'] && $products['price_regular']) ? round(($products['price_regular'] - $products['price_sale']) / $products['price_regular'] * 100) . '%' : '';
                $products['sale']        = $product->is_on_sale();
                $products['price_html']  = $product->get_price_html();
                $products['stock']       = $product->get_stock_status();
                $products['featured']    = $product->is_featured();
                $products['rating_count'] = $product->get_rating_count();
                $products['rating_average'] = $product->get_average_rating();
                $products['add_to_cart_url'] = $product->add_to_cart_url();
                $products['add_to_cart_text'] = $product->add_to_cart_text();
                $products['type'] = $product->get_type();


                // image
                if (has_post_thumbnail()) {
                    $thumb_id = get_post_thumbnail_id($post_id);
                    $image_sizes = get_intermediate_image_sizes();
                    $image_src = array();
                    foreach ($image_sizes as $key => $value) {
                        $image_src[$value] = wp_get_attachment_image_src($thumb_id, $value, false)[0];
                    }
                    $products['image'] = $image_src;
                }

                // tag
                $tag = get_the_terms($post_id, (isset($prams['tag']) ? esc_attr($prams['tag']) : 'product_tag'));
                if (!empty($tag)) {
                    $all_tag = array();
                    foreach ($tag as $val) {
                        $all_tag[] = array('term_id' => $val->term_id, 'slug' => $val->slug, 'name' => $val->name, 'url' => get_term_link($val->term_id));
                    }
                    $products['tag'] = $all_tag;
                }

                // cat
                $cat = get_the_terms($post_id, (isset($prams['cat']) ? esc_attr($prams['cat']) : 'product_cat'));
                if (!empty($cat)) {
                    $all_cats = array();
                    foreach ($cat as $val) {
                        $all_cats[] = array('term_id' => $val->term_id, 'slug' => $val->slug, 'name' => $val->name, 'url' => get_term_link($val->term_id));
                    }
                    $products['category'] = $all_cats;
                }
                $data[] = $products;
            }
            wp_reset_postdata();
        }
        return $data;
    }
}
