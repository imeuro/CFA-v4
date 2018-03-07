<?php
/**
 * Pinbin functions
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */

if ( ! isset( $content_width ) )
	$content_width = 630; /* pixels */

/**
* Custom Theme Options
*/

if ( is_admin() && is_readable( get_template_directory() . '/options/theme-options.php' ) )
	require_once( get_template_directory() . '/options/theme-options.php' );

if ( ! function_exists( 'pinbin_setup' ) ):

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */

function pinbin_setup() {

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

		// post thumbnails
	add_theme_support( 'post-thumbnails' );
		add_image_size('summary-image', 300, 9999);
		add_image_size('detail-image', 750, 9999);

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Buttercream, use a find and replace
	 * to change 'buttercream' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pinbin', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'main_nav' => __( 'Main Menu', 'pinbin' ),
		'manga-style' => 'Hover Menu'
	) );

	/**
	* Add support for editor style
	*/
	add_editor_style();

	/**
	 * Add support for custom backgrounds
	 */
	$args = array(
		'default-color' => '#ececec',
		//'default-image' => get_template_directory_uri() . '/images/wood.png',
	);

	$args = apply_filters( 'pinbin_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	}
	else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		//define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_theme_support( 'custom-background', $args );
	}
}
endif;
add_action( 'after_setup_theme', 'pinbin_setup' );

function pinbin_widgets_init() {
     //setup footer widget area
	register_sidebar(array(
    		'name' => 'Footer',
    		'id'   => 'pinbin_footer',
    		'description'   => 'Footer Widget Area',
    		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-copy">',
    		'after_widget'  => '</div></div>',
    		'before_title'  => '<h3>',
    		'after_title'   => '</h3>'
    	)
	);
}
add_action( 'widgets_init', 'pinbin_widgets_init' );

if (!is_admin())
	add_action( 'wp_enqueue_scripts', 'pinbin_scripts' );

function pinbin_scripts() {
	global $post;

	$pinbin_options = get_option('pinbin_theme_options');
	$timestamp = time();
	// cache busting variables for statics
	$cacheBusterCSS = date("mdHi", filemtime( get_stylesheet_directory()  . '/style.css'));
	$cacheBusterJS = date("mdHi", filemtime( get_stylesheet_directory()  . '/js/CFA_functions.js'));
	//echo 'TEST $cacheBusterJS: '.$cacheBusterJS.' | '.get_template_directory_uri() . '/js/CFA_functions.js';


	wp_enqueue_style( 'style', get_stylesheet_uri(), '', $cacheBusterCSS, 'all'  );
	wp_enqueue_style( 'Swiper', get_template_directory_uri() . '/js/swiper.min.css', '', '4.1.0', 'all'  );
	wp_enqueue_script( 'jquery' );


	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.97074.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'jquery-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'modernizr' ), null, true );
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'jquery-hoverdir', get_template_directory_uri() . '/js/jquery.hoverdir.js', array( 'jquery-isotope' ), null, true );
	wp_enqueue_script( 'jquery-infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery-hoverdir' ), null, true );
	//wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/jquery.colorbox-min.js', array( 'jquery-infinitescroll' ), null, true );
	// wp_enqueue_script( 'iOSslider', get_template_directory_uri() . '/js/jquery.iosslider.min.js', array( 'colorbox' ), null, true );
	wp_enqueue_script( 'Swiper', get_template_directory_uri() . '/js/swiper.min.js', array( 'jquery-hoverdir' ), null, true );
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'imagesloaded' ), null, true );

	wp_enqueue_script( 'pinbin.functions', get_template_directory_uri() . '/js/CFA_functions.js', array( 'imagesloaded' ), $cacheBusterJS, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * wp_title() Filter for better SEO.
 *
 * Adopted from Twenty Twelve
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 *
 */
if ( !function_exists('pinbin_wp_title') && !defined( 'AIOSEOP_VERSION' ) ) :

	function pinbin_wp_title( $title, $sep ) {
		global $page, $paged;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title .= " $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( __( 'Page %s', 'pinbin' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'pinbin_wp_title', 10, 2 );

endif;







/* limite a X parole */
function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

/* non voglio le thumbs nella gallery!! */
function CFA_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'li',
		'icontag'    => 'span',
		'captiontag' => 'h3',
		'columns'    => 1,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$icontag = tag_escape($icontag);
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'li';
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'span';
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'h3';

	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if ( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>

			#{$selector} {
				width: 100%;
				max-width: 640px;
				margin: 0 auto;
				padding: 0;
				list-style:none;
			}
			#{$selector} .gallery-item {
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				width: 100%;
				max-width: 640px;
				height: auto;
				margin: 0 auto;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div class='container'>\n
	<div class='swiper-container CFAslider' id='CFAslider'>\n
	<ul id='$selector' class='gallery slider swiper-wrapper galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>\n\n";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$image_output = "<img data-src=\"";
		$image_output .= wp_get_attachment_image_src( $id, $size, false )[0];
		$image_output .= "\" class=\"swiper-lazy\" />\n";
    $image_output .= "<div class=\"swiper-lazy-preloader\"></div>";

		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='swiper-slide gallery-item item'>";
		$output .= "$image_output\n";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>\n";
		}
		$output .= "</{$itemtag}>\n\n";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '';
	}
	$output .= "\n\n
		</ul>\n";

	$frecce='no';
	foreach ( $attachments as $id => $attachment ) {
		$i++;
		if ($i>2):
			$frecce='ok';
		endif;
	}
	if($frecce=='ok') :

		$output .= "\n
		<div class=\"swiper-pagination\"></div>\n
		</div>\n
		<div class=\"prevContainer\"></div>\n
		<div class=\"nextContainer\"></div>\n\n";

	else:

		$output .= "</div>\n\n";

	endif;



	return $output;
}

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'CFA_gallery_shortcode');

