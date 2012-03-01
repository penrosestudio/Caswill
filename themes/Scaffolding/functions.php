<?php 

// Custom header constants
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'scaffolding_header_image_width', 220 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'scaffolding_header_image_height', 220 ) );
define( 'NO_HEADER_TEXT', true );

// Allow for a custom header
add_custom_image_header();

// Allow for a custom background
add_custom_background();


// Register Main and Footer Menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'main_menu', 'Main Menu' );
	register_nav_menu( 'footer_menu', 'Footer Menu' );
}


// Use a filter to add a home link to main_menu
//TO-DO : fix line 26- this doesn't seem to work 

function addHomeMenuLink($menuItems, $args)
{
	if('main_menu' == $args->theme_location)
	{
		if ( is_front_page() )
			$class = 'class="current_page_item"';
		else
			$class = '';	

		$homeMenuItem = '<li ' . $class . '>' .
						$args->before .
						'<a href="' . home_url( '/' ) . '" title="Home">' .
							$args->link_before .
							'Home' .
							$args->link_after .
						'</a>' .
						$args->after .
						'</li>';

		$menuItems = $homeMenuItem . $menuItems;
	}

	return $menuItems;
}

add_filter( 'wp_nav_menu_items', 'addHomeMenuLink', 10, 2 );

// JB What are these numbers for?

// ************************************ create post type: Email Management

if ( ! function_exists( 'post_type_emails' ) ) :

function post_type_emails() {

	register_post_type( 
		'emails',
		array( 
			'label' => __('Emails'), 
			'description' => __('Edit an Email.'), 
			'public' => true, 
			'show_ui' => true,
			'register_meta_box_cb' => 
                        'init_metaboxes_emails',
			'supports' => array (
				'title',
			)
		)
	);
}
endif;

add_action('init', 'post_type_emails');

// add custom fields to the custom post type here
$sp_boxes = array (
	'Email Content' => array (
		array( '_email_subject', 'Email Subject', 'Subject line for the email'),
		array( '_email_text', 'Email Text', 'Body of the email', 'textarea' ),	
	)
);

// Do not edit past this point.

// Use the admin_menu action to define the custom boxes
//add_action( 'admin_menu', 'sp_add_custom_box' ); - not being used in place of the register_meta_box_cb above
function init_metaboxes_emails() {
	sp_add_custom_box();
}

// Adds a custom section to the "advanced" Post and Page edit screens
function sp_add_custom_box() {
	global $sp_boxes;
	if ( function_exists( 'add_meta_box' ) ) {
		foreach ( array_keys( $sp_boxes ) as $box_name ) {
			add_meta_box( $box_name, __( $box_name, 'sp' ), 'sp_post_custom_box', 'emails', 'normal', 'high' );
		}
	}
}

// this handles the nonces for the meta boxes
if ( ! function_exists( 'sp_post_custom_box' ) ) :
function sp_post_custom_box ($obj, $box) {
	global $sp_boxes;
	static $sp_nonce_flag = false;
	echo '<div style="width: 95%%; margin: 10px auto 10px auto; background-color: #F9F9F9; border: 1px solid #DFDFDF; -moz-border-radius: 5px; -webkit-border-radius: 5px; padding: 10px;">';
	// Run once
	if ( ! $sp_nonce_flag ) {
		echo_sp_nonce();
		$sp_nonce_flag = true;
	}
	// Generate box contents
	foreach ( $sp_boxes[$box['id']] as $sp_box ) {
		echo field_html( $sp_box );
	}
	echo '</div>';
}
endif;

// this switch statement specifies different types of meta boxes
// you can add more types if you add a case and a corresponding function
// to handle it
if ( ! function_exists( 'field_html' ) ) :
function field_html ( $args ) {
	switch ( $args[3] ) {
		case 'textarea':
			return text_area( $args );
		case 'checkbox':
			return sp_checkbox( $args );
		case 'select':
			return sp_select( $args );
		default:
			return text_field( $args );
	}
}
endif;

// this is the default text field meta box
if ( ! function_exists( 'text_field' ) ) :
function text_field ( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<div style="overflow:hidden;  margin-top:10px;">'.
		'<div style="width:100px; float:left;"><label for="%1$s"><strong>%2$s</strong></label></div>'.
		'<div style="width:500px; float:left;"><input style="width: 80%%;" type="text" name="%1$s" value="%3$s" />'.
		'<p style="clear:both"><em>'.$description.'</em><p></div>'.
		'</div>';
	return vsprintf( $label_format, $args );
}
endif;

