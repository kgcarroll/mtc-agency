<?php 
/*
* Basic default index template for the entire wordpress site
*
*/
get_header(); ?>
	<div id="blog" class="container">
    <div class="content">
	    <?php print_options_header('blog'); ?>
    	<div class="category-dropdown">
				<?php wp_dropdown_categories('show_option_all=Filter Categories');?>
    	</div>
	    <?php print_featured_post(); ?>
	    <?php print_posts('999','-1',null); ?>
	    <?php print_callout_cards('options'); ?>
    </div>
	</div>

	<script type="text/javascript">
		// Category Switcher.
		var dropdown = document.getElementById("cat");
		function onCatChange() {
			if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
				location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
			} else {
				location.href = "<?php echo esc_url( home_url( '/' ) ); ?>/blog";
			}
		}
		dropdown.onchange = onCatChange;
	</script>
<?php get_footer(); ?>