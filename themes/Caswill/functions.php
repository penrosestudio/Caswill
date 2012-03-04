<?php
// Register Main and Footer Menu
if ( function_exists( 'register_nav_menu' ) ) {

	unregister_nav_menu( 'main_menu' );
	unregister_nav_menu( 'footer_menu' );

	register_nav_menu( 'films_menu', 'Films Menu' );
	register_nav_menu( 'information_menu', 'Information Menu' );
}


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

function get_thumbnail_url_from_video_url($url='') {
	$content = '';
	if ( preg_match("/youtube\.com\/watch/i", $url) ) {
		list($domain, $video_id) = split("v=", $url);
		$video_id = esc_attr($video_id);
		return "http://img.youtube.com/vi/$video_id/default.jpg";

	} elseif ( preg_match("/vimeo\.com\/[0-9]+/i", $url) ) {
		list($domain, $video_id) = split(".com/", $url);
		$video_id = esc_attr($video_id);

		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));

		return $hash[0]['thumbnail_medium'];

	}
}

add_action('template_redirect', 'load_cat_parent_template');


?>