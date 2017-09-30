<?php
/**
 * Template name: Home page for qoob
 */

get_header('home'); ?>

<?php
	while ( have_posts() ) : the_post();

			the_content();

	endwhile; // End of the loop.
	?>
<?php
get_footer('home');