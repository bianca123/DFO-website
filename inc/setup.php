<?php
/**
 * Theme basic setup.
 *
 * @package understrap
 */

require get_template_directory() . '/inc/theme-settings.php';

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'understrap_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function understrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on understrap, use a find and replace
		 * to change 'understrap' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'understrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'hoofdmenu' => __( 'Primary Menu', 'understrap' ),
			'meta-menu' => __( 'Meta Menu', 'understrap' ),
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

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );
		
		/* Add Custom posts */
		add_action( 'init', 'create_post_type' );
		function create_post_type() {
		  register_post_type( 'dfo_klanten',
			array(
			  'labels' => array(
				'name' => __( 'Klanten' ),
				'singular_name' => __( 'Klant' ),
				'view_item'     => __( 'Bekijk klant', 'text_domain' ),
				'add_new_item'  => __( 'Nieuwe klant toevoegen', 'text_domain' ),
				'add_new'       => __( 'Nieuwe klant', 'text_domain' ),
				'edit_item'     => __( 'Klant aanpassen', 'text_domain' ),
				'update_item'   => __( 'Klanten updaten', 'text_domain' ),
				'search_items'  => __( 'Zoek klant', 'text_domain' ),
				'not_found'      => __( 'Geen klanten gevonden', 'text_domain' ),
				'not_found_in_trash'  => __( 'Geen klanten gevonden in prullebak', 'text_domain' ),
			  ),
			  'public' => true,
			  'has_archive' => false,
			  'menu_icon'   => 'dashicons-universal-access-alt',
			)
		  );
		  register_post_type( 'dfo_team',
			array(
			  'labels' => array(
				'name' => __( 'Teamleden' ),
				'singular_name' => __( 'Teamlid' ),
				'view_item'     => __( 'Bekijk teamlid', 'text_domain' ),
				'add_new_item'  => __( 'Nieuw teamlid toevoegen', 'text_domain' ),
				'add_new'       => __( 'Nieuw teamlid toevoegen', 'text_domain' ),
				'edit_item'     => __( 'Teamlid aanpassen', 'text_domain' ),
				'update_item'   => __( 'Teamleden updaten', 'text_domain' ),
				'search_items'  => __( 'Zoek teamlid', 'text_domain' ),
				'not_found'      => __( 'Geen teamleden gevonden', 'text_domain' ),
				'not_found_in_trash'  => __( 'Geen teamleden gevonden in prullebak', 'text_domain' ),
			  ),
			  'public' => true,
			  'has_archive' => false,
			  'menu_icon'   => 'dashicons-smiley',
			)
		  );
		}

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'understrap_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Set up the Wordpress Theme logo feature.
		add_theme_support( 'custom-logo', array(
			'class' => array( 'mr-auto' ),
		) );

		// Check and setup theme default settings.
		setup_theme_default_settings();
	}
endif; // understrap_setup.
add_action( 'after_setup_theme', 'understrap_setup' );

if ( ! function_exists( 'custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function custom_excerpt_more( $more ) {
		return '';
	}
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

if ( ! function_exists( 'all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function all_excerpts_get_more_link( $post_excerpt ) {

		return $post_excerpt . ' [...]<p><a class="btn btn-secondary understrap-read-more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More...',
		'understrap' ) . '</a></p>';
	}
}

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'front_page_template' );


add_filter( 'wp_trim_excerpt', 'all_excerpts_get_more_link' );
