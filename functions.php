<?php
/**
 * solid functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package solid
 */

if ( ! function_exists( 'solid_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function solid_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on solid, use a find and replace
	 * to change 'solid' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'solid', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'solid' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'solid_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'solid_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function solid_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'solid_content_width', 640 );
}
add_action( 'after_setup_theme', 'solid_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function solid_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'solid' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'solid' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer sidebar', 'solid' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Footer area', 'solid' ),
		'before_widget' => '<div id="%1$s" class="col-lg-4 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4><div class="hline-w"></div>',
	) );

}
add_action( 'widgets_init', 'solid_widgets_init' );

/* Init qoob libs */
add_filter( 'qoob_libs', 'solid_add_theme_lib', 10, 2 );

if ( ! function_exists( 'solid_add_theme_lib' ) ) {
  /**
   * Adding lib in qoob libs
   *
   * @param array $qoob_libs Array with url to qoob lib.
   */
  function solid_add_theme_lib( $qoob_libs ) {
    array_push( $qoob_libs, get_template_directory() . '/blocks/lib.json' );
    return $qoob_libs;
  }
}
if ( ! function_exists( 'solid_blog_load' ) ) {
	function solid_blog_load() {
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'orderby' => 'date',
			'posts_per_page' => esc_attr( $_POST['per_page'] ),
			'order' => "ASC",
		);
		$posts = get_posts($args);

		$data = array();
		$i = 0;

		foreach ($posts as $post) {
			setup_postdata($post);

			$data[$i] = array();
			$data[$i]['post_title'] = $post->post_title;
			$data[$i]['post_url'] = get_permalink($post->ID);

			$i++;
		}

		wp_reset_postdata();
		wp_send_json_success($data);
		wp_die();
	}
}

add_action("wp_ajax_solid_blog_load", "solid_blog_load");
add_action("wp_ajax_nopriv_solid_blog_load", "solid_blog_load");

/**
 * Enqueue scripts and styles.
 */
function solid_scripts() {
	wp_enqueue_style( 'solid-style', get_stylesheet_uri() );
	/* Bootstrap core CSS */
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array("solid-style") );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array("solid-style") );
	wp_enqueue_style( 'solid-main-style', get_template_directory_uri() . '/css/style.css', array("solid-style") );
	wp_enqueue_script( 'solid-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'solid-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// wp_enqueue_script('modernizr', get_template_directory_uri() . "/js/modernizr.js", array('jquery'));
	wp_enqueue_script('bootstrap', get_template_directory_uri() . "/js/bootstrap.min.js", array('jquery'), '', true);
	wp_enqueue_script('retina', get_template_directory_uri() . "/js/retina-1.1.0.js", array('jquery'), '', true);
	wp_enqueue_script('jquery.hoverdir', get_template_directory_uri() . "/js/jquery.hoverdir.js", array('jquery'), '', true);
	wp_enqueue_script('jquery.hoverex', get_template_directory_uri() . "/js/jquery.hoverex.min.js", array('jquery'), '', true);
	wp_enqueue_script('jquery.prettyPhoto', get_template_directory_uri() . "/js/jquery.prettyPhoto.js", array('jquery'), '', true);
	wp_enqueue_script('jquery.isotope', get_template_directory_uri() . "/js/jquery.isotope.min.js", array('jquery'), '', true);
	wp_enqueue_script('solid-custom', get_template_directory_uri() . "/js/custom.js", array('jquery'), '', true);
}

add_action( 'wp_enqueue_scripts', 'solid_scripts' );

function solid_admin_scripts() {
	wp_enqueue_script('solid-helper-hbs', get_template_directory_uri() . "/js/admin.js", array('qoob-backend-starter'));
}
add_action( 'admin_enqueue_scripts', 'solid_admin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/solid_navwalker.php';
/*
* TGM Class
*/
require get_template_directory() . '/inc/init-tgm.php';

/*
* Theme options
*/
require get_template_directory() . '/inc/theme-options.php';

