<?php

define( 'THEME_VERSION', 1.0 );

define( 'THEME_DIR_PATH', get_template_directory() );

/*-----------------------------------------------------------------------------------*/
/* Includes
/*-----------------------------------------------------------------------------------*/

require THEME_DIR_PATH . '/includes/restone-functions.php';
require THEME_DIR_PATH . '/includes/custom-metaboxes.php';

/*
 * "Thorough cleaning and disinfection of areas such as" widget
 */
require_once THEME_DIR_PATH . '/includes/widgets/class-r1-thorough-area-cleaning-and-disinfection-widget.php';

/**
 * Theme setup.
 */
function theme_setup() {

	/*-----------------------------------------------------------------------------------*/
	/* Theme support
	/*-----------------------------------------------------------------------------------*/

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_filter('widget_text','do_shortcode');
	add_editor_style();

	/*-----------------------------------------------------------------------------------*/
	/* Change Uploads Path for images
	/*-----------------------------------------------------------------------------------*/

	update_option( 'upload_path', 'images', true );

	/*-----------------------------------------------------------------------------------*/
	/* Support thumbnails
	/*-----------------------------------------------------------------------------------*/

	add_theme_support( 'post-thumbnails' );

	// Custom Thumbnail
	// add_image_size( 'imagen-destacada', 800, 500, true );

	/*-----------------------------------------------------------------------------------*/
	/* Register main menu for Wordpress use
	/*-----------------------------------------------------------------------------------*/

	register_nav_menus(
		array(
			'primary'	=>	'Primary Menu',
			'services-menu'	=>	'Services Menu',
		)
	);

}

add_action( 'after_setup_theme', 'theme_setup' );

/*-----------------------------------------------------------------------------------*/
/* Custom Admins Styles
/*-----------------------------------------------------------------------------------*/

function load_admin_style() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function theme_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar-main',
		'name' => 'Sidebar Main Site',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'empty_title'=> '',
	));
	register_sidebar(array(
		'id' => 'sidebar-locations',
		'name' => 'Sidebar Locations',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<span>',
		'after_title' => '</span>',
	));
	register_sidebar(array(
		'id' => 'sidebar-keep-it-clean',
		'name' => 'Sidebar For Keep It Clean Pages',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<span style="display: none;">',
		'after_title' => '</span>',
	));
}
add_action( 'widgets_init', 'theme_register_sidebars' );

/*-----------------------------------------------------------------------------------*/
/* SEARCH HTML5
/*-----------------------------------------------------------------------------------*/

function wpdocs_after_setup_theme() {
	add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function theme_scripts()  {

	$version = '20191005';
	
	$template_dir_url = get_template_directory_uri();
	
	$template_dir_path = get_template_directory() . '/';

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style( 'theme-style', get_stylesheet_uri(), false, $version );
	wp_enqueue_style( 'theme-boostrap', $template_dir_url . '/css/bootstrap.min.css', 'theme', $version );
	wp_enqueue_style( 'theme-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', 'theme', $version );
	wp_enqueue_style( 'theme-owl', $template_dir_url . '/css/owl.carousel.min.css', 'theme', $version );
	wp_enqueue_style( 'theme-fancybox', $template_dir_url . '/css/jquery.fancybox.min.css', 'theme', $version );
	wp_enqueue_style( 'theme-font-icons', $template_dir_url . '/css/font-icons.css', 'theme', $version );
	wp_enqueue_style( 'theme-main', $template_dir_url . '/css/main.css?v=2', 'theme', filemtime( $template_dir_path . 'css/main.css' ) );
	
	// Load this css on location landing pages only
	if (is_page_template( array('page-templates/location-landing.php', 'page-templates/location.php'))) :  
		wp_enqueue_style( 'location-landing-page', $template_dir_url . '/css/location-page.css', 'theme', $version );
	endif;

	// add theme scripts
	wp_enqueue_script( 'theme-modernizr', $template_dir_url . '/js/modernizr-2.8.3.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-cookie', $template_dir_url . '/js/js.cookie.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-boostrap', $template_dir_url . '/js/bootstrap.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-fitvids', $template_dir_url . '/js/jquery.fitvids.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-owl', $template_dir_url . '/js/owl.carousel.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-fancybox', $template_dir_url . '/js/jquery.fancybox.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-scrolltofixed', $template_dir_url . '/js/jquery.scrolltofixed.min.js', array('jquery'), $version, true );
	wp_enqueue_script( 'theme-main', $template_dir_url . '/js/main.js', array('jquery'), $version, true );
	
	// Keep It Clean Page - https://www.restoration1.com/keep-it-clean
	if ( is_page( 26592 ) ) {
		wp_enqueue_script( 'keep-it-clean-page-script', $template_dir_url . '/js/keep-it-clean-page.js', array('jquery'), filemtime( $template_dir_path . 'js/keep-it-clean-page.js' ), true );
	}

}
add_action( 'wp_enqueue_scripts', 'theme_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header

/*-----------------------------------------------------------------------------------*/
/* New Excerpt
/*-----------------------------------------------------------------------------------*/

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

// LIMIT EXCERPT

function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*-----------------------------------------------------------------------------------*/
/* Shortcodes
/*-----------------------------------------------------------------------------------*/

// Button
// [button class="btn" href="link" target="_self"]Download Button[/button]

if(!function_exists('shortcode_button')){
	function shortcode_button($atts, $content = null){
		$content = trim(do_shortcode(shortcode_unautop($content)));
		extract(shortcode_atts(array("href" => 'http://', "class" =>'btn', "target" => '_self'), $atts));
		return '<a class="btn '.$class.'" href="'.$href.'" target="'.$target.'"><span>'.$content.'</span></a>';
	}
}
add_shortcode('button', 'shortcode_button');

// DIV SHORTCODE
// [div id="example" class="example"][end-div]

add_shortcode('div', 'be_div_shortcode');
// [div id="example" class="example"][end-div]
function be_div_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'class' => '',
		'id'    => '',
	), $atts, 'div-shortcode' );
	$return = '<div';
	if ( !empty( $atts['class'] ) )
	$return .= ' class="'. esc_attr( $atts['class'] ) .'"';
	if ( !empty( $atts['id'] ) )
	$return .= ' id="'. esc_attr( $atts['id'] ) .'"';
	$return .= '>';
	return $return;
}
add_shortcode( 'div', 'be_div_shortcode' );
function be_end_div_shortcode( $atts ) {
	return '</div>';
}
add_shortcode( 'end-div', 'be_end_div_shortcode' );

//// AMP Customizations

// Add Fav Icon to AMP Pages
add_action('amp_post_template_head','amp_favicon');
function amp_favicon() { ?>
	<link rel="icon" href="<?php echo get_site_icon_url(); ?>" />
<?php } 

// Add Banner below content of AMP Pages
add_action('ampforwp_after_post_content','amp_custom_banner_extension_insert_banner');
function amp_custom_banner_extension_insert_banner() { ?>
	<div class="amp-custom-banner-after-post">
		<h2>IF YOU HAVE ANY QUESTIONS, PLEASE DO NOT HESITATE TO CONTACT US</h2>
		<a class="ampforwp-comment-button" href="/contact-us/">
			CONTACT US
		</a>
	</div>
<?php }

//// REMOVE RELATED VIDEOS YOUTUBE OEMBED
function iweb_modest_youtube_player( $html, $url, $args ) {
	return str_replace( '?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&rel=0', $html );
}
add_filter( 'oembed_result', 'iweb_modest_youtube_player', 10, 3 );

/// IS BLOG
function is_blog() {
	global  $post;
	$posttype = get_post_type( $post );
	return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) && ( $posttype == 'post' )  ) ? true : false;
}

/// IS TREE
function is_tree($pid){
	global $post;
	if ( is_page($pid))
	return TRUE;
	$anc = get_post_ancestors( $post->ID );
	foreach ( $anc as $ancestor ) {
		if( is_page() && $ancestor == $pid ) {
			return TRUE;
		}
	}
	return FALSE;
}


