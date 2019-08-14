<?php 
/*
* Template Name: Temp Home Page
*
*/
get_header(); ?>
    <div id="home" class="container temp" role="main">
        <div class="content">
            <?php //print_header('#content-container','#dc311a'); ?>
            <div class="headline-container">
                <div class="wrapper">
                    <div class="featured-image responsive-bg" data-m="http://agenctymtc.com/wp-content/uploads/2017/07/temp-hero-image-375x610.jpg" data-m-l="http://agenctymtc.com/wp-content/uploads/2017/07/temp-hero-image-667x268.jpg" data-t="http://agenctymtc.com/wp-content/uploads/2017/07/temp-hero-image-768x658.jpg" data-d="http://agencytmtc.com/wp-content/uploads/2017/07/temp-hero-image.jpg" style="background-image: url(&quot;http://agenctymtc.com/wp-content/uploads/2017/07/temp-hero-image.jpg&quot;)">
                        <div id="headline-content">
                            <div class="headline">
                                <h2><?php the_field('sub_headline'); ?><b>Hi.</b> Meet mtc.</h2>
                            </div>
                            <div class="subheadline">
                                <h1>We’re a creative agency that uses ideas to make brands better.</h1>
                            </div>
                            <div class="subheadline small">
                                <h2>We’re undergoing a lot of changes and we’ll be posting new work and case studies soon.<br /> If you’d like to be notified</h2>
                            </div>
                            <div class="quick-form"><?php echo do_shortcode('[formidable id=8]'); ?></div>
                            <div class="disclaimer">
                                <b>*</b>By simple, we mean an incredibly complex and arduous process of research, development, execution, placement, etc. that ends in a beautifully simple seeming product that helps our clients meet their objectives.
                            </div>
                        </div>
                        <div class="circle" style="background: #dc311a;"></div>
                    </div>
                </div>
            </div>
            <div id="content-container">
                <!-- temp contact -->
                <span id="temp-contact"></span>
                <div id="call-out" class="temp-page inner-wrap">
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
                <span id="temp-blog"></span>
                <?php print_posts('3','0',null); ?>
                <a class="all-blogs-button" href="<?php echo home_url(''); ?>/blog">See All Blogs<span class="icon-arrow ease"></span></a>
                <?php print_carousels(); ?>
                <?php print_IG_section(); ?>
                <span id="temp-careers"></span>
                <?php print_homepage_careers(); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>