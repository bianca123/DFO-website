<?php
/**
 * Theme basic setup.
 *
 * @package understrap
 */

/* Add Custom posts */
add_action( 'init', 'create_post_type' );
function create_post_type() {
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
	  'menu_icon'   => 'dashicons-groups',

	)
  );
  register_post_type( 'newsletters',
	array(
	  'labels' => array(
		'name' => __( 'Nieuwsbrieven' ),
		'singular_name' => __( 'Nieuwsbrief' ),
		'view_item'     => __( 'Bekijk nieuwsbrief', 'text_domain' ),
		'add_new_item'  => __( 'Nieuwsbrief toevoegen', 'text_domain' ),
		'add_new'       => __( 'Nieuwsbrief toevoegen', 'text_domain' ),
		'edit_item'     => __( 'Nieuwsbrief aanpassen', 'text_domain' ),
		'update_item'   => __( 'Nieuwsbrieven updaten', 'text_domain' ),
		'search_items'  => __( 'Zoek nieuwsbrief', 'text_domain' ),
		'not_found'      => __( 'Geen nieuwsbrieven gevonden', 'text_domain' ),
		'not_found_in_trash'  => __( 'Geen nieuwsbrieven gevonden in prullebak', 'text_domain' ),
	  ),
	  'public' => true,
	  'has_archive' => true,
	  'menu_icon'   => 'dashicons-format-aside',
	  'rewrite' => array(
						'slug' => 'nieuwsbrief'
		)
	)
  );
}

/* Add custom taxonomies */
function create_taxonomy() {

	register_taxonomy(
		'team_category',
		'dfo_team',
		array(
			'hierarchical' => true,
		)
	);
	register_taxonomy(
		'news_category',
		'newsletters',
		array(
			'hierarchical' => true,
			'rewrite' => array(
							'slug' => 'nieuwsbrieven'
			)
		)
	);
	
}
add_action( 'init', 'create_taxonomy' );

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

	function theme_menu()
{
    wp_nav_menu(array(
		'theme_location'  => 'meta-menu',
		'container_class' => 'ml-auto',
		'container_id'    => 'metanav',
		'menu_class'      => 'navbar-nav meta-nav',
		'fallback_cb'     => '',
		'menu_id'         => 'meta-menu',
    ));
}