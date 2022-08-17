<?php

/**
 * Generic data fetching wrapper
 * Uses the WP-API for fetching
 */
function essential_blocks_instagram_fetchData($url)
{
	$request = wp_remote_get($url);

	if (is_wp_error($request)) {
		return false;
	}

	return wp_remote_retrieve_body($request);
}

/**
 * Caching functions
 * The number of images is used as a suffix in the case that the user
 * adds/removes images and expects a refreshed feed.
 */
function essential_blocks_instagram_add_to_cache($result, $suffix = '', $expire = (60 * 60 * 6))
{
	$set = set_transient('eb-main-instagram-api_' . $suffix, $result, $expire);
}

function essential_blocks_instagram_get_from_cache($suffix = '')
{
	return get_transient('eb-main-instagram-api_' . $suffix);
}

/**
 * Server side rendering functions
 */
function essential_blocks_instagram_render_callback(array $attributes)
{
	if (!is_admin()) {
		wp_enqueue_style("essential-blocks-frontend-style");
		wp_enqueue_script("essential-blocks-isotope");
		wp_enqueue_script("essential-blocks-image-loaded");
		wp_enqueue_script("essential-blocks-instagram-feed-block-script");
	}

	$attributes = wp_parse_args(
		$attributes,
		[
			'blockId' => '',
			'token' => '',
			'layout' => 'overlay',
			'cardStyle' => 'content__outter',
			'overlayStyle' => 'overlay__simple',
			'hasEqualImages' => true,
			'numberOfImages' => 6,
			'sortBy' => 'most_recent',
			'showCaptions' => true,
			'showProfileName' => true,
			'showProfileImg' => true,
			'showMeta' => true,
			'enableLink' => false,
			'openInNewTab' => false,
			'profileImg' => '../wp-content/plugins/essential-blocks/assets/images/user.png',
			'profileName' => '',
			'align' => '',
		]
	);

	$token = $attributes['token'];
	$blockId = $attributes['blockId'];
	$classHook = isset($attributes['classHook']) ? $attributes['classHook'] : '';

	$layout = $attributes['layout']; 
	$cardStyle = $attributes['cardStyle'];
	$overlayStyle = $attributes['overlayStyle'];
	$hasEqualImages = $attributes['hasEqualImages'] ? ' has__equal__height' : '';
	$numberOfImages = $attributes['numberOfImages'];
	$sortBy = $attributes['sortBy'];
	$showCaptions = $attributes['showCaptions'];
	$showProfileName = $attributes['showProfileName'];
	$showProfileImg = $attributes['showProfileImg'];
	$showMeta = $attributes['showMeta'];
	$enableLink = $attributes['enableLink'];
	$openInNewTab = $attributes['openInNewTab'];
	$profileImg = isset($attributes['profileImg']) ? $attributes['profileImg'] : '';
	$profileName = isset($attributes['profileName']) ? $attributes['profileName'] : '';
	$align = isset($attributes['align']) ? ' align' . $attributes['align'] : '';


	// originally we got the user id from the token but this no longer possible

	// create a unique id so there is no double ups
	$suffix = $token . '_' . $numberOfImages;
	if (!essential_blocks_instagram_get_from_cache($suffix)) {
		// no valid cache found
		// hit the network
		$result = json_decode(essential_blocks_instagram_fetchData("https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username&limit=500&access_token={$token}"));
		essential_blocks_instagram_add_to_cache($result, $suffix); // add the result to the cache
	} else {
		$result = essential_blocks_instagram_get_from_cache($suffix); // hit the cache
	}

	$thumbs = isset($result->data) ? $result->data : array();

	$layoutClass = $layout === "card" ? $cardStyle : $overlayStyle;

	$imageContainer = sprintf(
		'<div class="eb-parent-wrapper eb-parent-%1$s %2$s">',
		$blockId, $classHook
	);
	$imageContainer .= '<div class="eb-instagram-wrapper ' . $blockId . $align . '">
	<div class="eb-instagram__gallery">
	';

	if (is_array($thumbs)) {

		switch ($sortBy) {
			case 'most_recent':
				usort($thumbs, function ($a, $b) {
					return (int)(strtotime($a->timestamp) < strtotime($b->timestamp));
				});
				break;

			case 'least_recent':
				usort($thumbs, function ($a, $b) {
					return (int)(strtotime($a->timestamp) > strtotime($b->timestamp));
				});
				break;
		}

		foreach ($thumbs as $key => $thumb) {
			$author_info = $meta = '';
			if ('card' === $layout && ($showProfileName || $showProfileImg)) {
				$author_info .= '<div class="author__info">';
				if ($showProfileImg && !empty($profileImg)) {
					$author_info .= '<div class="author__thumb">
							<a href="//www.instagram.com/' . $thumb->username . '" target="_blank"><img src=' . $profileImg . ' alt=' . $thumb->username . ' /></a>
						</div>';
				}
				$author_name = !empty($profileName) ? esc_html($profileName) : $thumb->username;
				if ($showProfileName) {
					$author_info .= '<h5 class="author__name"><a href="//www.instagram.com/' . $thumb->username . '" target="_blank">' . $author_name . '</a></h5>';
				}
				$author_info .= '</div>';
			}

			if ($showMeta) {
				$meta .= '<div class="eb-instagram-meta">
					<span class="dashicons dashicons-clock"></span>
					<span class="eb-instagram-date">
						' . date("d M Y", strtotime($thumb->timestamp)) . '
					</span>
				</div>';
			}

			$caption = $showCaptions && isset($thumb->caption) ? '<div class="eb-instagram-caption"><p>' . $thumb->caption . '</p></div>' : '';
			$media_type = esc_attr($thumb->media_type);
			$image = esc_url($thumb->media_url);

			if ($media_type === "VIDEO") {
				$image = esc_url($thumb->thumbnail_url);
			}
			$imageAlt = isset($thumb->caption) ? $thumb->caption : '';
			$target = $enableLink && $openInNewTab ? '_blank' : '';

			if ($key < $numberOfImages) {
				$imageContainer .= '<div class="instagram__gallery__col">
					<div class="instagram__gallery__item instagram__gallery__item--' . $layoutClass . $hasEqualImages . '">
						' . $author_info;
				if ($enableLink) {
					$imageContainer .= '<a href="' . $thumb->permalink . '" target="' . $target . '">';
				}
				$imageContainer .= '<div class="instagram__gallery__thumb">
				
				 <div class="thumb__wrap">
								<img src="' . $image . '" alt="' . $imageAlt . '" />
							</div>
							' . $caption . '</div>';
				if ($enableLink) {
					$imageContainer .= '</a>';
				}
				$imageContainer .=
					$meta . '
					</div>
				</div>';
			}
		}
	}

	return "{$imageContainer}</div></div></div>";
}
