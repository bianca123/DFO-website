<?php
/**
 * Displays content for front page
 *
 * @package Understrap
 * @since 1.0
 * @version 1.0
 */

?>

<?php

$post_object = get_field('home-hero');

if( $post_object ): 

	// override $post
	$post = $post_object;
	setup_postdata( $post ); 

	?>
    <div>
    	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    	<?php
		the_excerpt();
		?>
    </div>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>