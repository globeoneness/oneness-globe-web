<?php
/**
 * Not-found page (also used for unknown product links).
 *
 * @package oneness-globe
 */

get_header();
?>
<section class="section">
	<div class="container not-found">
		<div class="micro">PAGE NOT FOUND</div>
		<h1>This page is not available</h1>
		<p>The product or page you requested does not exist. You can return to the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ONENESS GLOBE home page</a> or <a href="<?php echo esc_url( home_url( '/#products' ) ); ?>">browse all products</a>.</p>
	</div>
</section>
<?php
get_footer();
