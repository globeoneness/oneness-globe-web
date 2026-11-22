<?php
/**
 * Renders the ONENESS GLOBE theme's real templates to static HTML, using a minimal WordPress
 * function stub (hooks, escaping, routing variables). It does NOT install WordPress.
 *
 * Usage:  php render-preview.php <theme_dir> <out_dir>
 *
 * It writes:
 *   <out>/index.html                      home page (front-page.php)
 *   <out>/products/<slug>/index.html      six product pages (single-og-product.php)
 *   <out>/products/no-such-product/...    404 check
 *   <out>/routes.json                     route regex test + page list
 */

if ( $argc < 3 ) {
	fwrite( STDERR, "usage: php render-preview.php <theme_dir> <out_dir>\n" );
	exit( 2 );
}

$theme = realpath( $argv[1] );
$out   = $argv[2];
if ( ! $theme || ! is_dir( $theme ) ) {
	fwrite( STDERR, "theme dir not found\n" );
	exit( 2 );
}
if ( ! is_dir( $out ) ) {
	mkdir( $out, 0775, true );
}

define( 'ABSPATH', dirname( $theme ) . '/' );

$GLOBALS['og_theme']   = $theme;
$GLOBALS['og_prefix']  = '';
$GLOBALS['og_query']   = array();
$GLOBALS['og_hooks']   = array();
$GLOBALS['og_options'] = array();
$GLOBALS['og_status']  = 200;
$GLOBALS['og_admin']   = true; // preview only: lets the admin-only literature notes render
$GLOBALS['wp_query']   = null;
$GLOBALS['og_rewrites'] = array();

/* ---------------- minimal WordPress API ---------------- */

