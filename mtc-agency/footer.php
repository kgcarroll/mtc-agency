    <footer id="footer">
        <div class="content">

        <div class="footer-left column">
	        <div class="left-top">
		        <?php print_footer_logo(); ?>
		        <div class="mobile">
		        	<?php print_email(); ?>
		        	<?php print_phone_number(); ?>
		        </div>
		        <?php print_address(); ?>
		        <?php print_social(); ?>
	        </div>
	        <div class="left-bottom">
		        <?php print_email(); ?><span class="pipe"> | </span><?php print_phone_number(); ?>
		      </div>
        </div>
        


	      <div class="footer-right column">
	      	<div class="right-content">
		        <nav id="footer-navigation">
		          <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'footer_menu') ); ?>
		        </nav>

		        <?php echo '<div class="copyright">&copy; Copyright. <a href="/" class="name">'.get_field('company_name', 'options').'</a> '.date('Y').'</div>';?>
		      </div>
	        <?php print_gsa_icon(); ?>
				</div>

        </div>
    </footer>    
	<?php wp_footer();?>
	<!-- Google Code for Remarketing Tag -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 829918876;
	var google_custom_params = window.google_tag_params;
	var google_remarketing_only = true;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/829918876/?guid=ON&amp;script=0"/>
	</div>
	</noscript>
	</body>
</html>