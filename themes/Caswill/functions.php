<?php
// Register Main and Footer Menu
if ( function_exists( 'register_nav_menu' ) ) {

	unregister_nav_menu( 'main_menu' );
	unregister_nav_menu( 'footer_menu' );

	register_nav_menu( 'films_menu', 'Films Menu' );
	register_nav_menu( 'information_menu', 'Information Menu' );
}

function custom_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_register_script('app', get_bloginfo('stylesheet_directory').'/js/app.js');
	wp_enqueue_script('app');
}

add_action('wp_enqueue_scripts', 'custom_scripts');

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

function get_video_source($url) {
	if( preg_match("/youtube\.com\/watch/i", $url) ) {
		return "youtube";
	} elseif ( preg_match("/vimeo\.com\/[0-9]+/i", $url) ) {
		return "vimeo";
	}
}

function get_thumbnail_url_from_video_url($url='', $size='small') {
	$content = '';
	$source = get_video_source($url);
	if ( $source == "youtube" ) {
		list($domain, $video_id) = split("v=", $url);
		$video_id = esc_attr(trim($video_id));
		if($size=='large') {
			return "http://img.youtube.com/vi/$video_id/hqdefault.jpg";
		} else {
			return "http://img.youtube.com/vi/$video_id/default.jpg";
		}
	} elseif ( $source=="vimeo" ) {
		list($domain, $video_id) = split(".com/", $url);
		$video_id = esc_attr(trim($video_id));
		$result = curl_get("http://vimeo.com/api/v2/video/$video_id.php");
		$hash = unserialize($result);
		if($size=='large') {
			return $hash[0]['thumbnail_large'];
		} else {
			return $hash[0]['thumbnail_medium'];
		}

	}
}

function create_video_thumbnail($url) {
	$thumbnail_url = get_thumbnail_url_from_video_url($url, 'large');
	$source = get_video_source($url);
	if($source=="youtube") {
		$imgClass = "youtube";
	} else {
		$imgClass = "";
	}
?>
	<img src="<?php echo $thumbnail_url; ?>" class="<?php echo $imgClass; ?>" alt="<?php the_title(); ?>" />
<?php
}

function fixEmbed($oembvideo, $url, $attr) {
  if(strpos($url,'vimeo.com')!== false) {
    // check if url is for Vimeo video
    $width = 0;
    $height = 0;
    $newheight = 0;
    $attrstart = strpos($oembvideo,'width="');
    if($attrstart !== false) {
      $attrstart += 7;
      $width = substr($oembvideo, $attrstart, strpos($oembvideo,'"',$attrstart+1)-$attrstart);
      $attrstart = strpos($oembvideo,'height="');
      if(($attrstart !== false) && $width>0) {
 	$attrstart += 8;
        $height = substr($oembvideo, $attrstart, strpos($oembvideo,'"',$attrstart+1)-$attrstart);
        $newheight = round($height*$attr['width']/$width);
        $oembvideo = str_replace('height="'.$height,'height="'.$newheight, str_replace('width="'.$width,'width="'.$attr['width'], $oembvideo));
      }
    }
  }
  return $oembvideo;
}
add_filter('embed_oembed_html', 'fixEmbed', 10, 3);

$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

?>