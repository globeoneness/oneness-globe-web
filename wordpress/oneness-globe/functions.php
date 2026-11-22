<?php
/**
 * ONENESS GLOBE theme setup: routing, assets, WhatsApp ordering and literature helpers.
 *
 * @package oneness-globe
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OG_VERSION', '2.0.3' );
define( 'OG_WHATSAPP_DEFAULT', '8801339562576' );

require_once get_template_directory() . '/inc/product-data.php';
require_once get_template_directory() . '/inc/render.php';

/* ------------------------------------------------------------------------ */
/* Theme setup                                                              */
/* ------------------------------------------------------------------------ */

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'oneness-globe-style', get_stylesheet_uri(), array(), OG_VERSION );
		wp_enqueue_script( 'oneness-globe-main', get_template_directory_uri() . '/assets/js/og.js', array(), OG_VERSION, true );
	}
);

/* ------------------------------------------------------------------------ */
/* Product routing: /products/{slug}/                                        */
/* ------------------------------------------------------------------------ */

add_action(
	'init',
	function () {
		add_rewrite_rule( '^products/([^/]+)/?$', 'index.php?og_product=$matches[1]', 'top' );

		// Re-save permalink rules once per theme version so updates take effect without a manual flush.
		if ( get_option( 'og_rewrite_version' ) !== OG_VERSION ) {
			flush_rewrite_rules( false );
			update_option( 'og_rewrite_version', OG_VERSION );
		}
	}
);

add_action(
	'after_switch_theme',
	function () {
		flush_rewrite_rules( false );
	}
);

add_filter(
	'query_vars',
	function ( $vars ) {
		$vars[] = 'og_product';
		return $vars;
	}
);

