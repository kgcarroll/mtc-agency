<?php 
/*
* Template Name: Contact
*
*/
get_header(); ?>
  <div id="contact" class="container" role="main">
    <div class="content">
    	<?php print_small_header(); ?>
    	<div class="content-container">
				<?php print_contact_content(); ?>
    		<?php print_callout_cards(null); ?>
    </div>
  </div>
<?php get_footer(); ?>