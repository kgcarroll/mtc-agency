<?php 
/*
* Template Name: Employee Landing Page
*
*/
get_header(); ?>
  <div id="employees-landing" class="container" role="main">
    <div class="content">
      <?php print_header('#content-container', null); ?>
      <div class="content-container">
      	<?php print_employee_headline(); ?>
        <?php print_employee(); ?>
        <?php print_callout_cards(null); ?>
      </div>
    </div>
  </div>
<?php get_footer(); ?>