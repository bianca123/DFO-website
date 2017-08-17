<?php
/**
 * The template for displaying Woocommerce pages.
 *
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */
 
function timber_set_product( $this_post ) {
    global $product;
    global $post;
    if ( is_woocommerce() ) {
        $product = wc_get_product($this_post->ID);
        $post = get_post($this_post->ID);
    }
}

/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
function wc_form_field_args( $args, $key, $value = null ) {
	// Start field type switch case.
	switch ( $args['type'] ) {
		/* Targets all select input type elements, except the country and state select input types */
		case 'select' :
			// Add a class to the field's html element wrapper - woocommerce
			// input types (fields) are often wrapped within a <p></p> tag.
			$args['class'][] = 'form-group';
			// Add a class to the form input itself.
			$args['input_class']       = array( 'form-control', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
				// Add custom data attributes to the form input itself.
			);
			break;
		// By default WooCommerce will populate a select with the country names - $args
		// defined for this specific input type targets only the country select element.
		case 'country' :
			$args['class'][]     = 'form-group single-country';
			$args['label_class'] = array( 'control-label' );
			break;
		// By default WooCommerce will populate a select with state names - $args defined
		// for this specific input type targets only the country select element.
		case 'state' :
			// Add class to the field's html element wrapper.
			$args['class'][] = 'form-group';
			// add class to the form input itself.
			$args['input_class']       = array( '', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
			);
			break;
		case 'password' :
		case 'text' :
		case 'email' :
		case 'tel' :
		case 'number' :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'textarea' :
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'checkbox' :
			$args['label_class'] = array( 'custom-control custom-checkbox' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		case 'radio' :
			$args['label_class'] = array( 'custom-control custom-radio' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		default :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
	} // end switch ($args).
	return $args;
}

add_action( 'after_setup_theme', 'woocommerce_support' );
if ( ! function_exists( 'woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'wc_form_field_args', 10, 3 );
	}
}

//* Remove excerpt, title, image 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_images', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 5 );

//* Remove description tab
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    return $tabs;
}

//* Add title, description on left side
function woocommerce_template_product_description() {
  woocommerce_get_template( 'single-product/tabs/description.php' );
}
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 10 );

//* Custom categorie header 
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
add_action( 'woocommerce_archive_description', 'woocommerce_category_head', 1 );
function woocommerce_category_head() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
		$page_title = single_term_title( "", false );
	    if ( $image ) {
			if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
				$description = wc_format_content( term_description() );
				if ( $description ) {
					echo '<div class="page-header" style="background-image: url(' . $image . ');">
							<div class="container">
								<h2>'. $page_title .'</h2>
								' . $description . '
							</div>
						</div>
					';
				}
				else {
					echo '<div class="page-header" style="background-image: url(' . $image . ');">
						<div class="container">
							<h2>'. $page_title .'</h2>
						</div>
					</div>
				';
				}
			}
		    
		}
		else {
			if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
				$description = wc_format_content( term_description() );
				if ( $description ) {
					echo '<div class="page-header">
							<div class="container">
								<h2>'. $page_title .'</h2>
								' . $description . '
							</div>
						</div>
					';
				}
				else {
					echo '<div class="page-header">
						<div class="container">
							<h2>'. $page_title .'</h2>
						</div>
					</div>
				';
				}
			}
		    
		}
	}
}

$terms = get_terms( 'product_tag' );
$term_array = array();
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $term_array[] = $term->name;
    }
}

function give_profile_name(){
    $user=wp_get_current_user();
    if(!is_user_logged_in())
        $name = "Inloggen";
    else
         $name='Welkom '.$user->user_firstname.' '.$user->user_lastname; 
    return $name;
}

add_shortcode('profile_name', 'give_profile_name');

add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );
function my_dynamic_menu_items( $menu_items ) {
    foreach ( $menu_items as $menu_item ) {
        if ( '#profile_name#' == $menu_item->title ) {
            global $shortcode_tags;
            if ( isset( $shortcode_tags['profile_name'] ) ) {
                // Or do_shortcode(), if you must.
                $menu_item->title = call_user_func( $shortcode_tags['profile_name'] );
            }    
        }
    }

    return $menu_items;
} 