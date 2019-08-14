<?php 
/*
* Template Name: Careers Landing Page
*
*/
get_header(); ?>
  <div id="careers-landing" class="container" role="main">
    <div class="content">
      <?php print_small_img_header(); ?>
      <div class="content-container">
	      <?php print_callout(); ?>
	      <?php print_icon_grid('benefits'); ?>
	      <?php print_office_gallery(); ?> 
        <?php print_IG_section(); ?>
	      <?php print_callout_cards(null); ?>
      </div>
    </div>
  </div>
<?php get_footer(); ?>