if(!function_exists('shortcode_button')){
	function shortcode_button($atts, $content = null){
		$content = trim(do_shortcode(shortcode_unautop($content)));
		extract(shortcode_atts(array("href" => 'http://', "class" =>'btn', "target" => '_self'), $atts));
		return '<a class="btn '.$class.'" href="'.$href.'" target="'.$target.'"><span>'.$content.'</span></a>';
	}
}
add_shortcode('button', 'shortcode_button');


if(!function_exists('blackbox_service')){
	function blackbox_service($atts, $content = null){
		$content = trim(do_shortcode(shortcode_unautop($content)));
		extract(shortcode_atts(array('service' => 'water-damage'), $atts));
		$entries = get_post_meta( 2, 'cmb_home_main_section_one_item', true );
		$iconService = wp_get_attachment_image( get_post_meta( get_the_ID(), 'cmb_banner_icon_page_id', 1 ), 'full' );
		// $entries[$service]['title'];
	?>
		<div class="item blackbox-service">
			<a href="<?php echo esc_html( $entries[$service]["url"] ); ?>" class="inner">
				<div class="icon">
					<?php
						if (!empty($iconService)){
							echo $iconService;
						}else{
							echo wp_get_attachment_image($entries[$service]["img_id"], "full" );
						}
					?>
				</div>
				<div class="title">
					<?php the_title(); ?>
				</div>
				<div class="description">
					<?php echo esc_html( $entries[$service]["description"] ); ?>
				</div>
				<div class="images">
					<?php echo wp_get_attachment_image($entries[$service]["imgs_id"], "full" ); ?>
				</div>
				<div class="link-text">
					<?php echo esc_html( $entries[$service]["text-link"] ); ?>
				</div>
			</a>
		</div>
	<?php
	}
}
add_shortcode('blackbox_service', 'blackbox_service');


if(!function_exists('blackbox_other_services')){
	function blackbox_other_services($atts, $content = null){
		$iconService = wp_get_attachment_image( get_post_meta( get_the_ID(), 'cmb_banner_icon_page_id', 1 ), 'full' );
	?>
		<div class="item blackbox-service">
			<a href="<?php echo esc_html( $entries[$service]["url"] ); ?>" class="inner">
				<div class="icon">
					<?php
						if (!empty($iconService)){
							echo $iconService;
						}
					?>
				</div>
				<div class="title">
					<?php the_title(); ?>
				</div>
				<div class="description">
					Additional property restoration services are now available from the experts at a Restoration 1 location near you.
				</div>
				<div class="images">
					<img src="<?php bloginfo('template_directory'); ?>/images/img-other-services.png" alt="Other services">
				</div>
				<div class="link-text">
					See services
				</div>
			</a>
		</div>
	<?php
	}
}
add_shortcode('blackbox_other_services', 'blackbox_other_services');

//// CORP BLOG IN BLOG PAGE
function my_home_category( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$query->set( 'cat', '1');
	}
}
add_action( 'pre_get_posts', 'my_home_category' );


//// ADD LOCATION FROM STORE LOCATOR
function get_info_location() {
	if ( isset($_REQUEST) ) {
		$post_id = $_REQUEST['phone'];
		global $wpdb;
		$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'cmb_home_location_phone' AND  meta_value = '$post_id' LIMIT 1", ARRAY_A);
		echo $posts[0]['post_id'];
	}
	die();
}
add_action( 'wp_ajax_get_info_location', 'get_info_location' );
add_action( 'wp_ajax_nopriv_get_info_location', 'get_info_location' );



add_action('wp', 'remove_canonical');
function remove_canonical() {
	if (is_page(171)):
		add_filter( 'wpseo_canonical', '__return_false' );
		remove_action( 'wp_head', '_wp_render_title_tag', 1 );
	endif;
}

add_action( 'wp', 'r1_check_location_cookie', 10 );
/**
 * If we're on a post/page and it or its ancestor is not a location page, delete the "location" cookie.
 * Example of a location page: restoration.com/austin/
 */
function r1_check_location_cookie() {
	/* 
	 * REMOVE "location" cookie if we're NOT on one of the pages belonging to a location
	 * This fixes the following issue:
	 * If you've visited a page belonging to a location e.g. /austin/ or /austin/why-choose-us/testimonials/, 
	 * then when you're on a non location page, e.g. the homepage or the main site's equivalent of the testimonials page (/why-choose-us/testimonials/)
	 * the location cookie will still exist, and it will take you to Austin's testimonials page (if you clicked the Reviews link at the top right of the page)
	 */
	if ( ! empty( $_COOKIE['location'] && ( is_page() || is_single() ) ) ) {
		$current_post_ancestor_id = (string) idLocation();
		if ( $current_post_ancestor_id !== $_COOKIE['location'] ) {
			unset( $_COOKIE['location'] );
			setcookie('location', '', time() - 3600, '/' );
		}
	}
}

/*Rewrite Rule*/
add_filter('query_vars', 'add_account_edit_var', 0, 1);
function add_account_edit_var($vars){
    $vars[] = 'city';
    $vars[] = 'zip';
    $vars[] = 'detail';
    return $vars;
}

add_action( 'init', 'add_account_edit_rule' );
function add_account_edit_rule() {
    add_rewrite_rule(
        '^find-my-location/([^/]*)/([^/]*)/([^/]*)/?',
        'index.php?pagename=find-my-location&city&zip&detail',
        'top'
    );
}

add_rewrite_rule(
    '^find-my-location/([^/]*)/?',
    'index.php?pagename=find-my-location&city=$matches[1]&zip=$matches[2]&detail=$matches[3]',
    'top'
);

#region careers_form
if(!function_exists('careers_locations')){
	function careers_locations($atts, $content = null){
		$locations = get_pages(
			array(
				'sort_order'		=>	'ASC',
				'sort_column'		=>	'post_title',
				'post_type'			=>	'page',
				'post_status'		=>	'publish',
				'meta_key'			=>	'cmb_home_location_email',
			)
		);
		$output = '<select name="careers-locations" class="form-control"><option value="0">---</option>';
		foreach ( $locations as $page ) {
			$output .= '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
		}
		$output .= '</select>';

		return $output;
	}
}
add_shortcode('careers_locations', 'careers_locations');

function wpcf7_param_change_before_send( $contact_form ) {
	if ( $contact_form->id() == 10950 ) {
		$email = get_post_meta( $_POST[ 'careers-locations' ], 'cmb_home_location_email', true );
		if ( $_POST[ 'careers-locations' ] == 0 ) { $email = 'careers@restoration1.com'; }
		if( !empty( $email ) ) {
			$mail = $contact_form->prop( 'mail' );
			$mail[ ‘recipient’ ] = $mail[ ‘recipient’ ] . ', ' . $email;
			$contact_form->set_properties( array( 'mail' => $mail ));
		}
	}
}
add_action( 'wpcf7_before_send_mail', 'wpcf7_param_change_before_send');

function mycustom_wpcf7_form_elements( $form ) {
	$form = do_shortcode( $form );
	return $form;
}
add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
#endregion

#region cf7_redirects
add_action( 'wp_footer', 'redirect_cf7' );
function redirect_cf7() {
	?>
		<script type="text/javascript">
			document.addEventListener( 'wpcf7mailsent', function( event ) {
				if ( '12440' == event.detail.contactFormId ) {
					window.open( 'https://www.restoration1.com/pdf/Restoration1_Hurricane-Preparedness_Guide_Download.pdf', '_blank' ).focus();
				}
				if ( '1507' == event.detail.contactFormId ) {
					window.open( '<?php getPermalinkLocation(); ?>/thank-you', '_self' );
				}
			}, false );
			console.log('<?= idLocation(); ?>');
		</script>
	<?php
}
#endregion

