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
<div class="wrapper" id="page-wrapper">	

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-8">

				<?php

					/*
					*  Loop through post objects (assuming this is a multi-select field) ( setup postdata )
					*  Using this method, you can use all the normal WP functions as the $post object is temporarily initialized within the loop
					*  Read more: http://codex.wordpress.org/Template_Tags/get_posts#Reset_after_Postlists_with_offset
					*/

					$post_objects = get_field('producten_home');

					if( $post_objects ): ?>
						<ul class="home-products">
						<?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
							<?php setup_postdata($post); ?>
							<li class="row">
								<div class="col-md-3"><?php the_post_thumbnail(); ?></div>
								<div class="col">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<?php the_excerpt(); ?>
								</div>
							</li>
						<?php endforeach; ?>
						</ul>
						<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>	

					<?php endif;

					?>

			</div>
			<div class="col">
				
			</div>

		</div><!-- .row -->

	</div><!-- Container end -->

	<div class="clients_home">
		<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
		
			<div class="row">
				<div class=" clients_title">
					<h3><?php the_field('clients_title'); ?></h3>
					<h4>Bekijk hieronder een greep van onze klanten</h4>
				</div>
			</div>
			<div class="row">
				<div class="col">
				
					<?php

						$post_objects = get_field('clients_home');

						if( $post_objects ): ?>
							<ul class="client_list">
							<?php foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) ?>
								<?php setup_postdata($post); ?>
								<li class="row">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>">
										<img src="<?php the_field('item_afbeelding'); ?>" />
									</a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>	

						<?php endif;

						?>
				</div>
			</div>
		
		</div><!-- Container end -->
	</div>
	
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
										<img src="<?php the_field('item_afbeelding'); ?>" />
									</a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>	

						<?php endif;

						?>
				</div>
			</div>
		
		</div><!-- Container end -->
	</div>

</div><!-- Wrapper end -->

<?php get_footer(); ?>

