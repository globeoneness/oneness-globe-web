<?php
/**
 * Product detail page: /products/{slug}/
 *
 * @package oneness-globe
 */

$og_slug     = (string) get_query_var( 'og_product' );
$og_products = og_get_products();

if ( '' === $og_slug || ! isset( $og_products[ $og_slug ] ) ) {
	global $wp_query;
	if ( $wp_query ) {
		$wp_query->set_404();
	}
	status_header( 404 );
	nocache_headers();
	get_template_part( '404' );
	return;
}

$p       = $og_products[ $og_slug ];
$order   = og_whatsapp_url( og_order_message( $p ) );
$img_url = get_template_directory_uri() . '/assets/' . $p['photo'];
$lit_url = get_template_directory_uri() . '/assets/' . $p['literature'];
$pdf_url = get_template_directory_uri() . '/assets/' . $p['pdf'];

get_header();
?>
<nav class="crumbs container" aria-label="Breadcrumb">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
	<span aria-hidden="true">/</span>
	<a href="<?php echo esc_url( home_url( '/#products' ) ); ?>">Products</a>
	<span aria-hidden="true">/</span>
	<span aria-current="page"><?php echo esc_html( $p['name'] ); ?></span>
</nav>

<article class="pdp">
	<section class="pdp-hero">
		<div class="container pdp-hero-grid">
			<figure class="pdp-photo">
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $p['photo_alt'] ); ?>" width="900" height="900">
			</figure>
			<div class="pdp-summary">
				<div class="micro"><?php echo esc_html( $p['category'] ); ?></div>
				<h1><?php echo esc_html( $p['name'] ); ?></h1>
				<p class="pdp-tagline"><?php echo esc_html( $p['tagline'] ); ?></p>
				<div class="pdp-facts">
					<div><span>PACK SIZE</span><strong><?php echo esc_html( $p['pack'] ); ?></strong></div>
					<div><span>SINGLE PACK MRP</span><strong>৳<?php echo esc_html( $p['mrp'] ); ?></strong></div>
				</div>
				<a class="btn-whatsapp" href="<?php echo esc_url( $order ); ?>" rel="noopener noreferrer" target="_blank">
					Order 1 single pack on WhatsApp
				</a>
				<p class="pdp-note">Tapping the button opens WhatsApp with this product and a quantity of one single pack. Nothing is ordered or paid for on this page.</p>
				<a class="btn-ghost" href="<?php echo esc_url( $pdf_url ); ?>" download>Download original PDF</a>
			</div>
		</div>
	</section>

	<div class="container pdp-body">

		<?php og_render_review_notes( $p ); ?>

		<section class="pdp-section" aria-labelledby="sec-overview">
			<h2 id="sec-overview">Product overview</h2>
			<?php foreach ( $p['intro'] as $para ) : ?>
				<p class="lead"><?php echo esc_html( $para ); ?></p>
			<?php endforeach; ?>
		</section>

		<section class="pdp-section" aria-labelledby="sec-composition">
			<h2 id="sec-composition">Composition</h2>
			<?php og_render_composition( $p ); ?>
		</section>

		<?php if ( ! empty( $p['indications'] ) ) : ?>
		<section class="pdp-section" aria-labelledby="sec-indications">
			<h2 id="sec-indications">Indications and recommended uses</h2>
			<?php og_render_indications( $p ); ?>
		</section>
		<?php endif; ?>

		<?php if ( ! empty( $p['benefits'] ) ) : ?>
		<section class="pdp-section" aria-labelledby="sec-benefits">
			<h2 id="sec-benefits">Benefits and product features</h2>
			<?php og_render_benefits( $p ); ?>
		</section>
		<?php endif; ?>

		<section class="pdp-section" aria-labelledby="sec-species">
			<h2 id="sec-species">Species and animal categories</h2>
			<ul class="chips">
				<?php foreach ( $p['species'] as $species ) : ?>
					<li><?php echo esc_html( $species ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="pdp-section" aria-labelledby="sec-dosage">
			<h2 id="sec-dosage">Dosage and administration</h2>
			<?php og_render_dosage( $p ); ?>
		</section>

		<section class="pdp-section" aria-labelledby="sec-storage">
			<h2 id="sec-storage">Storage, shelf life and withdrawal</h2>
			<?php og_render_facts( $p ); ?>
		</section>

		<section class="pdp-section" aria-labelledby="sec-precautions">
			<h2 id="sec-precautions">Warnings and precautions</h2>
			<?php og_render_precautions( $p ); ?>
		</section>

		<section class="pdp-section" aria-labelledby="sec-company">
			<h2 id="sec-company">Manufacturer, importer and registration</h2>
			<?php og_render_company( $p ); ?>
		</section>

		<section class="pdp-section pdp-literature" id="literature" aria-labelledby="sec-literature">
			<h2 id="sec-literature">Original brochure artwork</h2>
			<p class="lead">The original pack artwork (front and back panels), shown unedited. Tap the image to zoom. The original PDF can be downloaded below.</p>
			<figure class="lit-figure">
				<a class="lit-zoom" href="<?php echo esc_url( $lit_url ); ?>" target="_blank" rel="noopener">
					<img src="<?php echo esc_url( $lit_url ); ?>" alt="<?php echo esc_attr( $p['literature_alt'] ); ?>" width="<?php echo esc_attr( $p['literature_w'] ); ?>" height="<?php echo esc_attr( $p['literature_h'] ); ?>" loading="lazy">
					<span class="lit-zoom-hint">Tap to zoom</span>
				</a>
			</figure>
			<div class="lit-actions">
				<a class="btn-primary" href="<?php echo esc_url( $pdf_url ); ?>" download>Download PDF</a>
				<a class="btn-ghost" href="<?php echo esc_url( $lit_url ); ?>" target="_blank" rel="noopener">Open full-size artwork</a>
			</div>
		</section>

		<section class="pdp-cta">
			<div>
				<h2>Ready to order?</h2>
				<p>Send a WhatsApp message for one single pack of <?php echo esc_html( $p['name'] ); ?> (<?php echo esc_html( $p['pack'] ); ?>). Single pack MRP ৳<?php echo esc_html( $p['mrp'] ); ?>.</p>
			</div>
			<a class="btn-whatsapp" href="<?php echo esc_url( $order ); ?>" rel="noopener noreferrer" target="_blank">Order on WhatsApp</a>
		</section>

		<p class="back-link"><a href="<?php echo esc_url( home_url( '/#products' ) ); ?>">← Back to all products</a></p>
	</div>
</article>

<dialog class="og-lightbox" id="og-lightbox" aria-label="Brochure artwork, zoomed">
	<div class="og-lb-bar">
		<button type="button" class="og-lb-zoom" data-og-lb-zoom>Zoom in</button>
		<button type="button" class="og-lb-close" data-og-lb-close>Close</button>
	</div>
	<div class="og-lb-scroll"><img alt=""></div>
</dialog>
<?php
get_footer();