add_filter('show_admin_bar', '__return_false');



/*
Remove wp-caption inline style width in WordPress 3.4 and up
http://wp-snippets.com/remove-wp-caption-inline-style-width-in-wordpress-3-4-and-up/
*/
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
 if ( ! isset( $attr['caption'] ) ) {
 if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
 $content = $matches[1];
 $attr['caption'] = trim( $matches[2] );
 }
 }
 $output = apply_filters('img_caption_shortcode', '', $attr, $content);
 if ( $output != '' )
 return $output;
 extract(shortcode_atts(array(
 'id' => '',
 'align' => 'alignnone',
 'width' => '',
 'caption' => ''
 ), $attr));
 if ( 1 > (int) $width || empty($caption) )
 return $content;
 if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
 return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
 . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}


/*
tolto, ci pensa YOAST SEO
Facebook OG meta data:
http://wpsnipp.com/index.php/functions-php/facebook-open-graph-snippet-to-set-default-image/



function diww_facebook_image() {

  echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';
  global $post;
  setup_postdata( $post );
  if ( is_singular() ) { // only if a single post or page
	echo '<meta property="og:title" content="' . get_the_title() . '" />';
	echo '<meta property="og:description" content="' . get_the_excerpt() . '" />';
      echo '<meta property="og:type" content="article" />';
      echo '<meta property="og:url" content="' . get_permalink() . '" />';

     	$attachments = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));
    if (has_post_thumbnail( $post->ID )) { // use featured image if there is one
          $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
          echo '<meta property="og:image" content="' . esc_attr( $feat_image[0] ) . '" />';
     }
     else if($attachments){ // use site logo in case no featured image
	// if ( ! is_array($attachments) ) continue;
	$count = count($attachments);
	$first_attachment = array_shift($attachments);
          $feat_image = wp_get_attachment_image_src( $first_attachment->ID, 'large' );
          echo '<meta property="og:image" content="' . esc_attr( $feat_image[0] ) . '" />';
      } else {
          echo '<meta property="og:image" content="http://www.conceptualfinearts.it/cfa/wp-content/themes/CFA/screenshot.png" />';
     }
  }
  if ( is_home() ) { // for homepage only
  		echo '<meta property="og:title" content="' . get_bloginfo('name') . '" />';
  		echo '<meta property="og:description" content="' . get_bloginfo('description') . '" />';
          echo '<meta property="og:type" content="website" />';
          echo '<meta property="og:url" content="' . get_bloginfo('url') . '" />';
          echo '<meta property="og:image" content="http://www.conceptualfinearts.it/cfa/wp-content/themes/CFA/screenshot.png" />';
  }
}
add_action( 'wp_head', 'diww_facebook_image' );
*/





