<?php
/**
 * Fallback template for pages and archives.
 *
 * @package oneness-globe
 */

get_header();
?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<h1><?php the_title(); ?></h1>
				<div class="entry-content"><?php the_content(); ?></div>
			<?php endwhile; ?>
		<?php else : ?>
			<h1>Nothing found</h1>
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Return to the ONENESS GLOBE home page</a>.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
