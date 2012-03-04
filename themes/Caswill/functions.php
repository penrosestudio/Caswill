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
add_action('template_redirect', 'load_cat_parent_template');


?>