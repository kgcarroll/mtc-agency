<?php
/*
* Category page template
*
*/
get_header(); ?>
    <div id="category" class="container">

    	<?php print_options_header('blog'); ?>
    	<div class="category-dropdown">
				<?php wp_dropdown_categories('show_option_all=All');?>
    	</div>
    	<?php
    		// Get some info.
    		$category = get_queried_object();
    		$cat = $category->category_nicename;
    		print_posts('999','0',$cat);
    	?>

    	<?php print_callout_cards('options'); ?>
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