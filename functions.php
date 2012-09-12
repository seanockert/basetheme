<?php
/**
* Hide the Toolbar if not in the admin section
*/
if (!is_admin()) show_admin_bar(false);

/**
* In the admin section add extra settings for this theme
*/
if (is_admin()) include_once("includes/theme-config.php");

/**
* Custome logo for the admin login
*/
add_action("login_head", "custom_login_logo");
function custom_login_logo() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('".get_bloginfo('template_url')."/img/login-header.png') no-repeat center top transparent;
		height: 67px;
		width: 326px;
		background-size:274px 63px;
	}
	</style>;
	";
}

/**
* Use the theme-enqueue file to bootstrap the CSS and JS
*/
include_once("includes/theme-enqueue.php");

/**
* Use the theme-enqueue file to bootstrap the CSS and JS
*/
function show_posts_nav() {
   global $wp_query;
   return ($wp_query->max_num_pages > 1);
}

/**
* Add theme sidebars - can be removed if not using widgets
*/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
	  	'name' => __( 'Primary Widget Area' ),
		'id' => 'primary-widget-area',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget_title">',
        'after_title' => '</h3>',
	));
}

/**
* Add a custom post type called Products
*/
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'products',
		array(
			'labels' => array(
				'name' => __( 'Products' ),
				'singular_name' => __( 'Product' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}

/**
* Add theme support and define the custom thumbnail sizes that you need here - ( $name, $width, $height, $crop )
*/
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'nav-menus' );
	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
	add_image_size( 'gallery-thumbnail', 160, 200, true); // Permalink thumbnail size
}

/**
* Set 'Primary Navigation' as the top main menu
*/
register_nav_menus( array(
	'primary' => __( 'Primary Navigation' ),
) );

/**
* Actions + Filters - remove a lot of the unneccesary stuff in the head
*/
// Remove links to the extra feeds (e.g. category feeds)
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Remove links to the general feeds (e.g. posts and comments)
remove_action( 'wp_head', 'feed_links', 2 );
// Remove link to the RSD service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );
// Remove link to the Windows Live Writer manifest file
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove index link
remove_action( 'wp_head', 'index_rel_link' );
// Remove prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// Remove start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// Display relational links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
// Remove XHTML generator showing WP version
remove_action( 'wp_head', 'wp_generator' );
remove_action('wp_head', 'rel_canonical');

add_filter( 'previous_post_rel_link', 'disable_stuff' );
add_filter( 'next_post_rel_link', 'disable_stuff' );

// Remove CSS added from the Recent Comments widget
function roots_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}
add_action('wp_head', 'roots_remove_recent_comments_style', 1);

// Remove CSS added from galleries
function roots_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}
add_filter('gallery_style', 'roots_gallery_style');


/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function roots_root_relative_url($input) {
  $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
      '$matches',
      // If full URL is home_url("/"), return a slash for relative root
      'if (isset($matches[0]) && $matches[0] === home_url("/")) { return "/";' .
      // If domain is equal to home_url("/"), then make URL relative
      '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
      // If domain is not equal to home_url("/"), do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );

  return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function roots_fix_duplicate_subfolder_urls($input) {
  $output = roots_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }

  return $output;
}

if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
  add_filter('bloginfo_url', 'roots_root_relative_url');
  add_filter('theme_root_uri', 'roots_root_relative_url');
  add_filter('stylesheet_directory_uri', 'roots_root_relative_url');
  add_filter('template_directory_uri', 'roots_root_relative_url');
  add_filter('script_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'roots_root_relative_url');
  add_filter('the_permalink', 'roots_root_relative_url');
  add_filter('wp_list_pages', 'roots_root_relative_url');
  add_filter('wp_list_categories', 'roots_root_relative_url');
  add_filter('wp_nav_menu', 'roots_root_relative_url');
  add_filter('the_content_more_link', 'roots_root_relative_url');
  add_filter('the_tags', 'roots_root_relative_url');
  add_filter('get_pagenum_link', 'roots_root_relative_url');
  add_filter('get_comment_link', 'roots_root_relative_url');
  add_filter('month_link', 'roots_root_relative_url');
  add_filter('day_link', 'roots_root_relative_url');
  add_filter('year_link', 'roots_root_relative_url');
  add_filter('tag_link', 'roots_root_relative_url');
  add_filter('the_author_posts_link', 'roots_root_relative_url');
}
/**
 * End Root relative URLs
 */







/**
* Custom excerpt, use custom_excerpt instead of regular one 
*/
function custom_excerpt($text) {
	return str_replace('[...]', ' <a href="'. get_permalink($post->ID) . '" class="more">' . 'More&nbsp;&raquo;' . '</a>', $text);
}
add_filter('the_excerpt', 'custom_excerpt');

/**
* Allow HTML in descriptions
*/
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
	remove_filter($filter, 'wp_filter_kses');
}


/**
* Use sidebar_blog to replace sidebar for different sections
*/
function get_sidebar_blog( $name = null ) {
	do_action( 'get_sidebar' );
	$templates = array();
	if ( isset($name) )
		$templates[] = "sidebar-{$name}.php";
	$templates[] = "sidebar_blog.php";
	if ('' == locate_template($templates, true))
		load_template( get_theme_root() . '/theme/sidebar.php');
}


/**
* Use loop_search to replace loop for in the search page
*/
function get_loop_search( $name = null ) {
	do_action( 'get_loop_search' );
	$templates = array();
	if ( isset($name) )
		$templates[] = "loop-{$name}.php";
	$templates[] = "loop_search.php";
	if ('' == locate_template($templates, true))
		load_template( get_theme_root() . '/theme/loop.php');
}





/**
* Comment formatting
*/
function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
   	<li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
    <?php
}



/**
* Custom gallery shortcode for gallery pages TODO: Improve this
*/
add_shortcode('gallery_custom', 'custom_gallery_shortcode');

function custom_gallery_shortcode($attr) {
	global $post, $wp_locale;
	static $instance = 0;
	$instance++;

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
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'captiontag' => 'span',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
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
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$output = apply_filters('gallery_style', "
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div class='slideshow'>
		<ul id='$selector' class='gallery galleryid-{$id}'>"); // or ul

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false, false, 'gallery') : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag}>";
		$output .= "$link";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
			$output .= "<img class='gallery-caption' src='/expand.png' alt='' title='Click photo to view larger' />";
				
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
			</ul>
		</div>\n";

	return $output;
}


/**
* Related to Custom gallery shortcode for image listing pages
*/
function gal_get_images($postID) {
	$attachments = get_children(array('post_parent' => $postID,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'numberposts' => 6,
		'order' => 'ASC',
		'orderby' => 'menu_order ID'));

	foreach($attachments as $att_id => $attachment) {
	   echo '<li><a href="'.wp_get_attachment_url($attachment->ID).'" title="View fullsize image" class="fancybox">'.wp_get_attachment_image($attachment->ID, $size='gallery-thumbnail').'</a></li>';
	}
}



// Reduce nav classes, leaving only 'current-menu-item'
function nav_class_filter( $var ) {
	return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
}
add_filter('nav_menu_css_class', 'nav_class_filter', 100, 1);

// Add page slug as nav IDs
function nav_id_filter( $id, $item ) {
	return 'nav-'.cleanname($item->title);
}
add_filter( 'nav_menu_item_id', 'nav_id_filter', 10, 2 );


function cleanname($v) {
	$v = preg_replace('/[^a-zA-Z0-9s]/', '', $v);
	$v = str_replace(' ', '-', $v);
	$v = strtolower($v);
	return $v;
}