//////////////////////////////////////
//
//  v 1.5 additions starting here
//
//////////////////////////////////////


class CSS_Menu_Maker_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    /*$indent = str_repeat("\t", $depth);
    $output .= "\n$indent<dt class=\"sub-menu\">\n";*/
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    /*$indent = str_repeat("\t", $depth);
    $output .= "$indent</dt>\n";*/
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }

    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<dd' . $id . $value . $class_names .'>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</dd>\n";
  }
}



//////////////////////////////////////
//
//  v 1.6 post type for CFA Authors
//
//////////////////////////////////////


// Register Custom Post Type
function CFA_custom_post_type() {

	$labels = array(
		'name'                => _x( 'CFA Authors', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'CFA Author', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'CFA Authors', 'text_domain' ),
		'name_admin_bar'      => __( 'CFA Authors', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'CFA Author', 'text_domain' ),
		'description'         => __( 'CFA Authors', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-businessman',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'cfa_authors', $args );

}
add_action( 'init', 'CFA_custom_post_type', 0 );

//////////////////////////////////////
//
// 26 jan 2016
// restore 'get shortlink button':
// http://wptavern.com/how-to-restore-the-get-shortlink-button-in-wordpress-4-4
//
//////////////////////////////////////
add_filter( 'get_shortlink', function( $shortlink ) {return $shortlink;} );

//////////////////////////////////////
//
// 27 jan 2016
// add real author, not WP author
// in Admin Post List
//
//////////////////////////////////////

//Add custom column
add_filter('manage_edit-post_columns', 'real_auth_head');
function real_auth_head($defaults) {
	$defaults['autore'] = __('Author');
	return $defaults;
}
//Add rows data
add_action( 'manage_post_posts_custom_column' , 'real_auth_column', 10, 2 );
function real_auth_column($column, $post_id ){
	switch ( $column ) {
		case 'autore':
		echo get_post_meta( $post_id , 'author_name' , true );
		break;
	}
}
// order appearance
function set_columns_order($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'autore' =>__('Author'),
        'categories' =>__('Categories'),
        'tags' =>__('Tags'),
        'date' => __('Date'),
        'gadwp_stats' => __('Analytics')
    );
}
add_filter('manage_post_posts_columns' , 'set_columns_order');

// icomoon font
wp_enqueue_style( 'icomoon-cfa', get_template_directory_uri() . "/font.css", false, '1.0' );
// print style
wp_enqueue_style( 'print', get_template_directory_uri() . "/print.css", 'style-css', '1.0', 'print' );

add_filter('xmlrpc_enabled', '__return_false');


// GESTIONE IMMAGINI RESPONSIVE (WP 4.4+)
// https://www.smashingmagazine.com/2015/12/responsive-images-in-wordpress-core/
function adjust_image_sizes_attr( $sizes, $size ) {
   $sizes = '(min-width: 1280px) 640px, (min-width: 768px) 320px, (min-width: 480px) 640px, 320px';
   //var_dump($sizes);
   return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'adjust_image_sizes_attr', 10 , 2 );

// Remove query strings from static resources
// https://www.sourcewp.com/remove-query-strings-static-resources/
/*
function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
*/

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// MAILPOET STUFF (newsletter)
function mpoet_get_undo_unsubscribe(){
	if(class_exists('WYSIJA') && !empty($_REQUEST['wysija-key'])){
		$undo_paramsurl = array(
		 'wysija-page'=>1,
		 'controller'=>'confirm',
		 'action'=>'undounsubscribe',
		 'wysija-key'=>$_REQUEST['wysija-key']
	 	);

		$model_config = WYSIJA::get('config','model');
        	$link_undo_unsubscribe = WYSIJA::get_permalink($model_config->getValue('confirmation_page'),$undo_paramsurl);
		$undo_unsubscribe = str_replace(array('[link]','[/link]'), array('<a href="'.$link_undo_unsubscribe.'">','</a>'),'<strong>'.__('You made a mistake? [link]Undo unsubscribe[/link].',WYSIJA)).'</strong>';
		return $undo_unsubscribe;
	 }
	return '';
}

add_shortcode('mailpoet_undo_unsubscribe', 'mpoet_get_undo_unsubscribe');
