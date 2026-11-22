<?php
/**
 * HTML renderers for product-detail sections. Every value is escaped on output.
 *
 * @package oneness-globe
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Composition: table (with optional group rows) or plain ingredient list.
 *
 * @param array $p Product record.
 */
function og_render_composition( $p ) {
	$c = $p['composition'];
	if ( ! empty( $c['basis'] ) ) {
		echo '<p class="spec-basis">' . esc_html( $c['basis'] ) . '</p>';
	}

	if ( 'list' === $c['type'] ) {
		echo '<ul class="ingredient-list">';
		foreach ( $c['items'] as $item ) {
			echo '<li>' . esc_html( $item ) . '</li>';
		}
		echo '</ul>';
	} else {
		echo '<div class="table-wrap"><table class="spec-table">';
		echo '<thead><tr><th scope="col">Ingredient</th><th scope="col">Amount</th></tr></thead><tbody>';
		foreach ( $c['groups'] as $group ) {
			if ( ! empty( $group['title'] ) ) {
				echo '<tr class="group-row"><th colspan="2" scope="colgroup">' . esc_html( $group['title'] ) . '</th></tr>';
			}
			foreach ( $group['rows'] as $row ) {
				echo '<tr><td>' . esc_html( $row[0] ) . '</td><td class="amount">' . esc_html( $row[1] ) . '</td></tr>';
			}
		}
		echo '</tbody></table></div>';
	}

	if ( ! empty( $c['note'] ) ) {
		echo '<p class="spec-note">' . esc_html( $c['note'] ) . '</p>';
	}
}

/**
 * Indication cards (title, optional paragraph, optional bullets).
 *
 * @param array $p Product record.
 */
function og_render_indications( $p ) {
	if ( empty( $p['indications'] ) ) {
		return;
	}
	echo '<div class="info-grid">';
	foreach ( $p['indications'] as $block ) {
		echo '<div class="info-card">';
		if ( ! empty( $block['title'] ) ) {
			echo '<h3>' . esc_html( $block['title'] ) . '</h3>';
		}
		if ( ! empty( $block['text'] ) ) {
			echo '<p>' . esc_html( $block['text'] ) . '</p>';
		}
		if ( ! empty( $block['items'] ) ) {
			echo '<ul class="check-list">';
			foreach ( $block['items'] as $item ) {
				echo '<li>' . esc_html( $item ) . '</li>';
			}
			echo '</ul>';
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Benefit groups.
 *
 * @param array $p Product record.
 */
function og_render_benefits( $p ) {
	if ( empty( $p['benefits'] ) ) {
		return;
	}
	echo '<div class="info-grid">';
	foreach ( $p['benefits'] as $block ) {
		echo '<div class="info-card">';
		if ( ! empty( $block['title'] ) ) {
			echo '<h3>' . esc_html( $block['title'] ) . '</h3>';
		}
		if ( ! empty( $block['text'] ) ) {
			echo '<p>' . esc_html( $block['text'] ) . '</p>';
		}
		if ( ! empty( $block['items'] ) ) {
			echo '<ul class="check-list">';
			foreach ( $block['items'] as $item ) {
				echo '<li>' . esc_html( $item ) . '</li>';
			}
			echo '</ul>';
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Dosage table with intro and notes.
 *
 * @param array $p Product record.
 */
function og_render_dosage( $p ) {
	$d = $p['dosage'];
	if ( ! empty( $d['intro'] ) ) {
		echo '<p class="spec-basis">' . esc_html( $d['intro'] ) . '</p>';
	}
	echo '<div class="table-wrap"><table class="spec-table dosage-table"><tbody>';
	foreach ( $d['rows'] as $row ) {
		echo '<tr><th scope="row">' . esc_html( $row[0] ) . '</th><td>' . esc_html( $row[1] ) . '</td></tr>';
	}
	echo '</tbody></table></div>';
	if ( ! empty( $d['notes'] ) ) {
		echo '<ul class="spec-notes">';
		foreach ( $d['notes'] as $note ) {
			echo '<li>' . esc_html( $note ) . '</li>';
		}
		echo '</ul>';
	}
}

/**
 * Storage, shelf life, withdrawal, origin and packing.
 *
 * @param array $p Product record.
 */
function og_render_facts( $p ) {
	echo '<dl class="facts-grid">';
	foreach ( $p['facts'] as $fact ) {
		echo '<div><dt>' . esc_html( $fact['label'] ) . '</dt><dd>' . esc_html( $fact['value'] ) . '</dd></div>';
	}
	echo '</dl>';
}

/**
 * Precautions and veterinary notices.
 *
 * @param array $p Product record.
 */
function og_render_precautions( $p ) {
	if ( empty( $p['precautions'] ) ) {
		return;
	}
	echo '<ul class="warn-list">';
	foreach ( $p['precautions'] as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ul>';
}

/**
 * Manufacturer, importer, contact and registration.
 *
 * @param array $p Product record.
 */
function og_render_company( $p ) {
	$phone = '+8801339562576';
	echo '<dl class="company-grid">';
	echo '<div><dt>A product of</dt><dd>' . esc_html( $p['manufacturer'] ) . '</dd></div>';
	echo '<div><dt>Import &amp; marketed by</dt><dd>';
	foreach ( $p['importer'] as $line ) {
		echo '<span class="line">' . esc_html( $line ) . '</span>';
	}
	echo '</dd></div>';
	echo '<div><dt>Contact</dt><dd>';
	echo '<a href="tel:' . esc_attr( $phone ) . '">+8801339-562576</a> · ';
	echo '<a href="mailto:globeoneness@gmail.com">globeoneness@gmail.com</a> · ';
	echo '<a href="https://www.onenessglobe.com" rel="noopener noreferrer" target="_blank">www.onenessglobe.com</a>';
	echo '</dd></div>';
	echo '<div><dt>Registration</dt><dd class="reg">' . esc_html( $p['registration'] ) . '</dd></div>';
	echo '</dl>';
	if ( ! empty( $p['badges'] ) ) {
		echo '<p class="badge-line">Printed on pack artwork: ' . esc_html( implode( ' · ', $p['badges'] ) ) . '</p>';
	}
}

/**
 * Internal literature-check notes. Shown only to logged-in administrators.
 *
 * @param array $p Product record.
 */
function og_render_review_notes( $p ) {
	if ( empty( $p['review'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	echo '<aside class="og-review" aria-label="Literature check notes (administrators only)">';
	echo '<h2>Literature check notes (visible to administrators only)</h2><ul>';
	foreach ( $p['review'] as $note ) {
		echo '<li>' . esc_html( $note ) . '</li>';
	}
	echo '</ul></aside>';
}
