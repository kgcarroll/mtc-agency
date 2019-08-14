<?php 
/*
* Front page template
*
*/
get_header(); ?>
	<div id="home" class="container" role="main">
		<div class="content">
			<?php print_header('#content-container',null); ?>
			<div id="content-container">
				<?php print_callout(); ?>
				<?php print_featured_case_study(); ?>
				<?php print_posts('3','0',null); ?>
				<?php print_carousels(); ?>
				<?php print_IG_section(); ?>
				<?php print_homepage_careers(); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>