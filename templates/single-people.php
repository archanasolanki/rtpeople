<?php
/*
 * Template part to diaply single post
 * 
 * @link  https://codex.wordpress.org/Template_Hierarchy
 */

get_header();
?>

<div id="main-content" class="main-content">
	<?php
	$args = array( 'post_type' => 'people', 'posts_per_page' => 1 );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
		?>
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<h1><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div><!-- #content -->
		</div><!-- #primary -->
	<?php endwhile; ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
