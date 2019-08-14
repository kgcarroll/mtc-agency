<?php 
/*
* Template Name: Case Study
*
*/
get_header(); ?>
  <div id="case-study" class="container" role="main">
	 	<div class="content">
	 		<?php $color = get_field('case_study_color'); ?>
	   	<?php print_header('#row-1', $color); ?>
	   	<div class="content-container">
	   	<?php print_case_study_content(); ?>
	   	<?php print_related_content(); ?>
	    </div>
		</div>
  </div>
<?php get_footer(); ?>