<?php 
/*
* Front page template
*
*/
get_header(); ?>
    <?php if(get_field('activate_temp_home','options')){ ?>
        <span id="quick-contact"></span>
        <div id="home" class="container temp" role="main">
            <div class="content">
                <div class="headline-container">
                    <div class="wrapper">
                        <div class="featured-image responsive-bg" data-m="https://www.merricktowle.com/wp-content/uploads/2017/07/temp-hero-image-375x610.jpg" data-m-l="https://www.merricktowle.com/wp-content/uploads/2017/07/temp-hero-image-667x268.jpg" data-t="https://www.merricktowle.com/wp-content/uploads/2017/07/temp-hero-image-768x658.jpg" data-d="https://www.merricktowle.com/wp-content/uploads/2017/07/temp-hero-image.jpg" style="background-image: url(&quot;https://www.merricktowle.com/wp-content/uploads/2017/07/temp-hero-image.jpg&quot;)">
                            <div id="headline-content">
                                <div class="headline"><h2><?php the_field('headline'); ?></h2></div>
                                <div class="subheadline"><h1><?php the_field('sub_headline'); ?></h1></div>
                                <div class="subheadline small"><h2><?php the_field('sub_headline_2'); ?></h2></div>
                                <div class="quick-form"><?php echo do_shortcode('[formidable id=8]'); ?></div>
                                <div class="disclaimer"><?php the_field('disclaimer'); ?></div>
                            </div>
                            <div class="circle" style="background: #dc311a;"></div>
                        </div>
                    </div>
                </div>
                <div id="content-container">
                    <!-- temp contact -->
                    <div id="call-out" class="temp-page inner-wrap" style="display:none;">
                        <div class="circle"></div>
                        <div class="square"></div>
                        <div class="content-wrap">
                            <h2>Great ideas + great relationships = great work.</h2>
                            <h3>Creativity and clients are our focus, and, not surprisingly, that works pretty darn well.<br /> Let’s talk about how we can help you.</h3>
                            <div class="contact-wrapper">
                                <?php echo do_shortcode('[formidable id=7]'); ?>
                            </div>
                        </div>
                    </div>
                    <span id="blog"></span>
                    <?php print_posts('3','0',null); ?>
<!--                    <a class="all-blogs-button" href="--><?php //echo home_url(''); ?><!--/blog">See All Blogs<span class="icon-arrow ease"></span></a>-->
                    <?php print_carousels(); ?>
                    <?php print_IG_section(); ?>
                    <span id="careers"></span>
                    <?php print_homepage_careers(); ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div id="home" class="container" role="main">
            <div class="content">
                <?php print_header('#content-container',null); ?>
                <div id="content-container">
                    <?php print_callout(); ?>
                    <?php print_featured_case_study(); ?>
                    <?php print_posts('3','0',null); ?>
                    <?php print_carousels(); ?>
                    <?php print_IG_section(); ?>
                    <?php print_homepage_careers(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php get_footer(); ?>