function add_action( $hook, $cb, $priority = 10, $args = 1 ) {
	$GLOBALS['og_hooks'][ $hook ][] = $cb;
	return true;
}
function add_filter( $hook, $cb, $priority = 10, $args = 1 ) {
	return add_action( $hook, $cb, $priority, $args );
}
function do_action( $hook, ...$args ) {
	foreach ( $GLOBALS['og_hooks'][ $hook ] ?? array() as $cb ) {
		call_user_func_array( $cb, $args );
	}
}
function apply_filters( $hook, $value, ...$args ) {
	foreach ( $GLOBALS['og_hooks'][ $hook ] ?? array() as $cb ) {
		$value = call_user_func_array( $cb, array_merge( array( $value ), $args ) );
	}
	return $value;
}
function add_theme_support( $f, ...$a ) { return true; }
function load_theme_textdomain( ...$a ) { return true; }
function get_template_directory() { return $GLOBALS['og_theme']; }
function get_option( $k, $d = false ) { return $GLOBALS['og_options'][ $k ] ?? $d; }
function update_option( $k, $v ) { $GLOBALS['og_options'][ $k ] = $v; return true; }
function add_rewrite_rule( $regex, $redirect, $after = 'bottom' ) { $GLOBALS['og_rewrites'][] = array( $regex, $redirect ); }
function flush_rewrite_rules( $hard = true ) { return true; }
function wp_enqueue_style( ...$a ) { return true; }
function wp_enqueue_script( ...$a ) { return true; }
function get_theme_mod( $k, $d = false ) { return $d; }
function current_user_can( $cap ) { return (bool) $GLOBALS['og_admin']; }
function status_header( $code ) { $GLOBALS['og_status'] = (int) $code; }
function nocache_headers() { return true; }
function wp_unslash( $v ) { return $v; }
function sanitize_title( $t ) { return strtolower( trim( preg_replace( '/[^A-Za-z0-9_-]+/', '-', (string) $t ), '-' ) ); }
function esc_html( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' ); }
function esc_url( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' ); }
function get_query_var( $v, $d = '' ) { return $GLOBALS['og_query'][ $v ] ?? $d; }
function get_stylesheet_uri() { return base_url() . 'theme/style.css'; }
function get_template_directory_uri() { return base_url() . 'theme'; }
function base_url() { return '' === $GLOBALS['og_prefix'] ? './' : $GLOBALS['og_prefix']; }
function home_url( $path = '/' ) { return base_url() . ltrim( (string) $path, '/' ); }
function bloginfo( $what ) { echo 'charset' === $what ? 'UTF-8' : ''; }
function language_attributes() { echo 'lang="en-US"'; }
function body_class() { echo 'class="og-preview"'; }
function have_posts() { return false; }
function get_template_part( $slug ) { include $GLOBALS['og_theme'] . '/' . $slug . '.php'; }
function get_header( $name = null ) { include $GLOBALS['og_theme'] . '/header.php'; }
function get_footer( $name = null ) { include $GLOBALS['og_theme'] . '/footer.php'; }
function wp_safe_redirect( $url, $status = 302 ) { $GLOBALS['og_redirect'] = array( $url, $status ); return true; }
function wp_head() {
	do_action( 'wp_head' );
	echo '<title>' . esc_html( $GLOBALS['og_title'] ?? 'ONENESS GLOBE' ) . "</title>\n";
	echo '<link rel="stylesheet" href="' . esc_url( get_stylesheet_uri() ) . '">' . "\n";
	echo "<style>.og-preview-bar{position:sticky;top:0;z-index:999;background:#071d42;color:#fff;font:600 12px/1.4 system-ui,sans-serif;padding:8px 12px;display:flex;flex-wrap:wrap;gap:6px 14px;align-items:center}.og-preview-bar a{color:#9fd8ea;text-decoration:none}.og-preview-bar b{letter-spacing:.06em}</style>\n";
}
function wp_footer() {
	do_action( 'wp_footer' );
	echo '<script src="' . esc_url( get_template_directory_uri() . '/assets/js/og.js' ) . '"></script>' . "\n";
}
function wp_body_open() { do_action( 'wp_body_open' ); }
function the_title() { echo ''; }
function the_content() { echo ''; }
function the_post() {}


/* Media Library stand-in: set $GLOBALS['og_media'] = array( 'file-name.pdf' => 'url' ) to simulate uploads. */
if ( ! defined( 'DAY_IN_SECONDS' ) ) { define( 'DAY_IN_SECONDS', 86400 ); }
$GLOBALS['og_media']      = array();
$GLOBALS['og_transients'] = array();
function get_transient( $k ) { return $GLOBALS['og_transients'][ $k ] ?? false; }
function set_transient( $k, $v, $t = 0 ) { $GLOBALS['og_transients'][ $k ] = $v; return true; }
function delete_transient( $k ) { unset( $GLOBALS['og_transients'][ $k ] ); return true; }
function get_posts( $args ) {
	$needle = $args['meta_query'][0]['value'] ?? '';
	$ids = array();
	foreach ( array_keys( $GLOBALS['og_media'] ) as $i => $file ) {
		if ( '' !== $needle && false !== strpos( $file, $needle ) ) { $ids[] = $i; }
	}
	return array_slice( $ids, 0, 1 );
}
function wp_get_attachment_url( $id ) { $v = array_values( $GLOBALS['og_media'] ); return $v[ $id ] ?? false; }

/* Title filter needs the slug to be set before wp_head runs. */
function og_title_for( $slug ) {
	$all = og_get_products();
	return isset( $all[ $slug ] ) ? $all[ $slug ]['name'] . ' — Veterinary Product Literature | ONENESS GLOBE' : 'ONENESS GLOBE';
}

/* Preview-only navigation bar (not part of the theme). */
add_action(
	'wp_body_open',
	function () {
		$base = $GLOBALS['og_prefix'];
		$b    = '' === $base ? './' : $base;
		echo '<div class="og-preview-bar"><b>PREVIEW — not the live site</b>';
		echo '<a href="' . $b . '">Home</a>';
		foreach ( og_get_products() as $slug => $p ) {
			echo '<a href="' . $b . 'products/' . $slug . '/">' . htmlspecialchars( $p['name'] ) . '</a>';
		}
		echo '</div>';
	}
);

/* ---------------- load the theme's own functions ---------------- */

require $theme . '/functions.php';

// Optional: simulate PDFs uploaded to the Media Library (env OG_MEDIA_BASE=https://site/wp-content/uploads/2026/11/).
if ( getenv( 'OG_MEDIA_BASE' ) ) {
	foreach ( og_get_products() as $mp ) {
		$GLOBALS['og_media'][ basename( $mp['pdf'] ) ] = getenv( 'OG_MEDIA_BASE' ) . basename( $mp['pdf'] );
	}
}

do_action( 'after_setup_theme' );
do_action( 'init' );

/* ---------------- routing checks ---------------- */

$routes = array( 'rewrite_rules' => $GLOBALS['og_rewrites'], 'checks' => array() );
$pattern = '#^products/([^/]+)/?$#';
$slugs   = array_keys( og_get_products() );
foreach ( $slugs as $slug ) {
	$ok = preg_match( $pattern, 'products/' . $slug . '/', $m ) && $m[1] === $slug;
	$routes['checks'][ 'products/' . $slug . '/' ] = $ok ? 'matched' : 'FAILED';
}
$routes['checks']['products/one-immune'] = preg_match( $pattern, 'products/one-immune', $m ) ? 'matched (no trailing slash)' : 'no match';
$routes['checks']['products/'] = preg_match( $pattern, 'products/', $m ) ? 'MATCHED (bad)' : 'no match (good)';

/* ---------------- render helper ---------------- */

function og_render_to( $file, $prefix, $callback ) {
	$GLOBALS['og_prefix'] = $prefix;
	$GLOBALS['og_status'] = 200;
	ob_start();
	$callback();
	$html = ob_get_clean();
	if ( ! is_dir( dirname( $file ) ) ) {
		mkdir( dirname( $file ), 0775, true );
	}
	file_put_contents( $file, $html );
	return array( 'file' => $file, 'status' => $GLOBALS['og_status'], 'bytes' => strlen( $html ) );
}

$pages = array();

// Home page.
$GLOBALS['og_query'] = array();
$GLOBALS['og_title'] = 'ONENESS GLOBE — Veterinary Product Portfolio';
$pages[]             = og_render_to(
	$out . '/index.html',
	'',
	function () use ( $theme ) {
		include $theme . '/front-page.php';
	}
);

// Six product pages + one unknown slug (404).
foreach ( array_merge( $slugs, array( 'no-such-product' ) ) as $slug ) {
	$GLOBALS['og_query'] = array( 'og_product' => $slug );
	$GLOBALS['og_title'] = og_title_for( $slug );
	$pages[]             = og_render_to(
		$out . '/products/' . $slug . '/index.html',
		'../../',
		function () use ( $theme ) {
			include $theme . '/single-og-product.php';
		}
	);
}

// Old query-string redirect (/?og_product=slug -> /products/slug/) calls exit() in the theme,
// so it is verified in a separate PHP process by tools/check-redirect.php.
$routes['pages'] = $pages;
file_put_contents( $out . '/routes.json', json_encode( $routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );

echo "rendered " . count( $pages ) . " pages into {$out}\n";
echo "rewrite rules: " . json_encode( $GLOBALS['og_rewrites'] ) . "\n";
foreach ( $routes['checks'] as $k => $v ) {
	echo str_pad( $k, 32 ) . $v . "\n";
}
