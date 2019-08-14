<!DOCTYPE html>
<html>
<head>
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--Styles-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/style.css">
    <?php mtc_print_microdata(); ?>
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie.css">
    <script src="<?php bloginfo('template_url'); ?>/js/html5shiv.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://s3.amazonaws.com/icomoon.io/145852/MerrickTowleCreative/style.css?hdmfrb">
    <script type="text/javascript"> var templateURL="<?php bloginfo("template_url"); ?>";</script>
    <link rel="icon" href="<?php bloginfo("template_url"); ?>/images/favicon.ico">
    <?php wp_head(); ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NQKTHJR');</script>
    <!-- End Google Tag Manager -->

</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQKTHJR" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">
    <header id="header">
        <?php  print_logo();
        if(get_field('activate_temp_menu','options')){ ?>
            <nav class="temp-nav">
                <?php if(is_front_page()){ ?>
                    <a class="jump" href="#frm_form_7_container">Contact</a>
                    <a href="/blog">Blog</a>
                    <a class="jump" href="#home-careers">Careers</a>
                <?php } else { ?>
                    <a href="<?php echo home_url(); ?>/#frm_form_7_container">Contact</a>
                    <a href="/blog">Blog</a>
                    <a href="<?php echo home_url(); ?>/#home-careers">Careers</a>
                <?php } ?>
            </nav>
        <?php } else {
            print_trigger();
        } ?>
    </header>
    <div id="navigation-container" class="ease">
        <div class="nav-logo"><?php print_logo(); ?></div>
        <div class="nav-content-wrap">
            <?php print_close(); ?>
            <div id="navigation-wrapper">
                <nav id="navigation">
                    <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'main_menu') ); ?>
                </nav>
                <nav id="secondary-navigation">
                    <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'secondary_menu') ); ?>
                </nav>
                <?php print_social(); ?>
            </div>
        </div>
    </div>