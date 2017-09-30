<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package solid
 */
global $solid_option;

?>

	<div id="footerwrap">
	 	<div class="container">
	 	<?php if ( is_active_sidebar( 'sidebar-footer' ) ) { ?>
		 	<div class="row">
		 		<?php dynamic_sidebar( 'sidebar-footer' ); ?>
		 	</div><!--/row -->
		<?php } ?>
		<?php if($solid_option['footer-copy'] != ''): ?>
		 	<div class="row">
		 		<div class="col-lg-12">
		 			<p><?php echo esc_html($solid_option['footer-copy']); ?></p>
		 		</div>
		 	</div>
		<?php endif; ?>
	 	</div><!--/container -->
	 </div><!--/footerwrap -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
