<?php
/**
 * Home page: product collection, coming soon, purpose.
 *
 * @package oneness-globe
 */

get_header();

$products = og_get_products();

$summaries = array(
	'one-immune'      => 'Synbiotic immune-support formulation with probiotics, prebiotics, enzymes, lysozyme, vitamins and antioxidants.',
	'grow-pro'        => 'A premix of multivitamins, multiminerals and amino acids for poultry and all livestock species.',
	'essenguard-plus' => 'A molecular-coated blend of essential oils and organic acids for gut health, antibiotic-free.',
	'livren-g'        => 'An oral liver and kidney support solution for poultry and livestock, for veterinary use.',
	'optiacid'        => 'A water purifier and acidifier with organic acids and copper sulfate for poultry, livestock and aquaculture.',
	'mycoclean-plus'  => 'A mycotoxin binder combining enzymes, probiotics and prebiotics, for poultry, ducks and cattle.',
);

$number = 0;
?>
<section class="section" id="products">
	<div class="container">
		<div class="section-head">
			<div class="micro">THE ONENESS COLLECTION</div>
			<h2>Explore Our Products</h2>
			<p>Explore our curated veterinary nutrition and animal-care portfolio. Every product is presented with clear packaging information and transparent single-pack pricing.</p>
		</div>

		<div class="grid">
			<?php
			foreach ( $products as $slug => $p ) :
				$number++;
				$url = og_product_url( $slug );
				?>
				<article class="product" data-product-url="<?php echo esc_url( $url ); ?>">
					<a class="product-photo-link" href="<?php echo esc_url( $url ); ?>" tabindex="-1" aria-hidden="true">
						<div class="product-photo">
							<span class="product-index"><?php echo esc_html( sprintf( '%02d / 06', $number ) ); ?></span>
							<img alt="<?php echo esc_attr( $p['photo_alt'] ); ?>" loading="lazy" width="900" height="900" src="<?php echo esc_url( get_template_directory_uri() . '/assets/' . $p['photo'] ); ?>">
						</div>
					</a>
					<div class="product-body">
						<div class="product-kind">VETERINARY PRODUCT PORTFOLIO</div>
						<h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $p['name'] ); ?></a></h3>
						<p class="product-description"><?php echo esc_html( $summaries[ $slug ] ); ?></p>
						<div class="data-line">
							<div><span>PACK SIZE</span><strong><?php echo esc_html( $p['pack'] ); ?></strong></div>
							<div><span>SINGLE PACK MRP</span><strong>৳<?php echo esc_html( $p['mrp'] ); ?></strong></div>
						</div>
						<div class="card-actions">
							<a class="order" href="<?php echo esc_url( og_whatsapp_url( og_order_message( $p ) ) ); ?>" rel="noopener noreferrer" target="_blank">Order on WhatsApp</a>
							<a class="details-link" href="<?php echo esc_url( $url ); ?>">View product details →</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section upcoming-section" id="upcoming">
	<div class="container">
		<div class="section-head">
			<div class="micro">WHAT’S NEXT</div>
			<h2>Coming Soon</h2>
			<p>A first look at two upcoming additions to the ONENESS GLOBE collection.</p>
		</div>
		<div class="grid upcoming-grid">
			<article class="product upcoming-product">
				<div class="product-photo upcoming-photo">
					<span class="upcoming-badge">COMING SOON</span>
					<img alt="HEAT STRESS PRO product packaging" loading="lazy" width="679" height="900" src="<?php echo esc_url( get_template_directory_uri() . '/assets/products/heat-stress-pro.webp' ); ?>">
				</div>
				<div class="product-body">
					<div class="product-kind">UPCOMING PRODUCT</div>
					<h3>HEAT STRESS PRO</h3>
					<p class="product-description">Heat-stress nutritional support formula for poultry and livestock.</p>
					<div class="upcoming-meta"><span>PACK SIZE</span><strong>100 gm</strong></div>
					<div class="upcoming-status">Launching soon · Price to be announced</div>
					<span class="upcoming-button">Coming Soon</span>
				</div>
			</article>
			<article class="product upcoming-product">
				<div class="product-photo upcoming-photo">
					<span class="upcoming-badge">COMING SOON</span>
					<img alt="VIRACARE product packaging" loading="lazy" width="768" height="1024" src="<?php echo esc_url( get_template_directory_uri() . '/assets/products/viracare.webp' ); ?>">
				</div>
				<div class="product-body">
					<div class="product-kind">UPCOMING PRODUCT</div>
					<h3>VIRACARE</h3>
					<p class="product-description">Phytogenic nutritional support supplement for poultry and birds.</p>
					<div class="upcoming-meta"><span>PACK SIZE</span><strong>100 gm</strong></div>
					<div class="upcoming-status">Launching soon · Price to be announced</div>
					<span class="upcoming-button">Coming Soon</span>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="purpose" id="purpose">
	<div class="container">
		<div class="section-head">
			<div class="micro">THE PRINCIPLES THAT GUIDE US</div>
			<h2>Driven by a Greater Purpose</h2>
			<p>Working toward healthier animals, more productive farms, and a better future for the livestock community.</p>
		</div>
		<div class="purpose-grid">
			<div class="purpose-card"><div class="purpose-icon">◎</div><h3>Our Aim</h3><p>To make veterinary healthcare solutions more accessible and support healthier, more productive livestock and poultry farming.</p></div>
			<div class="purpose-card"><div class="purpose-icon">✧</div><h3>Our Mission</h3><p>To connect farmers and animal healthcare professionals with practical veterinary nutrition and health solutions, supported by responsible service.</p></div>
			<div class="purpose-card"><div class="purpose-icon">◇</div><h3>Our Vision</h3><p>To become a trusted name in animal healthcare, contributing to sustainable farming and stronger agricultural communities.</p></div>
		</div>
	</div>
</section>
<?php
get_footer();
