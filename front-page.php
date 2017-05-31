<?php
/**
 * The template for displaying the front page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

?>

<!-- Home hero -->
<div class="home-hero">

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
	<div class="row">
		<div class="col-md-8">
		<?php the_field('home_hero_tekst'); ?>
		</div>
		<div class="col home-hero-image">
		<?php
		$image = get_field('home_hero_afbeelding');

		if( !empty($image) ): ?>

			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

		<?php endif; ?>
		</div>
		</div>
	</div>
	
</div>
<!-- End of home hero -->
<!-- Beginning of home content -->
<div class="wrapper home-page woocommerce" id="page-wrapper">	

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-9">

				<?php

					/*
					*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
					*  Using this method, you can use all the normal WP functions as the $post object is temporarily initialized within the loop
					*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
					*/

					$post_objects = get_field('producten_home');

					if( $post_objects ): ?>
						<ul class="products home-products">
						<?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
							<?php setup_postdata($post); ?>
							<li class="product">
								<a href="<?php echo get_permalink( $id, $context ); ?> ">
								<div class="imagewrapper">
									<?php the_post_thumbnail(); ?>
									<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
								</div>
								<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
								<div class="woocommerce-product-details__short-description">
									<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
								</div>
								</a>
								<?php if ( $price_html = $product->get_price_html() ) : ?>
									<span class="price"><?php echo $price_html; ?></span>
								<?php endif; ?>
								<?php
								global $product;

									echo apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'button product_type_simple add_to_cart_button ajax_add_to_cart' ),
											esc_html( $product->add_to_cart_text() )
										),
									$product );
								?>
							</li>
						<?php endforeach; ?>
						</ul>
						<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>	

					<?php endif;

					?>

			</div>
			<div class="col opleidingen-home">
				<h2>Deze opleidingen gaan binnenkort van start</h2>
			</div>

		</div><!-- .row -->

	</div><!-- Container end -->
	
		<div class="team_home">
		<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
		
			<div class="row">
				<div class="team_title">
					<?php the_field('team_dfo'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col">
				
					<?php

						$post_objects = get_field('team_home');

						if( $post_objects ): ?>
							<ul class="team_list">
							<?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
								<?php setup_postdata($post); ?>
								<li class="row">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
										<img src="<?php the_field('foto_team'); ?>" />
										<p><?php the_title(); ?></p>
									</a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>	

						<?php endif;

						?>
				</div>
			</div>
			<div class="row">
				<div class="title">
					<h3><?php the_field('clients_title'); ?></h3>
				</div>
			</div>
		
		</div><!-- Container end -->
	</div>

	<div class="contact_home">
		<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
		
			<div class="row">
				<div class=" contact_title">
					<h3><?php the_field('contact_title'); ?></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<?php the_field('adres_1'); ?>
				</div>
				<div class="col-md-4">
					<?php the_field('adres_2'); ?>
				</div>
				<div class="col-md-4">
					<?php the_field('adres_3'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<?php the_field('contact_text'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<br /><iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9788.844012746065!2d5.465621!3d52.166857!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6461e8b92bf4b%3A0xe4d2d369c8aa107c!2sDe+Wel+14%2C+3871+MV+Hoevelaken%2C+Nederland!5e0!3m2!1snl!2sus!4v1496049926582" width="100%" height="250" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
				</div>
			</div>
		
		</div><!-- Container end -->
	</div>

</div><!-- Wrapper end -->

<?php get_footer(); ?>

