<?php 
/*
* Template Name: About
*
*/
get_header(); ?>
  <div id="about" class="container" role="main">
  	<div class="content">
      <?php print_header('#content-container', null); ?>
  	  <div id="content-container">
    		<?php print_about_us_content(); ?>
        <?php print_icon_grid('capabilities'); ?>
    		<?php print_clients(); ?>
    		<?php print_gsa_callout(); ?>
    		<?php print_callout_cards(null); ?>
  	  </div>
  	</div>
  </div>
<?php get_footer(); ?>