// Safety net: if the saved permalink rules do not include /products/{slug}/ yet, recognise it here
// instead of showing "Page not found".
add_filter(
	'request',
	function ( $query_vars ) {
		if ( ! empty( $query_vars['og_product'] ) || empty( $_SERVER['REQUEST_URI'] ) ) {
			return $query_vars;
		}
		$path = trim( (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$base = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		if ( '' !== $base && 0 === strpos( $path, $base . '/' ) ) {
			$path = substr( $path, strlen( $base ) + 1 );
		}
		if ( preg_match( '#^(?:index\.php/)?products/([^/]+)/?$#', $path, $m ) ) {
			$slug = sanitize_title( $m[1] );
			if ( isset( og_get_products()[ $slug ] ) ) {
				return array( 'og_product' => $slug );
			}
		}
		return $query_vars;
	}
);

add_filter(
	'template_include',
	function ( $template ) {
		if ( '' !== (string) get_query_var( 'og_product' ) ) {
			return get_template_directory() . '/single-og-product.php';
		}
		return $template;
	}
);

// Old links such as /?og_product=one-immune go to the permanent product URL (only when pretty permalinks are on).
add_action(
	'template_redirect',
	function () {
		if ( og_pretty_links() && isset( $_GET['og_product'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$slug     = sanitize_title( wp_unslash( $_GET['og_product'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$products = og_get_products();
			if ( isset( $products[ $slug ] ) ) {
				wp_safe_redirect( og_product_url( $slug ), 301 );
				exit;
			}
		}
	}
);

add_filter(
	'document_title_parts',
	function ( $parts ) {
		$slug = (string) get_query_var( 'og_product' );
		$all  = og_get_products();
		if ( '' !== $slug && isset( $all[ $slug ] ) ) {
			$parts['title'] = $all[ $slug ]['name'] . ' — Veterinary Product Literature';
		}
		return $parts;
	}
);

add_action(
	'wp_head',
	function () {
		$slug = (string) get_query_var( 'og_product' );
		$all  = og_get_products();
		if ( '' !== $slug && isset( $all[ $slug ] ) ) {
			$p = $all[ $slug ];
			echo '<link rel="canonical" href="' . esc_url( og_product_url( $slug ) ) . '">' . "\n";
			echo '<meta name="description" content="' . esc_attr( $p['name'] . ' (' . $p['pack'] . ') — ' . $p['category'] . '. Full literature, composition, dosage and company information from the original ONENESS GLOBE brochure.' ) . '">' . "\n";
		}
	}
);

/* ------------------------------------------------------------------------ */
/* Helpers                                                                  */
/* ------------------------------------------------------------------------ */

/**
 * Public URL of one product page.
 *
 * @param string $slug Product slug.
 * @return string
 */
function og_product_url( $slug ) {
	if ( og_pretty_links() ) {
		return home_url( '/products/' . rawurlencode( $slug ) . '/' );
	}
	// "Plain" permalinks: /products/... addresses do not reach WordPress, so use the query form.
	return add_query_arg( 'og_product', rawurlencode( $slug ), home_url( '/' ) );
}

/**
 * True when the site uses pretty permalinks (Settings > Permalinks is not "Plain").
 *
 * @return bool
 */
function og_pretty_links() {
	return '' !== (string) get_option( 'permalink_structure' );
}

/**
 * WhatsApp number used for every order button (digits only, country code included).
 *
 * @return string
 */
function og_whatsapp_number() {
	$number = preg_replace( '/\D+/', '', (string) get_theme_mod( 'og_whatsapp', OG_WHATSAPP_DEFAULT ) );
	return $number ? $number : OG_WHATSAPP_DEFAULT;
}

/**
 * Builds a wa.me link with a pre-written message. Nothing is sent until the customer taps Send in WhatsApp.
 *
 * @param string $text Message text.
 * @return string
 */
function og_whatsapp_url( $text ) {
	return 'https://wa.me/' . og_whatsapp_number() . '?text=' . rawurlencode( $text );
}

/**
 * Order message for one product, single-pack quantity only.
 *
 * @param array $p Product record.
 * @return string
 */
function og_order_message( $p ) {
	return "Hello ONENESS GLOBE, I would like to order:\n"
		. 'Product: ' . $p['name'] . "\n"
		. 'Pack size: ' . $p['pack'] . "\n"
		. "Quantity: 1 single pack\n"
		. 'Single pack MRP: ৳' . $p['mrp'] . "\n"
		. 'Please confirm availability and order details.';
}

/* ------------------------------------------------------------------------ */
/* Customizer: WhatsApp number (default is the official company number)     */
/* ------------------------------------------------------------------------ */

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'og_orders',
			array(
				'title'    => 'ONENESS GLOBE WhatsApp Orders',
				'priority' => 35,
			)
		);
		$wp_customize->add_setting(
			'og_whatsapp',
			array(
				'default'           => OG_WHATSAPP_DEFAULT,
				'sanitize_callback' => function ( $value ) {
					return preg_replace( '/\D+/', '', (string) $value );
				},
			)
		);
		$wp_customize->add_control(
			'og_whatsapp',
			array(
				'label'   => 'WhatsApp number (country code, digits only)',
				'section' => 'og_orders',
				'type'    => 'text',
			)
		);
	}
);

/* ------------------------------------------------------------------------ */
/* Literature PDF location                                                  */
/* ------------------------------------------------------------------------ */

/**
 * URL of a product's original literature PDF.
 *
 * Looks in the theme's assets/pdf/ folder first. If the PDF is not there (the small
 * "lite" theme package leaves PDFs out to keep the upload small), it looks in the
 * Media Library for a PDF whose file name contains the same name, for example
 * one-immune-literature.pdf. Returns '' when no PDF is found, so no broken link is shown.
 *
 * @param array $p Product record.
 * @return string
 */
function og_pdf_url( $p ) {
	if ( file_exists( get_template_directory() . '/assets/' . $p['pdf'] ) ) {
		return get_template_directory_uri() . '/assets/' . $p['pdf'];
	}

	$name = pathinfo( $p['pdf'], PATHINFO_FILENAME );
	$key  = 'og_pdf_' . $name;
	$url  = get_transient( $key );
	if ( is_string( $url ) && '' !== $url ) {
		return $url;
	}

	$found = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => '_wp_attached_file',
					'value'   => $name,
					'compare' => 'LIKE',
				),
			),
		)
	);

	$url = $found ? (string) wp_get_attachment_url( $found[0] ) : '';
	if ( '' !== $url ) {
		set_transient( $key, $url, DAY_IN_SECONDS );
	}
	return $url;
}

// Forget remembered PDF addresses whenever a Media Library file is added or deleted.
function og_forget_pdf_urls() {
	foreach ( og_get_products() as $p ) {
		delete_transient( 'og_pdf_' . pathinfo( $p['pdf'], PATHINFO_FILENAME ) );
	}
}
add_action( 'add_attachment', 'og_forget_pdf_urls' );
add_action( 'delete_attachment', 'og_forget_pdf_urls' );