#region GMB reviews button
function gmb_review_button_shortcode( $atts = array() ) {
	$att = shortcode_atts( array(
		'link'		=>	'/',
		'text'		=>  'Leave Us a Review',
	), $atts );

	$output = '<a class="btn btn-orange" href="' . $att['link'] . '" target="_blank">' . $att['text'] . '</a>';

	return $output;
}
add_shortcode('gmb_review_button', 'gmb_review_button_shortcode');
#endregion

#region Utils
function the_slug() {
	$post_data = get_post($post->ID, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug; 
}
#endregion

// Landing Page Header - Zip code or Phone number option
function switchToPhone() {
	 $phonenumber = get_field('select_to_enable_phone_number', $locationpageid);
	 if( $phonenumber && in_array('enablephone', $phonenumber) ) {   
		get_template_part( 'template-parts/phone-location', 'none');
	 } else {
		 get_template_part( 'template-parts/search-location', 'none' );
	 }
}

// Landing Page (Restoration Services) - Zip code or Phone number option
function phone_or_zipcode_services() {	
	 $phonenumber = get_field('select_to_enable_phone_number', $locationpageid);	 
	 if( ($phonenumber && in_array('enablephone', $phonenumber)) && !in_array('enablezipcodeinservices', $phonenumber)  ) {
		 
	 ob_start();
	 phoneLocation();
	 $myrestortionphonenumber = ob_get_contents();
	 ob_end_clean();  
	 
	 $restorationservice = '<div class="fl-module-heading call-free-estimate"><h4 class="fl-heading"><span class="fl-heading-text">Call for a FREE ESTIMATE</span></h4></div><div class="fl-module fl-module-pp-smart-button call-free-number"><div class="pp-button-wrap pp-button-width-auto pp-button-has-icon">'. $myrestortionphonenumber .'</div></div>';
	 
	 return $restorationservice;
	 	
	 } elseif (  $phonenumber && in_array('enablezipcodeinservices', $phonenumber) ) {
		return'<div class="form-inner">
			<div class="call-free-estimate"><h4><span>Enter Your Zip Code to Find an Expert Near You</span></h4></div>
			<form action="'. home_url( '/find-my-location' ) .'" class="form-inline" method="post">
				<div class="form-group">
					<label for="zipCode" class="sr-only">Zip Code</label>
					<input style="padding: 21px 10px; margin-top: 15px;" type="text" name="zipCode" class="form-control" placeholder="Zip Code" required="true" />
				</div>
				<button style="margin-top: 15px;" class="btn btn-orange" type="submit" name="button">SEARCH</button>
			</form>
		</div>';
	 }
}
add_shortcode('phonenumber', 'phone_or_zipcode_services');

// Landing Page (Free Response Time) - Zip code or Phone number option
function phone_or_zipcode_free_response() {	
	 $phonenumber = get_field('select_to_enable_phone_number', $locationpageid);	 
	 if( ($phonenumber && in_array('enablephone', $phonenumber)) && !in_array('enablezipcodeinfastresponse', $phonenumber)  ) {  
	 
	  ob_start();
	  phoneLocation();
	  $myfastphonenumber = ob_get_contents();
	  ob_end_clean();
	 
	 $fastresponsehtml = '<div class="fl-module fl-module-heading free-response-heading"><div class="fl-module-content" style="margin: 0px 0px 20px 0px;"><h2 class="fl-heading"><span class="fl-heading-text">Fast Response Time - Local &amp; Professional OPEN 24/7, CALL NOW!</span></h2></div></div><div class="fl-button-wrap fl-button-width-auto fl-button-left free-response-button" style="text-align: left;">'. $myfastphonenumber .'</div>';
	 
	 return $fastresponsehtml;
	 
	 } elseif (  $phonenumber && in_array('enablezipcodeinfastresponse', $phonenumber) ) {
		return'<div class="form-inner">
						<div class="call-free-response"><h4><span>Enter Your Zip Code to Find an Expert Near You</span></h4></div>
						<form action="'. home_url( '/find-my-location' ) .'" class="form-inline" method="post">
							<div class="form-group">
								<label for="zipCode" class="sr-only">Zip Code</label>
								<input style="padding: 21px 10px; margin-top: 15px;" type="text" name="zipCode" class="form-control" placeholder="Zip Code" required="true" />
							</div>
							<button style="margin-top: 15px;" class="btn btn-orange" type="submit" name="button">SEARCH</button>
						</form>
					</div>';
	 }
}
add_shortcode('freeresponse', 'phone_or_zipcode_free_response');

function gravity_forms_tracking_scripts() {
	$stylesheet_dir_path = get_stylesheet_directory() . '/';
	wp_enqueue_script( 'gravity-forms-tracking-scripts', get_template_directory_uri() . '/js/gravity-forms-zapier-scripts.js', array( 'jquery' ), filemtime( $stylesheet_dir_path . 'js/gravity-forms-zapier-scripts.js' ) );
}
add_action( 'wp_enqueue_scripts', 'gravity_forms_tracking_scripts' );

add_filter( 'wp_get_nav_menu_items', 'r1_remove_faqs_and_locations_items_from_location_menus', 10, 2 );
/**
 * Remove "FAQ’s" & "Locations" from the menus of all location pages and their children pages.
 * @param array  $items An array of menu item post objects.
 * @param object $menu  The menu object.
 * @return array|false $items
 */
function r1_remove_faqs_and_locations_items_from_location_menus( $items, $menu ) {

	$menu_location = get_post_meta( getIdFromCookie(), 'cmb_home_location_nav_menu', true );

	if ( empty( $menu_location ) ) {
		return $items;
	}

	if ( ! ( isset( $menu->term_id ) && $menu_location === strval( $menu->term_id ) ) ) {
		return $items;
	}
	
	foreach ( $items as $key => $item ) {
		if ( empty( $item->title ) ) {
			continue;
		}
		if ( "FAQ’s" === $item->title || 'Locations' === $item->title ) {
			unset( $items[ $key ] );
		}
	}

	return $items;
}


add_filter( 'wp_nav_menu_items', 'r1_add_keep_it_clean_item_to_location_menus', 20, 2 );
/**
 * Add "Keep it Clean Program" item to the menu of all location pages and their children pages.
 * @param string $items
 * @param array $args
 * @return string
 */
function r1_add_keep_it_clean_item_to_location_menus( $items, $args ) {

	// See "menuLocation()" function
	$menu_location = get_post_meta( getIdFromCookie(), 'cmb_home_location_nav_menu', true );
	
	if ( empty( $menu_location ) ) {
		return $items;
	}
	
	if ( ! ( isset( $args->menu ) && $menu_location === $args->menu ) ) {
		return $items;
	}
		
	$items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-keep-it-clean-program"><a href="'. get_permalink( 26592 ) .'">Keep it Clean Program</a></li>';
	
	return $items;
}

//add_filter( 'get_post_metadata', 'r1_override_phone_number_for_myrtle_beach', 999, 3 ); //Commented on 15 JAN 2021 to fix the blank page and 502 errors
/**
 * Override the Phone Number (CMB2 plugin key "cmb_home_location_phone"), for https://www.restoration1.com/horry-county/myrtle-beach
 *
 * @param null|array|string $value     The value get_metadata() should return - a single metadata value,
 *                                     or an array of values.
 * @param int               $object_id ID of the object metadata is for.
 * @param string            $meta_key  Metadata key.
 * @return mixed
 */
function r1_override_phone_number_for_specific_pages( $value, $object_id, $meta_key ) {

	if ( 'cmb_home_location_phone' !== $meta_key ) {
		return $value;
	}

	// We check if the meta ID is the ID of the parent page, because the ID used to fetch this meta data is from a cookie
	// which will always be the parent page ID.
	if ( 20085 === $object_id && is_page( 1783 ) ) {
		return '(843) 350-1266';
	}

	return $value;
}

add_filter( 'gform_field_validation_309', 'r1_free_estimate_form_zip_code_validation', 10, 4 );
/**
 * Add validation to the "Free Estimate" (ID 209) form's Zip Code field, as Gravity Forms does not do this by default,
 * allowing values like "no" through.
 *
 * This requires a value to be provided in one of the following formats:
 * 1/ 12345
 * 2/ 123456789
 * 3/ 12345 6789 (with space)
 * 4/ 12345-6789
 *
 * @see https://en.wikipedia.org/wiki/List_of_postal_codes -> United States, and other territories for their Zip Code
 * requirements.
 *
 * @param array $result
 * @param array $value
 * @param object $form Unused
 * @param object $field
 * @return mixed
 */
function r1_free_estimate_form_zip_code_validation( $result, $value, $form, $field ) {

	if ( empty( $field->type ) ) {
		return $result;
	}

	if ( empty( $result['is_valid'] ) ) {
		return $result;
	}

	if ( empty( $field->id ) ) {
		return $result;
	}

	if ( 'address' === $field->type && $result['is_valid'] ) {

		$zip_code = rgar( $value, $field->id . '.5' );

		if ( 1 !== preg_match( '#^\d{5}(?:([-\s]*)\d{4})?$#', $zip_code ) ) {
			$result['is_valid'] = false;
			$result['message'] = 'Please provide a Zip Code with at least 5 digits, and up to 9 digits. Examples: 12345, 123456789, 12345 6789 (with space), or 12345-6789.';
		}
	}

	return $result;
} 
//Creating Menu Locations - Begins
function thrive_menus() {
register_nav_menus(
	array(
	 'footerMenu' => __( 'Footer Menu' ), 
	 'footerMenuBottomBar' => __( 'Footer Menu Bottom Bar' )
	)
);
}
add_action( 'init', 'thrive_menus' );
//Creating Menu Locations - Ends
//Adding Custom Thumbnail size - Begins
add_image_size( 'homePosts', 287, 191, true  );
add_image_size( 'blogPostsPageThumb', 350, 240, false  );
//Adding Custom Thumbnail size - Ends

//Breadcrumbs - Begins
function get_hansel_and_gretel_breadcrumbs() {
    // Set variables for later use
    $here_text        = __( '' );
    $home_link        = home_url('/');
    $home_text        = __( 'Home' );
    $link_before      = '<span typeof="v:Breadcrumb">';
    $link_after       = '</span>';
    $link_attr        = ' rel="v:url" property="v:title"';
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = '  ';              // Delimiter between crumbs
    $before           = '<span class="current">'; // Tag before the current crumb
    $after            = '</span>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';

    /** 
     * Set our own $wp_the_query variable. Do not use the global variable version due to 
     * reliability
     */
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if ( is_singular() ) 
    {
        /** 
         * Set our own $post variable. Do not use the global variable version due to 
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post( $queried_object );

        // Set variables 
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';

        if ( 'post' === $post_type ) 
        {
            // Get the post categories
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                // Lets grab the first category
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }

        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->singular_name );
        }

        // Get post parents if $parent !== 0
        if ( 0 !== $parent ) 
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );

                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse( $parent_links );

            $parent_string = implode( $delimiter, $parent_links );
        }

        // Lets build the breadcrumb trail
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            // Set the variables for this section
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . '<a href="/blog/"> Blog </a>' . $taxonomy_object->labels->singular_name . ': ' . $term_name . $after;
            $parent_term_string = '';

            if ( 0 !== $term_parent )
            {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }

                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
            }

            if ( $parent_term_string ) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif ( is_author() ) {

            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;

        } elseif ( is_date() ) {
            // Set default variables
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif ( is_post_type_archive() ) {

            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );

            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

        }
    }   

    // Handle the search page
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Search query for: ' ) . $before . get_search_query() . $after;
	}

    // Handle 404's
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }
    // Handle paged pages
    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }

    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<div id="breadCrumbs"><div class="breadcrumb">';
    if (    is_home()
         || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if ( is_paged() ) {
            $breadcrumb_output_link .= $here_text . $delimiter;
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
	} if ( is_single() ) {
        $breadcrumb_output_link .= $here_text . $delimiter;
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a> <a href="/blog/"> Blog </a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
	else {
        $breadcrumb_output_link .= $here_text . $delimiter;
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</div><!-- .breadcrumbs --></div><!--#breadCrumbs-->';

    return $breadcrumb_output_link;
}
add_shortcode( 'breadcrumbs', 'get_hansel_and_gretel_breadcrumbs');
//Breadcrumbs - Ends

//Custom Location Form Begins
function findLocation() {
	return '<form action="/locations-2" method="post" class="locationSearchForm"><input name="codeStateOrZip"type="text" placeholder="Enter ZIP or State Code..."><input name="combined-submit" type="submit" value="Get Help Now"></form>';
}
add_shortcode( 'find_location', 'findLocation');
//Custom Location Form Ends

//Custom Next Previous Links - Service Child Pages - Begins
add_shortcode( 'cf-navigation', 'cf_navigation' );
function cf_navigation() {
	ob_start();
	$post_id = get_the_ID();
	$parent_id = wp_get_post_parent_id($post_id);
	$post_type = get_post_type($post_id);
	
	// Franchise localization: Code to exlude the services link from this module - AHC
	$franchise_id = getIdFromCookie();
	$exclueInactiveService = array();
	if($franchise_id){
		$servicesRows = get_field( "services", $franchise_id );
		foreach($servicesRows as $servicesRow){
			if($servicesRow['active'] == false){
				$exclueInactiveService[] = $servicesRow['service_page_id'];
			}
		}
	}
	$sibling_list = get_pages(array(
			'sort_column' => 'menu_order',
			'sort_order'  => 'asc',
			'child_of'    => $parent_id,
			'post_type'   => $post_type,
			'exclude' 	  => $exclueInactiveService,
	));	
	

	if( !$sibling_list || is_wp_error($sibling_list) )
		return false;

	$pages = array();
	foreach ($sibling_list as $sibling ) {
		$pages[] = $sibling->ID;
	}

	$current = array_search($post_id, $pages);
	$prevID = isset($pages[$current-1]) ? $pages[$current-1] : false;
	$nextID = isset($pages[$current+1]) ? $pages[$current+1] : false;
	$count=count($pages);
	$count=$count-1;
?>
	<div class="cf-navigation">
		<div class="nextPrevLinks">
		<?php if (!empty($prevID)) { 
		$old_prev=$prevID;
		?>
			<a href="<?php echo get_permalink($prevID); ?>"
			class="prevLink nextPrevAnchor" title="<?php echo get_the_title($prevID); ?>"><?php echo get_the_title($prevID); ?><span class="leftLink"></span></a>
		<?php }
		else { ?>
			<a href="<?php echo get_permalink($pages[$count]); ?>"
			class="prevLink nextPrevAnchor" title="<?php echo get_the_title($pages[$count]); ?>"><?php echo get_the_title($pages[$count]); ?><span class="leftLink"></span></a>
		<?php }

		if (!empty($nextID)) { 

		?>
			<a href="<?php echo get_permalink($nextID); ?>" 
			class="nextLink nextPrevAnchor" title="<?php echo get_the_title($nextID); ?>"><?php echo get_the_title($nextID); ?><span class="rightLink"></span></a>
			<?php }
			else { ?>
			<a href="<?php echo get_permalink($pages[0]); ?>" 
			class="nextLink nextPrevAnchor" title="<?php echo get_the_title($pages[0]); ?>"><?php echo get_the_title($pages[0]); ?><span class="rightLink"></span></a>
			<?php }
			?>
		</div>
	</div><!-- .navigation -->
	<?php
		
	return ob_get_clean();
}
//Custom Next Previous Links - Service Child Pages - Ends


/***** Location Search Form Functions Start *****/
add_filter( 'gform_field_validation_326_1', 'validate_zip_state_code', 10, 4 );
function validate_zip_state_code( $result, $value, $form, $field ) {
 	
	if ( $result['is_valid'] ) {
		$validState = validateState( $value );
		if($validState){
			$validState = true;
		}
		
		if(!$validState && (!ctype_digit( $value ) || 5 != strlen( $value )) ) {
			$result['is_valid'] = false;
			$result['message'] = 'Incorrect Format. Please enter a valid ZIP or State Code.';
		}
		
	}
	
	// If above conditions are passed then check from the API
	if ( $result['is_valid'] ) {
        $request_url = add_query_arg(
            array(
                'search'  => $value,
            ),
            'http://restoration1.com/store-locator/api/fetch_loc.php'
        );
 
        $response       = wp_remote_get( $request_url );
        $response_json  = wp_remote_retrieve_body( $response );
        $response_array = json_decode( $response_json, 1 );
 
        if ( rgar( $response_array, 'overallStatusCode' ) != '200' ) {
			$result['message']  = rgar( $response_array, 'message' );
			$result['is_valid'] = false;
        }
	}
	
	return $result;	
}
add_action( 'gform_after_submission_326', 'remove_form_entry' );
function remove_form_entry( $entry ) {
    GFAPI::delete_entry( $entry['id'] );
}

add_filter( 'gform_confirmation_326', 'fetch_data_from_api', 10, 3 );
function fetch_data_from_api( $confirmation, $form, $entry ) {
	
	$response_array = make_api_request(rgar( $entry, '1' ));
	
	if ( rgar( $response_array, 'overallStatusCode' ) == '200' ) {
		$result = rgar( $response_array, 'result' );
		$type = $result['type'];
		if($type == 'unowned' || $type == 'shared'){
			$confirmation = array( 'redirect' => '/locations' );
			
				if( ! session_id() )
					session_start();

				$_SESSION['locations'] = $result;
				$_SESSION['searchedKeyword'] = rgar( $entry, '1' );
			
		}elseif($type == 'single'){
			$locationURL = $result[0]['url'];
			$locationWebsite = $result[0]['visit_websiteurl'];
			
			if($locationURL){
				
				//replace live URL with the dev url
				$locationURL =  str_replace( "https://www.restoration1.com", "https://restorationoneredesign.gowiththrive.net", $locationURL);
				$confirmation = array( 'redirect' => $locationURL );
			}else{
				$confirmation = array( 'redirect' => '/locations' );
				//replace live URL with the dev url
				//$locationWebsite =  str_replace( "https://www.restoration1.com", "https://restorationoneredesign.gowiththrive.net", $locationWebsite);
				//$confirmation = array( 'redirect' => $locationWebsite );
				
				if( ! session_id() )
					session_start();

				$_SESSION['locations'] = $result;
				$_SESSION['searchedKeyword'] = rgar( $entry, '1' );
			}
		}
	}else{
		$confirmation = array( 'redirect' => '/locations' );
		
		if( ! session_id() )
			session_start();

		$_SESSION['locations'] = $result;
		$_SESSION['searchedKeyword'] = rgar( $entry, '1' );
	}
	
	
	return $confirmation;
}
function make_api_request($searchedString) {
	$request_url = add_query_arg(
		array(
			'search'  => $searchedString,
		),
		'http://restoration1.com/store-locator/api/fetch_loc.php'
	);

	$response       = wp_remote_get( $request_url );
	$response_json  = wp_remote_retrieve_body( $response );
	$response = json_decode( $response_json, 1 );
	return $response;
}
function validateZipCode($zipCode) {
	if(!ctype_digit( $zipCode ) || 5 != strlen( $zipCode )){
		return false;
	}else{
		return true;
	}
}
function validateState($name) {
   $states = array(
      array('name'=>'Alabama', 'abbr'=>'AL'),
      array('name'=>'Alaska', 'abbr'=>'AK'),
      array('name'=>'Arizona', 'abbr'=>'AZ'),
      array('name'=>'Arkansas', 'abbr'=>'AR'),
      array('name'=>'California', 'abbr'=>'CA'),
      array('name'=>'Colorado', 'abbr'=>'CO'),
      array('name'=>'Connecticut', 'abbr'=>'CT'),
      array('name'=>'Delaware', 'abbr'=>'DE'),
      array('name'=>'Florida', 'abbr'=>'FL'),
      array('name'=>'Georgia', 'abbr'=>'GA'),
      array('name'=>'Hawaii', 'abbr'=>'HI'),
      array('name'=>'Idaho', 'abbr'=>'ID'),
      array('name'=>'Illinois', 'abbr'=>'IL'),
      array('name'=>'Indiana', 'abbr'=>'IN'),
      array('name'=>'Iowa', 'abbr'=>'IA'),
      array('name'=>'Kansas', 'abbr'=>'KS'),
      array('name'=>'Kentucky', 'abbr'=>'KY'),
      array('name'=>'Louisiana', 'abbr'=>'LA'),
      array('name'=>'Maine', 'abbr'=>'ME'),
      array('name'=>'Maryland', 'abbr'=>'MD'),
      array('name'=>'Massachusetts', 'abbr'=>'MA'),
      array('name'=>'Michigan', 'abbr'=>'MI'),
      array('name'=>'Minnesota', 'abbr'=>'MN'),
      array('name'=>'Mississippi', 'abbr'=>'MS'),
      array('name'=>'Missouri', 'abbr'=>'MO'),
      array('name'=>'Montana', 'abbr'=>'MT'),
      array('name'=>'Nebraska', 'abbr'=>'NE'),
      array('name'=>'Nevada', 'abbr'=>'NV'),
      array('name'=>'New Hampshire', 'abbr'=>'NH'),
      array('name'=>'New Jersey', 'abbr'=>'NJ'),
      array('name'=>'New Mexico', 'abbr'=>'NM'),
      array('name'=>'New York', 'abbr'=>'NY'),
      array('name'=>'North Carolina', 'abbr'=>'NC'),
      array('name'=>'North Dakota', 'abbr'=>'ND'),
      array('name'=>'Ohio', 'abbr'=>'OH'),
      array('name'=>'Oklahoma', 'abbr'=>'OK'),
      array('name'=>'Oregon', 'abbr'=>'OR'),
      array('name'=>'Pennsylvania', 'abbr'=>'PA'),
      array('name'=>'Rhode Island', 'abbr'=>'RI'),
      array('name'=>'South Carolina', 'abbr'=>'SC'),
      array('name'=>'South Dakota', 'abbr'=>'SD'),
      array('name'=>'Tennessee', 'abbr'=>'TN'),
      array('name'=>'Texas', 'abbr'=>'TX'),
      array('name'=>'Utah', 'abbr'=>'UT'),
      array('name'=>'Vermont', 'abbr'=>'VT'),
      array('name'=>'Virginia', 'abbr'=>'VA'),
      array('name'=>'Washington', 'abbr'=>'WA'),
      array('name'=>'West Virginia', 'abbr'=>'WV'),
      array('name'=>'Wisconsin', 'abbr'=>'WI'),
      array('name'=>'Wyoming', 'abbr'=>'WY'),
      array('name'=>'Virgin Islands', 'abbr'=>'V.I.'),
      array('name'=>'Guam', 'abbr'=>'GU'),
      array('name'=>'Puerto Rico', 'abbr'=>'PR')
   );

   $return = false;   
   $strlen = strlen($name);

   foreach ($states as $state) :
      if ($strlen < 2) {
         return false;
      } else if ($strlen == 2) {
         if (strtolower($state['abbr']) == strtolower($name)) {
            $return = $state['name'];
            break;
         }   
      } else {
         if (strtolower($state['name']) == strtolower($name)) {
            $return = strtolower($state['name']);
            break;
         }         
      }
   endforeach;
   
   return $return;
}
/***** Location Search Form Functions End *****/

/***** Franchise Page Functions Start *****/
function isFranchiseLocation(){
	
	global $post;
	
	// Is current post/page a location page? (e.g. restoration1.com/austin/)
	$template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	if ( $template == "page-templates/landing-page.php" ) {
		return true;
	}
	
	return false;
}

function getIdFromSession(){
	if ( isFranchiseLocation() == false ){
		if(isset($_SESSION['franchise'])) {
			return $_SESSION['franchise'];
		}
	}else{
		return idLocation();
	}
}

add_shortcode('nap_number', 'nap_number_shortcode');
function nap_number_shortcode( $atts = array() ) {
	$att = shortcode_atts( array(
		'link'		=>	false,
	), $atts );
	$franchise_id = getIdFromCookie();
	if($franchise_id){
		$napNumber = get_field( 'napnumber', $franchise_id );
		$napNumber = standardize_phone_number_format($napNumber);
		if($att['link']){
			//$output = '<a href="tel:+1(512) 842-7432" onclick="ga('send', 'event', 'Phone call click to call', 'Select phone number');">(512) 842-7432</a>';
			$output = '<a class="btn btn-orange" href="' . $att['link'] . '" target="_blank">' . $att['text'] . '</a>';
			$output = '<a href="tel:+1-'. $napNumber .'" onclick="ga(\'send\', \'event\', \'Phone call click to call\', \'Select phone number\');">'. $napNumber .'</a>';
		}else{
			$output = $napNumber;
		}
		
	}

	return $output;
}

add_shortcode('nap_number_link', 'nap_number_link_shortcode');
function nap_number_link_shortcode( ) {
	$franchise_id = getIdFromCookie();
	$output = '';
	if($franchise_id){
		$napNumber = get_field( 'napnumber', $franchise_id );
		if($napNumber){
			$napNumber = standardize_phone_number_format($napNumber); 
			$output = '<a href="tel:+1-'. $napNumber .'" onclick="ga(\'send\', \'event\', \'Phone call click to call\', \'Select phone number\');">'. $napNumber .'</a>';
		}
	}
	return $output;
}
function standardize_phone_number_format($phone) {
	//Format: (000) 000-0000
	$numbers_only = preg_replace("/[^\d]/", "", $phone);
	return preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $numbers_only);
}

add_filter('acf/load_value/key=field_5fc7aa41f2279', 'pre_pop_repeater', 20, 3);
function pre_pop_repeater($value, $post_id, $field) {
	$value_arr = array();
	$services = services_arr();
	
	if ($value != NULL) {
		// if the acf value is not null then
		// repeater was previously saved
		// and we should not override
		//return $value;
		$totalServices = count($services);
		$totalValues = count($value);
		if($totalServices != $totalValues){
			$i = 0;
			foreach($services as $key => $val){
				$value_arr[] = array(
					'field_5fc8da25b4cb3' => $value[$i]['field_5fc8da25b4cb3'],
					'field_5fc8fe94d52b6' => $key,
					'field_5fc7bb0076034' => $val,
					'field_5fc7b805b1a27' => $value[$i]['field_5fc7b805b1a27'],
				);
				$i++;
			}
			$value = $value_arr;
			//return $value;
		}else{
			$i = 0;
			foreach($services as $key => $val){
				$value_arr[] = array(
					'field_5fc8da25b4cb3' => $value[$i]['field_5fc8da25b4cb3'],
					'field_5fc8fe94d52b6' => $key,
					'field_5fc7bb0076034' => $val,
					'field_5fc7b805b1a27' => $value[$i]['field_5fc7b805b1a27'],
				);
				$i++;
			}
			$value = $value_arr;
			//return $value;
		}
		
	}else{
		foreach($services as $key => $value){
			$value_arr[] = array(
				'field_5fc8da25b4cb3' => true,
				'field_5fc8fe94d52b6' => $key,
				'field_5fc7bb0076034' => $value,
			);
		}
		$value = $value_arr;
	}
	
	return $value;
}
add_filter('acf/load_field/key=field_5fc7bb0076034', 'my_acf_load_field');
function my_acf_load_field( $field ) {
	$field['readonly'] = 1;
    return $field;
}
add_filter('acf/load_field/key=field_5fc8fe94d52b6', 'my_acf_load_field2');
function my_acf_load_field2( $field ) {
	$field['readonly'] = 1;
    return $field;
}


add_filter('wp_nav_menu_objects', 'filter_services_menu_items', 10, 2);
function filter_services_menu_items($items, $args) {
	//if(is_page(28937))
		
		
	$franchise_id 	  	  = getIdFromCookie();
	$allServices 	  	  = services_arr();
	$selectedServices 	  = array();
	$overrideServiceLinks = array();
	
	
	if($franchise_id){
		$localTeamPageURL 	  = get_field( "about_us__your_local_team_page", $franchise_id );
		$cityPages 		  	  = get_field( "city_pages", $franchise_id );
		$servicesRows 	  	  = get_field( "services", $franchise_id );
		$testimonialLink 	  = get_field( "testimonials_page", $franchise_id );
		$sideRibbonFields 	  = get_field( 'side_ribbon_fields', $franchise_id );
		$testimonialLink 	  = $sideRibbonFields['testimonials_page'];
		$totalCityPages 	  = count($cityPages);

		//$selectedServices = get_post_meta( $franchise_id, 'cmb_home_location_services', true);

		foreach($servicesRows as $servicesRow){
			if($servicesRow['active'] == true){
				$selectedServices[] = $servicesRow['service_page_id'];

				if($servicesRow['local_service_page_url'] != ''){
					$overrideServiceLinks[$servicesRow['service_page_id']] = $servicesRow['local_service_page_url'];
				}
			}
		}

		if (!empty($selectedServices)){

			// check for the right menu to remove the menu item from
			if ($args->theme_location != 'primary')  
				return $items;

			// remove the menu item that are not selected on franchise page
			foreach ($items as $key => $menu_object) {
				//Check: Only loop through the service menu items and ignore the other items
				if($allServices[$menu_object->object_id]){

					//Remove the item if the item is not found in selected services
					if(!in_array($menu_object->object_id,$selectedServices)){
						unset($items[$key]);
					}else if(array_key_exists($menu_object->object_id,$overrideServiceLinks)){
						$menu_object->url = $overrideServiceLinks[$menu_object->object_id];
					}
				}
			}
		}


		// Menu customization for city pages
		if($cityPages){
			$i = 0;
			echo '<pre style="display:none;">';
			var_dump($cityPages);
			echo '</pre>';
			foreach($items as $key => $item){

				if( $item->title == "Locations" ){
					$item->title = 'Cities We Serve';
					$item->url = '#';
				}

				if( $item->title == "PLACEHOLDER FOR CITY PAGE LINK") {
					if($i < $totalCityPages){
						$cityPageID = $cityPages[$i]['city_page'];
						$item->title = get_the_title( $cityPageID );
						$item->url = get_permalink( $cityPageID );
						$i++;
					}else{
						unset($items[$key]); //Remove remaining placeholders menu items from locations menu
					}
				}
			}
		}else{
			//No city pages found for current franchise so remove all placeholder items from menu
			foreach($items as $key => $item){
				if( $item->title == "Locations" ){
					if (($key = array_search('menu-item-has-children', $item->classes)) !== false) {
						unset($item->classes[$key]);
					}
				}elseif( $item->menu_item_parent == 30796 ){// ID of the Locations menu
					unset($items[$key]);
				}
			}

		}

		//Menu customization for your local team page under about us.
		foreach($items as $key => $item){
			//Swap Team Leader menu with Your Local Team under about us	
			if( $item->title == "Team Leaders"){
				if($localTeamPageURL != ''){
					$item->title = 'Your Local Team';
					$item->url = $localTeamPageURL;
				}else{
					unset($items[$key]);
				}
			}elseif($item->title == "Testimonials"){
				if($testimonialLink != ''){
					$item->url = $testimonialLink;
				}
			}
			
		}
	}else{
			foreach($items as $key => $item){
				if( $item->title == "Locations" ){
					if (($key = array_search('menu-item-has-children', $item->classes)) !== false) {
						unset($item->classes[$key]);
					}
				}elseif( $item->menu_item_parent == 30796 ){// ID of the Locations menu
					unset($items[$key]);
				}
			}
	}

    return $items;
}
/***** Franchise Page Functions End *****/

/***** Contact forms customization Start *****/
//Pre populate franchise ID and franchise name hidden fields on pre-submission
add_action( 'gform_pre_submission', 'populate_location_details_pre_submit' );
function populate_location_details_pre_submit( $form ) {
	$formID = $form['id'];
	$franchise_id = getIdFromCookie();
	
	if($franchise_id){
		$franchiseID   = get_field( "franchise_id", $franchise_id );
		$franchiseName = get_field( "franchise_name", $franchise_id );
	}else{
		if($formID == '154'):
			$zipCode = $_POST['input_7'];
		elseif($formID == '322' || $formID == '323'):
			$zipCode = $_POST['input_5'];
		endif;

		$franchise_details = fetch_franchise_emails($zipCode);
		$franchiseID   = $franchise_details->result->Franchise_ID;
		$franchiseName = $franchise_details->result->Franchise_Name;
	}
	
	
	if($formID == '154'){
		if( $franchiseID)
			$_POST['input_15'] = $franchiseID;
		
		if($franchiseName)
			$_POST['input_16'] = $franchiseName;
		
	}elseif($formID == '322'){
		if( $franchiseID)
			$_POST['input_8'] = $franchiseID;
		
		if($franchiseName)
			$_POST['input_9'] = $franchiseName;

		$_POST['input_10'] = ($franchise_id ? 'Cookie' : 'ZIP');
		
	}elseif($formID == '323'){
		if( $franchiseID)
			$_POST['input_7'] = $franchiseID;
		
		if($franchiseName)
			$_POST['input_8'] = $franchiseName;
		
		$_POST['input_9'] = ( $franchise_id ? 'Cookie' : 'ZIP' );
		
	}elseif($formID == '327'){
		if( $franchiseID)
			$_POST['input_11'] = $franchiseID;		
	}
	
}

//Customized notification: Franchise page main contact form
add_filter( 'gform_notification_322', 'franchise_form_route_email_to_franchise', 10, 3 );
function franchise_form_route_email_to_franchise( $notification, $form, $entry ) {
 
	$emergency = rgar( $entry, '7.1' );
	$franchise_id = getIdFromCookie();
	$entryID = rgar( $entry, 'id' );
	
	if ( $notification['name'] == 'Admin Notification' ) {
		
		//Subject format will be build like below example
		//[#12345] Website Enquiry - Name Surname (ZIP: 56789)
		//[#12345] Emergency - Name Surname (ZIP: 56789)
		
		if($emergency):
			$notification['subject'] = 'Emergency - '. $notification['subject'];
		else:
			$notification['subject'] = 'Website Enquiry - '. $notification['subject'];
		endif;
		
		$notification['subject'] = '[#'.$entryID. '] '. $notification['subject'];
		
		
		
		if($franchise_id){
			$franchiseID   = get_field( "franchise_id", $franchise_id );
			$franchiseName = get_field( "franchise_name", $franchise_id );
			$emails = get_field( "email", $franchise_id );
			// change the "to" email address
			//$notification['to'] = $emails;
			$notification['message'] .= '<br/><b>Notification Email Adress: </b>'. $emails;
		}else{
			$zipCode = rgar( $entry, '5' );
			$franchise_details = fetch_franchise_emails($zipCode);
			$franchiseID   = $franchise_details->result->Franchise_ID;
			$franchiseName = $franchise_details->result->Franchise_Name;
			
			if($franchise_details->result->email){
				$emails = $franchise_details->result->email;
				$emails = str_replace("[","",$emails);
				$emails = str_replace("]","",$emails);
				$emails = str_replace("\"","",$emails);
				//$emails = explode (",", $emails);
				//$notification['to'] = $emails;
				$notification['message'] .= '<br/><b>Notification Email Adress: </b>'.$emails;
			}
		}
		
		//if( $franchiseID && $franchiseName)
			//$notification['subject'] = $notification['subject'] . ' ['. $franchiseID .'-'. $franchiseName .']';

		$notification['to'] = 'r1mailtest@thriveagency.com';		
	}
	
    return $notification;
}

//Customized notification: Services page contact form
add_filter( 'gform_notification_323', 'service_form_route_email_to_franchise', 10, 3 );
function service_form_route_email_to_franchise( $notification, $form, $entry ) {
 
	$franchise_id = getIdFromCookie();
	$entryID = rgar( $entry, 'id' );
	
	if ( $notification['name'] == 'Admin Notification' ) {
		
		$notification['subject'] = '[#'.$entryID. '] Website Enquiry - '. $notification['subject'];
		
		if($franchise_id){
			$franchiseID   = get_field( "franchise_id", $franchise_id );
			$franchiseName = get_field( "franchise_name", $franchise_id );
			$emails = get_field( "email", $franchise_id );
			// change the "to" email address
			//$notification['to'] = $emails;
			$notification['message'] .= '<br/><b>Notification Email Adress: </b>'. $emails;
		}else{
			$zipCode = rgar( $entry, '5' );
			$franchise_details = fetch_franchise_emails($zipCode);
			$franchiseID   = $franchise_details->result->Franchise_ID;
			$franchiseName = $franchise_details->result->Franchise_Name;
			
			if($franchise_details->result->email){
				$emails = $franchise_details->result->email;
				$emails = str_replace("[","",$emails);
				$emails = str_replace("]","",$emails);
				$emails = str_replace("\"","",$emails);
				//$emails = explode (",", $emails);
				//$notification['to'] = $emails;
				$notification['message'] .= '<br/><b>Notification Email Adress: </b>'.$emails;
			}
		}
		
		//if( $franchiseID && $franchiseName)
			//$notification['subject'] = $notification['subject'] . ' ['. $franchiseID .'-'. $franchiseName .']';
		
		$notification['to'] = 'r1mailtest@thriveagency.com';
	}
	
    return $notification;
}

//Customized notification: Contact us page contact form
add_filter( 'gform_notification_154', 'contact_form_route_email_to_franchise', 10, 3 );
function contact_form_route_email_to_franchise( $notification, $form, $entry ) {
	
	$emergency = rgar( $entry, '13' );
	$entryID = rgar( $entry, 'id' );
	$franchise_id = getIdFromCookie();
	
	
	if ( $notification['name'] == 'Admin Notification' ) {
		
		//Subject format will be build like below example
		//[#12345] Website Enquiry - Name Surname (ZIP: 56789)
		//[#12345] Emergency - Name Surname (ZIP: 56789)
		
		if($emergency == 'Yes'):
			$notification['subject'] = 'Emergency - '. $notification['subject'];
		else:
			$notification['subject'] = 'Website Enquiry - '. $notification['subject'];
		endif;
		
		$notification['subject'] = '[#'.$entryID. '] '. $notification['subject'];
		
		if($franchise_id){
			$franchiseID   = get_field( "franchise_id", $franchise_id );
			$franchiseName = get_field( "franchise_name", $franchise_id );
			$emails = get_field( "email", $franchise_id );
			// change the "to" email address
			//$notification['to'] = $emails;
			$notification['message'] .= '<br/><b>Notification Email Adress: </b>'.$emails;
		}else{
			$zipCode = rgar( $entry, '7' );
			$franchise_details = fetch_franchise_emails($zipCode);
			$franchiseID   = $franchise_details->result->Franchise_ID;
			$franchiseName = $franchise_details->result->Franchise_Name;
			
			if($franchise_details->result->email){
				$emails = $franchise_details->result->email;
				$emails = str_replace("[","",$emails);
				$emails = str_replace("]","",$emails);
				$emails = str_replace("\"","",$emails);
				//$emails = explode (",", $emails);
				//$notification['to'] = $emails;
				$notification['message'] .= '<br/><b>Notification Email Adress: </b>'.$emails;
			}
		}

		//if( $franchiseID && $franchiseName)
			//$notification['subject'] = $notification['subject'] . ' ['. $franchiseID .'-'. $franchiseName .']';
		
		$notification['to'] = 'r1mailtest@thriveagency.com';
	}
	
    return $notification;
}

// Pre select the franchise in dropdown if cookie is present in careers form
add_filter( 'gform_pre_render_327', 'location_default_selected' );
add_filter( 'gform_pre_validation_327', 'location_default_selected' );
add_filter( 'gform_pre_submission_filter_327', 'location_default_selected' );
add_filter( 'gform_admin_pre_render_327', 'location_default_selected' );
function location_default_selected( $form ) {

	if (is_admin() ) return $form;
	$franchise_id = getIdFromCookie();
	if($franchise_id){
		foreach ( $form['fields'] as &$field ) {

			if ( $field->type != 'select' || strpos( $field->cssClass, 'careersSelectALocation' ) === false ) {
				continue;
			}
			foreach ( $field->choices as $key => $choice ) {
				$field->choices[$key]['isSelected'] = ( $franchise_id == $choice['value'] );
			}
		}
	}
	return $form;
}

//Customized notification: Contact us page contact form
add_filter( 'gform_notification_327', 'careers_route_email_to_franchise', 10, 3 );
function careers_route_email_to_franchise( $notification, $form, $entry ) {
	
	$selected_franchise_id = maybe_unserialize( rgar( $entry, '1' ) );
	$entryID = rgar( $entry, 'id' );
	$franchise_id = getIdFromCookie();
	if ( $notification['name'] == 'Admin Notification' ) {
		
		//Subject format will be build like below example
		//[#12345] Website Enquiry - Name Surname (ZIP: 56789)

		$notification['subject'] = 'Website Enquiry - '. $notification['subject'];
		$notification['subject'] = '[#'.$entryID. '] '. $notification['subject'];
		
		if($selected_franchise_id){
			$franchiseID   = get_field( "franchise_id", $selected_franchise_id );
			$franchiseName = get_field( "franchise_name", $selected_franchise_id );
			$emails = get_field( "email", $selected_franchise_id );
			//$notification['to'] = $emails;
			$notification['message'] .= '<br/><b>Notification Email Adress: </b>'.$emails;
			print_r($emails);
		}		
		
		$notification['to'] = 'r1mailtest@thriveagency.com';
	}
	
    return $notification;
}



function fetch_franchise_emails($zipCode) {
	
	$request_url = add_query_arg(
		array(
			'zipcode'  => $zipCode,
		),
		'http://restoration1.com/store-locator/api/fetchmail.php'
	);
	$response = wp_remote_get( $request_url );
	if ( is_wp_error( $response ) ) {
		echo 'Error fetching the information.';
	} else {
		$response_json = wp_remote_retrieve_body( $response );
	    $data = json_decode( $response_json );
	}

	if($data->overallStatusCode == 200){
		
		return $data;

	}elseif($data->overallStatusCode == 400){
		
		return $data->message;
	}	
	
}

// custom_zip_validation
add_filter( 'gform_field_validation_154_7', 'custom_zip_validation', 10, 4 );
add_filter( 'gform_field_validation_322_5', 'custom_zip_validation', 10, 4 );
add_filter( 'gform_field_validation_323_5', 'custom_zip_validation', 10, 4 );
add_filter( 'gform_field_validation_327_9', 'custom_zip_validation', 10, 4 );
function custom_zip_validation( $result, $value, $form, $field )
{
	if ( $result['is_valid'] )
	{	
		//$zip_value = rgar( $value, $field->id . '.5' );
		$zip_value = $value;
		if ( ! ctype_digit( $zip_value ) || 5 != strlen( $zip_value ) ) 
		{
			$result['is_valid'] = false;
			$result['message'] = 'Incorrect Format. Please enter a valid Zip Code.';
		}
	}
	
	return $result;
} // end custom_zip_validation

/***** Contact forms customization END *****/

/***** Testimonials customization START *****/
//Load random rize reviews script
function rizeReviewsRandomScript() {
	$franchise_id = getIdFromCookie();
	
	if($franchise_id)
		$reviewsScript = get_field( 'rize_review_script', $franchise_id );
	
	if($reviewsScript){
		return $reviewsScript;
	}else{
		// Get the repeater field
		$repeater = get_field( 'rize_review_scripts_to_load_randomly', 2); //Homepage ID is 2
		// Get a random rows. Change the second parameter in array_rand() to how many rows you want.
		$random_row = array_rand( $repeater, 1 );
		return $repeater[$random_row]['rize_reviews_script'];
		
	}
	
}
add_shortcode( 'rizereviews_random_script', 'rizeReviewsRandomScript');

/***** Testimonials Page Shortcode START *****/
function loadReviews() {
	$rows = get_field('rize_reviews_scripts' , 1425);
	$html = '<form method="post" action="">';
	$selected_franchise = $_POST['reviews'];

	if( $rows ) {
		$html .= '<label for="franchise_select">Please select a franchise below to load reviews:</label>';
	    $html .=  '<select type="text" class="form-control filter-select" name="reviews" id="franchise_select" onchange="this.form.submit()">';
	    $html .= '<option value="">Select a Franchise</option>';
	    foreach( $rows as $row ) {
	        $franchiseName = $row['franchise_name'];
	        $reviewScript = $row['franchise_reviews_script'];
	        if($selected_franchise == $franchiseName){
		        $html .= '<option selected="selected" value="'. $franchiseName .'">'. $franchiseName .'</option>';
	        }else{
		        $html .= '<option value="'. $franchiseName .'">'. $franchiseName .'</option>';
	        }
	    }
	    $html .= '</select></form>';
	}

	$selected_franchise = $_POST['reviews'];
	if($selected_franchise){
	    foreach( $rows as $row ) {
	        $franchiseName = $row['franchise_name'];
	        $reviewScript = $row['franchise_reviews_script'];
	    	if($selected_franchise == $franchiseName){
		        $html .= $reviewScript;
	    	}
	    }
	}
	return $html;
}
add_shortcode( 'load_reviews', 'loadReviews' );

function testimonialsLink() {
	$franchise_id = getIdFromCookie();
	if( $franchise_id ){
		$sideRibbonFields = get_field( 'side_ribbon_fields', $franchise_id );
		if($sideRibbonFields['testimonials_page']){
			return $sideRibbonFields['testimonials_page'];
		}
		else{
			return '/testimonials';
		}
	}else{
		return '/testimonials';
	}
}
add_shortcode( 'testimonials_link', 'testimonialsLink');
/***** Testimonials customization END *****/

//Custom Pagination Begins
if ( ! function_exists( 'restorationPagination' ) ) :
function restorationPagination() {
global $wp_query;
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
'format' =>'?paged=%#%',
'current' => max( 1, get_query_var('paged') ),
'total' => $wp_query->max_num_pages
) );
}
endif;
//Custom Pagination Ends
if (function_exists('register_sidebar')) {
register_sidebar(array(
	'name' => 'Blog Sidebar',
	'id'   => 'Blog Sidebar',
	'description'   => 'Widget Area Shows Only On Blog Posts Single Blog Posts.',
	'before_widget' => '<div id="%1$s" class="blogEachWidget %2$s">',
	'after_widget'  => '</div></div>',
	'before_title'  => '<div class="blogEachWidgetInner"><h3 class="widget-title">',
	'after_title'   => '</h3>'
));
}