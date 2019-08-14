<?php 
/*
* Template Name: Employee Bio
*
*/
get_header(); ?>
  <div id="employee-bio" class="container" role="main">
    <div class="content">
    	<div class="bio-header">
    		<?php print_profile_header(); ?>
    		<?php print_employee_content(); ?>
    		<?php print_posts('3','0',null); ?>
				<?php print_callout_cards(null); ?>
    	</div>
    </div>
  </div>
<?php get_footer(); ?>