<?php 
/*
* Template Name: Portfolio Landing Page
*
*/
get_header(); ?>
  <div id="porfolio" class="container" role="main">
    <div class="content">
      <?php print_small_header(); ?>
      <div id="content-container">
        <?php print_case_studies(); ?>
      </div>
      <?php print_callout_cards(null); ?>
    </div>
  </div>
<?php get_footer(); ?>