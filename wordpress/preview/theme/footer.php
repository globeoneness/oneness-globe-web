<?php
/**
 * Site footer: company details and contact.
 *
 * @package oneness-globe
 */
?>
</main>
<footer class="footer" id="contact">
	<div class="container">
		<div class="footer-main">
			<div>
				<div class="brand">
					<img alt="Oneness Globe logo" width="48" height="48" src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.webp' ); ?>">
					<div>
						<div class="brand-name">ONENESS GLOBE</div>
						<div class="brand-sub">EMPOWERED BY UNITY</div>
					</div>
				</div>
				<p>212/C, Bishow Bank Colony,<br>Akborshah, Chattogram-4207, Bangladesh</p>
			</div>
			<div class="footer-contact">
				<strong>CONNECT WITH US</strong><br>
				<a href="tel:+8801339562576">+8801339-562576</a><br>
				<a href="mailto:globeoneness@gmail.com">globeoneness@gmail.com</a><br>
				<a href="https://www.onenessglobe.com" rel="noopener noreferrer" target="_blank">www.onenessglobe.com</a>
			</div>
		</div>
		<div class="legal">© <?php echo esc_html( gmdate( 'Y' ) ); ?> ONENESS GLOBE. Prices shown are single-pack MRPs, not wholesale quotations. Certifications and therapeutic claims appearing on original packaging have not been independently verified by this website.</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
