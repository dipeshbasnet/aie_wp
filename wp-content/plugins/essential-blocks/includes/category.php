<?php

function eb_block_categories($categories, $post)
{
    $eb_category = array(
        'slug' => 'essential-blocks',
        'title' => __('Essential Blocks', 'essential-blocks'),
    );
    $modifiedCategory[0] = $eb_category;
    $modifiedCategory = array_merge($modifiedCategory, $categories);
    return $modifiedCategory;
}

// Block Categories
if (version_compare(get_bloginfo('version'), '5.8', '>=')) {
    add_filter('block_categories_all', 'eb_block_categories', 10, 2);
} else {
    add_filter('block_categories', 'eb_block_categories', 10, 2);
}