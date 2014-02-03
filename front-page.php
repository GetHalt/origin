<?php
/**
 * Front page template.
 *
 * @package Origin
 */

get_header(); ?>

	<?php get_template_part( '_section', 'front-page' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="article-list grid">
				<?php
					$terms = get_terms( 'article_cat', array(
						'orderby' => 'name',
						'order'   => 'ASC'
					) );

					if ( $terms ) {
						foreach ( $terms as $term ) {
							$args = array(
								'post_type'   => 'article',
								'post_status' => 'publish',
								'tax_query'   => array(
									array(
										'taxonomy' => 'article_cat',
										'field'    => 'term_id',
										'terms'    => $term->term_id
									)
								)
							);

							$query = new WP_Query($args);

							if ( $query->have_posts() ) :

								echo "<ul class='unit one-of-three'>";

								echo "<h4 class='article-category-title'>{$term->name} <span class='article-count'>({$term->count})</span></h4>";

								while( $query->have_posts() ) : $query->the_post();
								?>

								<li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>

								<?php
								endwhile;

								echo "</ul>";

							endif;

						}
					}

					wp_reset_query();
				?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
