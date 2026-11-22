/*
 * ONENESS GLOBE — small progressive enhancements.
 * The site works without this file: every link and button is a real link.
 */
(function () {
	'use strict';

	// 1. Product cards: tapping the card (not a button or link inside it) opens the product page.
	document.querySelectorAll('.product[data-product-url]').forEach(function (card) {
		card.addEventListener('click', function (event) {
			if (event.target.closest('a, button')) {
				return;
			}
			window.location.href = card.getAttribute('data-product-url');
		});
	});

	// 2. Brochure zoom: opens the artwork in a full-screen dialog. Without <dialog> support,
	//    the link simply opens the full-size image in a new tab.
	var dialog = document.getElementById('og-lightbox');
	if (!dialog || typeof dialog.showModal !== 'function') {
		return;
	}

	var image = dialog.querySelector('img');
	var zoomButton = dialog.querySelector('[data-og-lb-zoom]');
	var closeButton = dialog.querySelector('[data-og-lb-close]');
	var zoomed = false;

	function setZoom(on) {
		zoomed = on;
		image.classList.toggle('is-big', on);
		zoomButton.textContent = on ? 'Zoom out' : 'Zoom in';
	}

	document.querySelectorAll('a.lit-zoom').forEach(function (link) {
		link.addEventListener('click', function (event) {
			event.preventDefault();
			var thumb = link.querySelector('img');
			image.src = link.getAttribute('href');
			image.alt = thumb ? thumb.alt : '';
			setZoom(false);
			dialog.showModal();
		});
	});

	zoomButton.addEventListener('click', function () {
		setZoom(!zoomed);
	});
	closeButton.addEventListener('click', function () {
		dialog.close();
	});
	dialog.addEventListener('click', function (event) {
		if (event.target === dialog) {
			dialog.close();
		}
	});
	dialog.addEventListener('close', function () {
		image.removeAttribute('src');
	});
})();