// this is the text area meta box
if ( ! function_exists( 'text_area' ) ) :
function text_area ( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<div style="overflow:hidden; margin-top:10px; ">'.
		'<div style="width:100px; float:left;"><label for="%1$s"><strong>%2$s</strong></label></div>'.
		'<div style="width:500px; float:left;"><textarea style="width: 90%%;" name="%1$s">%3$s</textarea>'.
		'<p style="clear:both"><em>'.$description.'</em></p></div>'.
		'</div>';
	return vsprintf( $label_format, $args );
}
endif;

// this is the checkbox meta box
if ( ! function_exists( 'sp_checkbox' ) ) :
function sp_checkbox ( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<div style="width: 95%%; margin: 10px auto 10px auto; background-color: #F9F9F9; border: 1px solid #DFDFDF; -moz-border-radius: 5px; -webkit-border-radius: 5px; padding: 10px;">'.
		'<p><label for="%1$s"><strong>%2$s</strong></label></p>';
	$current_value = $args[2];
	$checked = ($current_value == "on") ? ' checked="checked"' : '';
	$label_format .= '<p><input type="checkbox" name="%1$s" '.$checked.' /></p>'.
		'<p><em>'.$description.'</em></p>'.
		'</div>';
	return vsprintf( $label_format, $args );
}
endif;

// this is the select meta box
if ( ! function_exists( 'sp_select' ) ) :
function sp_select ( $args ) {
	global $post;
	$description = $args[2];
	// adjust data
	$args[2] = get_post_meta($post->ID, $args[0], true);
	$args[1] = __($args[1], 'sp' );
	$label_format =
		'<div style="overflow:hidden; margin-top:10px; ">'.
		'<div style="width:100px; float:left;"><label for="%1$s"><strong>%2$s</strong></label></div>'.
		'<div style="width:500px; float:left;">'.
		'<select name="%1$s" id="%1$s">';
	
	$current_value = $args[2];
	$select_options = array( // JRL - we'll want to take this options definition out of this function and pop it up where people are setting up the metaboxes
		"on_the_market"=>"On the market",
		"under_offer"=>"Under offer",
		"let"=>"Let"
	);
	foreach($select_options as $value => $text){
	
		// if this value is the current_value we'll mark it selected
		
		$selected = ($current_value == $value) ? ' selected="selected"' : '';
		
		// escape value	for quotes so they won't break the html
		$value = addslashes($value);
		
		$label_format .= '<option value="'.$value.'"'.$selected.'>'.$text.'</option>';
	}
		
	$label_format .= '</select>'.
		'<p><em>'.$description.'</em></p></div>'.
		'</div>';
	return vsprintf( $label_format, $args );
}
endif;

/* When the post is saved, saves our custom data */
if ( ! function_exists( 'sp_save_postdata' ) ) :
function sp_save_postdata($post_id, $post) {
	global $sp_boxes;
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( ! wp_verify_nonce( $_POST['sp_nonce_name'], plugin_basename(__FILE__) ) ) {
		return $post->ID;
	}
	// Is the user allowed to edit the post or page?
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post->ID ))
			return $post->ID;
		} else {
		if ( ! current_user_can( 'edit_post', $post->ID ))
			return $post->ID;
		}
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		// The data is already in $sp_boxes, but we need to flatten it out.
		foreach ( $sp_boxes as $sp_box ) {
			foreach ( $sp_box as $sp_fields ) {
				$my_data[$sp_fields[0]] =  $_POST[$sp_fields[0]];
			}
		}
		// Add values of $my_data as custom fields
		// Let's cycle through the $my_data array!
		foreach ($my_data as $key => $value) {
			if ( 'revision' == $post->post_type  ) {
				// don't store custom data twice
				return;
			}
			// if $value is an array, make it a CSV (unlikely)
			$value = implode(',', (array)$value);
			if ( get_post_meta($post->ID, $key, FALSE) ) {
				// Custom field has a value.
				update_post_meta($post->ID, $key, $value);
			} else {
				// Custom field does not have a value.
				add_post_meta($post->ID, $key, $value);
		}
		if (!$value) {
			// delete blanks
			delete_post_meta($post->ID, $key);
		}
	}
}
endif;

if ( ! function_exists( 'echo_sp_nonce' ) ) :
function echo_sp_nonce () {
	// Use nonce for verification ... ONLY USE ONCE!
	echo sprintf(
		'<input type="hidden" name="%1$s" id="%1$s" value="%2$s" />',
		'sp_nonce_name',
		wp_create_nonce( plugin_basename(__FILE__) )
	);
}
endif;

// A simple function to get data stored in a custom field
if ( ! function_exists( 'get_custom_field' ) ) :
if ( !function_exists('get_custom_field') ) {
	function get_custom_field($field) {
		global $post;
		$custom_field = get_post_meta($post->ID, $field, true);
		echo $custom_field;
	}
}
endif;

// Use the save_post action to do something with the data entered
// Save the custom fields
add_action( 'save_post', 'sp_save_postdata', 1, 2 );




?>