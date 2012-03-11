<?php
// Register Main and Footer Menu
if ( function_exists( 'register_nav_menu' ) ) {

	unregister_nav_menu( 'main_menu' );
	unregister_nav_menu( 'footer_menu' );

	register_nav_menu( 'films_menu', 'Films Menu' );
	register_nav_menu( 'information_menu', 'Information Menu' );
}

wp_enqueue_script( 'jquery' );
wp_register_script('app', get_bloginfo('stylesheet_directory').'/js/app.js');
wp_enqueue_script('app');

function load_cat_parent_template()
{
    global $wp_query;

    if (!$wp_query->is_category)
        return true; // saves a bit of nesting

    // get current category object
    $cat = $wp_query->get_queried_object();

    // trace back the parent hierarchy and locate a template
    while ($cat && !is_wp_error($cat)) {
        $template = STYLESHEETPATH . "/category-{$cat->slug}.php";

        if (file_exists($template)) {
            load_template($template);
            exit;
        }

        $cat = $cat->parent ? get_category($cat->parent) : false;
    }
}

function get_url_from_content($content='') {
	$matches = array();
	$post_url = preg_match('|^\s*(https?://[^\s"]+)\s*$|im', $content, $matches);
	if(!empty($matches)) {
		return $matches[0];
	}
}

function curl_get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}

function get_thumbnail_url_from_video_url($url='', $size='small') {
	$content = '';
	if ( preg_match("/youtube\.com\/watch/i", $url) ) {
		list($domain, $video_id) = split("v=", $url);
		$video_id = esc_attr($video_id);
		if($size=='large') {
			return "http://img.youtube.com/vi/$video_id/hqdefault.jpg";
		} else {
			return "http://img.youtube.com/vi/$video_id/default.jpg";
		}
	} elseif ( preg_match("/vimeo\.com\/[0-9]+/i", $url) ) {
		list($domain, $video_id) = split(".com/", $url);
		$video_id = esc_attr($video_id);

		$hash = unserialize(curl_get("http://vimeo.com/api/v2/video/$video_id.php"));

		if($size=='large') {
			return $hash[0]['thumbnail_large'];
		} else {
			return $hash[0]['thumbnail_medium'];
		}

	}
}

add_action('template_redirect', 'load_cat_parent_template');

$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );


?>