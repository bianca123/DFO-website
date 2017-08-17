<?php
/**
 * The template for displaying Woocommerce pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

if (!class_exists('Timber')){
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}

/*	
global $wp; 
var_dump($wp);die();
*/

$context            = Timber::get_context();
$context['sidebar'] = Timber::get_widgets('shop-sidebar');

$category = get_the_category(); 
$category_parent_id = $category[0]->category_parent;

if ( $category_parent_id != 0 ) {
    $category_parent = get_term( $category_parent_id, 'category' );
    $css_slug = $category_parent->slug;
} else {
    $css_slug = $category[0]->slug;
}

if (is_singular('product')) {

    $context['post']    = Timber::get_post();
    $product            = wc_get_product( $context['post']->ID );
    $context['product'] = $product;

    Timber::render('templates/woo/single-product.twig', $context);

} else {


    $posts = Timber::get_posts();
	
		foreach( $posts as $id => $post ) {
			$post_id = $post->ID;
			$posts[$id]->custom['tags'] = get_the_terms( $post_id, 'product_tag' );

		}
	
    $context['products'] = $posts;
    if ( is_product_category() ) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $context['category'] = get_term( $term_id, 'product_cat' );
		$context['taxonomie'] = get_term( $term_id, 'product_tag' );
        $context['title'] = single_term_title('', false);
		$context['categories'] = Timber::get_terms('product_cat', array('parent' => $category));
		$context['taxonomies'] = Timber::get_terms('product_tag');
    }

    Timber::render('templates/woo/archive.twig', $context);
}