<?php

add_action ('init', 'init_template');

function init_template(){
  setup_template_theme();
  add_action( 'wp_enqueue_scripts', 'enqueue_template_scripts' );
}

// Override 'Howdy' Message
function howdy_message($translated_text, $text, $domain) {
    $new_message = str_replace('Howdy', 'Welcome', $text);
    return $new_message;
}
add_filter('gettext', 'howdy_message', 10, 3);

// Returns author's full name
function get_author_full_name(){
  $fname = get_the_author_meta('first_name');
  $lname = get_the_author_meta('last_name');
  $full_name = '';

  if( empty($fname)){
    $full_name = $lname;
  } elseif( empty( $lname )){
    $full_name = $fname;
  } else {
    // Both first name and last name are present
    $full_name = "$fname $lname";
  }

  return $full_name;
}

function setup_template_theme(){
  //Setting up theme
  if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support( 'post-thumbnails' );
  }

  if (function_exists('register_sidebar')){
    register_sidebar(array('name'=>'Sidebar %d'));
  }

  if (function_exists('register_nav_menu')) {
    register_nav_menu( 'main_menu', 'Main Menu' );
    register_nav_menu( 'secondary_menu', 'Secondary Menu' );
    register_nav_menu( 'footer_menu', 'Footer Menu' );
  }

  if (function_exists('add_image_size')){
    //add image sizes
    add_image_size('profile-full', 598, 665, true);
    add_image_size('profile-small', 251, 261, true);
    add_image_size('profile-thumb', 165, 165, true);
    add_image_size('blog-thumb', 318, 233, true);
    add_image_size('b-roll', 318, 318, true);
    add_image_size('case-study-sm', 582, 646, true);
    add_image_size('blog-mobile', 300, 300, true);
    add_image_size('blog-tablet', 768, 355, true);
    add_image_size('blog-full', 636, 466, true);
    add_image_size('blog-featured', 1200, 675, true);
    add_image_size('mobile-fullscreen', 375, 610, true);
    add_image_size('mobile-fullscreen-l', 667, 268, true);
    add_image_size('tablet-fullscreen', 768, 1024, true);
    add_image_size('mobile-gallery', 265, 430, true);
  }

  if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
  }

  // Custom Editor Styles
  function wpb_mce_buttons_2($buttons) {
      array_unshift($buttons, 'styleselect');
      return $buttons;
  }
  add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

  /*
  * Callback function to filter the MCE settings
  */
   
  function my_mce_before_init_insert_formats( $init_array ) {  
   
  // Define the style_formats array
   
      $style_formats = array(  
  /*
  * Each array child is a format with it's own settings
  * Notice that each array has title, block, classes, and wrapper arguments
  * Title is the label which will be visible in Formats menu
  * Block defines whether it is a span, div, selector, or inline style
  * Classes allows you to define CSS classes
  * Wrapper whether or not to add a new block-level element around any selected elements
  */
          array(  
              'title' => 'Content Block',  
              'block' => 'span',  
              'classes' => 'content-block',
              'wrapper' => true,
               
          ),  
          array(  
              'title' => 'Blue Button',  
              'block' => 'span',  
              'classes' => 'blue-button',
              'wrapper' => false,
          ),
          array(  
              'title' => 'Red Button',  
              'block' => 'span',  
              'classes' => 'red-button',
              'wrapper' => false,
          ),
      );  
      // Insert the array, JSON ENCODED, into 'style_formats'
      $init_array['style_formats'] = json_encode( $style_formats );  
       
      return $init_array;  
     
  } 
  // Attach callback to 'tiny_mce_before_init' 
  add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 
}

function enqueue_template_scripts() {

  // Theme CSS
  wp_register_style( 'screen-css', get_bloginfo('template_directory') . '/css/screen.css' );
  wp_enqueue_style( 'screen-css' );

  // Font Awesome
  wp_register_style( 'fontawesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'fontawesome-css' );

  wp_deregister_script( 'jquery' ); // Google hosted jQuery
  wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' );
  wp_enqueue_script( 'jquery' );

  wp_deregister_script( 'template-js' ); // jQuery Placeholder
  wp_register_script( 'template-js', get_bloginfo('template_directory') . '/js/template.js', array ( 'jquery' ) );
  wp_enqueue_script( 'template-js' );

  // Slick JS
  wp_register_script( 'slick-js', get_bloginfo('template_directory') . '/js/slick.min.js', array ( 'jquery' ) );
  wp_enqueue_script( 'slick-js' );

}

// adds page slug to Body Class function
function add_slug_body_class( $classes ) {
  global $post;
  if ( isset( $post ) ) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// returns property schema data
function mtc_print_microdata() {
  $microdata = array();
  if (is_page_template('page-templates/contact.php')) {
    //creating the contact page microdata
    $contactMicrodata = array(
      '@context' => 'http://schema.org',
      '@type' => 'ContactPage'
    );

    // Adding Microdata and then the Contact Page Microdata
    array_push($microdata, mtc_get_microdata());
    array_push($microdata, $contactMicrodata);
    // array_push($microdata, mtc_get_job_posts());

  
  } 

  elseif (is_page_template('single-career.php')) {
  global $post;
    // Creating the career page microdata
    $careertMicrodata = array(
      '@context' => 'http://schema.org',
      '@type' => 'JobPosting',
      'title' => get_field('headline', $post->ID),
      'description' => get_field('description', $post->ID),
      'hiringOrganization' => array(
        '@type' => 'Organization',
        'name' => 'Merrick Towle Creative',
        'sameAs' => 'https://www.merricktowle.com'
      ),
      'datePosted' => '2016-02-18',
      'jobLocation' => array(
        '@type' => 'Place',
        'address' => array(
          '@type' => 'PostalAddress',
          'streetAddress' => get_field('address', 'options'),
          'addressLocality' => get_field('city', 'options').', '.get_field('state', 'options'),
          'postalCode' => get_field('zip', 'options')
        )
      )
    );

    // Adding Job Posting Microdata
    array_push($microdata, mtc_get_microdata());
    array_push($microdata, $careertMicrodata);
    // return $careertMicrodata;

  } 

  else {
    $microdata = mtc_get_microdata();
  }

  echo '<script type="application/ld+json">';
  echo json_encode($microdata, JSON_PRETTY_PRINT);
  echo '</script>';
}

// function mtc_get_job_posts() {
//   if (function_exists('get_option')){
//     if (is_page_template('single-career.php')) {
//     global $post;
//       // Creating the career page microdata
//       $careertMicrodata = array(
//         '@context' => 'http://schema.org',
//         '@type' => 'JobPosting',
//         'title' => get_field('headline', $post->ID),
//         'description' => get_field('description', $post->ID),
//         'hiringOrganization' => array(
//           '@type' => 'Organization',
//           'name' => 'Merrick Towle Creative',
//           'sameAs' => 'https://www.merricktowle.com'
//         ),
//         'datePosted' => '2016-02-18',
//         'jobLocation' => array(
//           '@type' => 'Place',
//           'address' => array(
//             '@type' => 'PostalAddress',
//             'streetAddress' => get_field('address', 'options'),
//             'addressLocality' => get_field('city', 'options').', '.get_field('state', 'options'),
//             'postalCode' => get_field('zip', 'options')
//           )
//         )
//       );

//       // Adding Job Posting Microdata
//       array_push($microdata, $careertMicrodata);
//       // return $careertMicrodata;

//     } 
//   }
// }

function mtc_get_microdata() {
  if (function_exists('get_option')){
    $microdata = array(
      '@context' => 'http://schema.org',
      '@type' => 'Organization',
      'name' => get_field('company_name', 'options'),
      'address' => array(
        '@type' => 'PostalAddress',
        'streetAddress' => get_field('address', 'options'),
        'addressLocality' => get_field('city', 'options').', '.get_field('state', 'options'),
        'postalCode' => get_field('zip', 'options'),
      ),
      'telephone' => get_field('phone', 'options'),
      'url' => get_home_url()
    );
    if ($header_logo=get_field('header_logo','options')){
      $microdata['logo']=$header_logo['url'];
    }
    return $microdata;
  }
}

// takes an alphabetic character and returns the phone numeric equivalent
function alpha_to_phone($char){
  $conversion=array('a' => 2, 'b' => 2, 'c' => '2', 'd' => 3, 'e' => 3, 'f' => 3, 'g' => 4, 'h' => 4, 'i' => 4, 'j' => 5, 'k' => 5, 'l' => 5, 'm' => 6, 'n' => 6, 'o' => 6, 'p' => 7, 'q' => 7, 'r' => 7, 's' => 7, 't' => 8, 'u' => 8, 'v' => 8, 'w' => 9, 'x' => 9, 'y' => 9, 'z' => 9);
  return $conversion[$char];
}

// takes phone number, returns cleaned numeric equivalent for mobile link functionality
function clean_phone($phone){
  $chars=str_split(strtolower($phone));
  $phone='';
  foreach($chars as $char){
    if (ctype_lower($char)){
      $char=alpha_to_phone($char);
    }
    $phone .= $char;
  }
  $phone=preg_replace("/[^0-9]/", "",$phone);
  return $phone;
}

// Add Custom Post Types
add_action( 'init', 'create_post_type' );
function create_post_type() {

  // Create 'Employee' type
  register_post_type( 'employee',
    array(
      'labels' => array(
        'name' => __( 'Employees' ),
        'singular_name' => __( 'Employee' )
      ),
      'public' => true,
      'has_archive' => fasle,
      'rewrite' => array(
                    'slug' => 'employees',
                    'with_front' => false
                  ),
      'menu_icon' => 'dashicons-businessman',
      'supports' => array(
        'thumbnail',
        'title',
        'editor',
      ),
    )
  );

  // Create 'Careers' type
  register_post_type( 'career',
    array(
      'labels' => array(
        'name' => __( 'Careers' ),
        'singular_name' => __( 'Career' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array(
                    'slug' => 'careers',
                    'with_front' => false
                  ),
      'menu_icon' => 'dashicons-id',
      'supports' => array(
        'thumbnail',
        'title',
        'editor',
      ),
    )
  );

  // Create 'Case Study' type
  register_post_type( 'case_study',
    array(
      'labels' => array(
        'name' => __( 'Case Studies' ),
        'singular_name' => __( 'Case Study' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array(
                    'slug' => 'case-studies',
                    'with_front' => false
                  ),
      'menu_icon' => 'dashicons-portfolio',
      'supports' => array(
        'thumbnail',
        'title',
        'editor',
      ),
    )
  );

  // Create 'Case Study' type
  register_post_type( 'b_roll_photos',
    array(
      'labels' => array(
        'name' => __( 'B-Roll Photos' ),
        'singular_name' => __( 'B-Roll Photo' )
      ),
      'public' => true,
      'publicly_queryable' => false,
      'has_archive' => false,
      'taxonomies' => array(
                    'slug' => 'b-roll',
                    'with_front' => false
                  ),
      'rewrite' => array(
                    'slug' => 'b-roll',
                    'with_front' => false
                  ),
      'menu_icon' => 'dashicons-smiley',
      'supports' => array(
        'thumbnail',
        'title',
        'editor',
      ),
    )
  );
}


// Custom Excerpt function for Advanced Custom Fields
function custom_ACF_excerpt() {
  global $post;
  $text = get_field('first_copy_block'); // Make sure this is the right field you want to pull from.
  if ( '' != $text ) {  
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]&gt;', ']]&gt;', $text);
    $excerpt_length = 20; // 20 words
    $permalink = get_permalink($post->ID);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '<a class="ease" href="'.$permalink.'" rel="nofollow"> ...read more</a>');
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  }
  return apply_filters('the_excerpt', $text);
}


// Share icons
function mtc_social_sharing_buttons() {
  global $post;
  // Get current page URL 
  $mtcURL = urlencode(get_permalink());
  
  // Get current page title
  $mtcTitle = str_replace( ' ', '%20', get_the_title());
  
  // Get Post Thumbnail
  $mtcThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  
  // Construct sharing URL without using any script
  $twitterURL = 'https://twitter.com/intent/tweet?text='.$mtcTitle.'&amp;url='.$mtcURL.'&amp;via=Crunchify';
  $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$mtcURL;
  $googleURL = 'https://plus.google.com/share?url='.$mtcURL;
  $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$mtcURL.'&amp;media='.$mtcThumbnail[0].'&amp;description='.$mtcTitle;

  // Add sharing button at the end of post content
  $content .= '<div class="mtc-social">';
    $content .= '<div class="inner-wrap sm">';
      $content .= '<div class="title">Share with the world:</div>';
      $content .= '<a class="mtc-share-link mtc-twitter" href="'. $twitterURL .'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa ease fa-twitter fa-stack-1x fa-inverse"></i></span></a>';
      $content .= '<a class="mtc-share-link mtc-facebook" href="'.$facebookURL.'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa ease fa-facebook fa-stack-1x fa-inverse"></i></span></a>';
      // $content .= '<a class="mtc-share-link mtc-googleplus" href="'.$googleURL.'" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa ease fa-google-plus  fa-stack-1x fa-inverse"></i></span></a>';
      $content .= '<a class="mtc-share-link mtc-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa ease fa-pinterest-p fa-stack-1x fa-inverse"></i></span></a>';
    $content .= '</div>';
  $content .= '</div>';

  echo $content;
}

// Custom Functions.  Use them. //

function print_logo(){
  echo '<div class="logo">';
    echo '<a href="'. home_url('') .'">';
      echo '<span class="icon-mtc_logo ease"></span>';
    echo '</a>';
  echo '</div>';
}

function print_footer_logo(){
  echo '<div class="logo">';
    echo '<a href="'. home_url('') .'">';
      echo '<span class="icon-footerlogo ease"></span>';
    echo '</a>';
  echo '</div>';
}

function print_address(){
  $address = get_field('address','options');
  $city = get_field('city','options');
  $state = get_field('state','options');
  $zip = get_field('zip','options');
  echo '<div class="address">';
  echo '<a href="https://maps.google.com/?daddr='.$address.', '.$city.', '.$state.' '.$zip.'" target="_blank" class="ease"><span class="top">'.$address.'</span><span class="bottom">'.$city.', '.$state.' '.$zip.'</span></a>';
  echo '</div>';
}

function print_directions() {
  $address = get_field('address','options');
  $city = get_field('city','options');
  $state = get_field('state','options');
  $zip = get_field('zip','options');
  echo '<div class="directions">';
    echo '<a href="https://maps.google.com/?daddr='.$address.', '.$city.', '.$state.' '.$zip.'" target="_blank" class="ease">Get Directions</a>';
  echo '</div>';
}

function print_email(){
  if ($email = get_field('email','options')){
    echo '<div class="email"><a href="mailto:'.$email.'">'.$email.'</a></div>';
  }
}

function print_form() {
  if($form_snippet = get_field('form_snippet')) {
    echo '<div class="form">';
      eval($form_snippet);
    echo '</div>';
  }
}

function print_social(){
  if ($rows = get_field('social_media_accounts','options')){
    echo '<div class="icons social">';
    foreach($rows as $row){
     echo '<a class="icon ease" href="'.$row['url'].'" target="_blank">';
      echo '<span class="fa-stack fa-lg">';
        echo '<i class="fa fa-circle fa-stack-2x"></i>';
        echo '<i class="fa ease '.$row['social_media_type'].' fa-stack-1x fa-inverse"></i>';
      echo '</span>';
      echo '</a>';
    }
    echo '</div>';
  }
}

function print_phone_number(){
  if ($phone = get_field('phone','options')){
    echo '<div class="phone">';
      echo '<a href="tel:+1'.clean_phone($phone).'" class="phone-number ease">'.$phone.'</a>';
    echo '</div>';
  }
}

function print_gsa_icon(){
  if ($icon = get_field('gsa_icon','options')){
    echo '<div class="gsa"><img src="'.$icon['url'].'" /></div>';
  }
}

function print_trigger() {
  echo '<div id="nav-trigger" class="inactive ease">';
    echo '<div class="trigger-wrap">';
      echo '<span class="line"></span>';
      echo '<span class="line"></span>';
      echo '<span class="line"></span>';
    echo '</div>';
  echo '</div>';
}

function print_close() {
  echo '<div id="close-wrap" class="ease">';
    echo '<span class="icon-close ease"></span>';
  echo '</div>';
}

function print_office_hours(){
  if ($rows = get_field('office_hours','options')) {
    echo '<div id="office-hours">';
      echo '<div class="title">Office Hours</div>';
      echo '<div class="office-hour">';
      foreach ( $rows as $row ) {
        echo '<div class="days"><span class="day">'.$row['day'].': </span><span class="hours">'.$row['hours'].'</span></div>';
      }
      echo '</div>';
    echo '</div>';
  }
}

// Header
function print_header($target, $color) {
  if(has_post_thumbnail()) {
    echo '<div class="headline-container">';
      echo '<div class="wrapper">';
        echo '<div class="featured-image responsive-bg" data-m="'.get_the_post_thumbnail_url(get_the_ID(),'mobile-fullscreen').'" data-m-l="'.get_the_post_thumbnail_url(get_the_ID(),'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url(get_the_ID(),'tablet-fullscreen').'" data-d="'.get_the_post_thumbnail_url().'" >';
          echo '<div id="headline-content">';
            if ($headline = get_field('headline')) {
              echo '<div class="headline"><h2>'.$headline.'</h2></div>';
            }
            if ($sub_headline = get_field('sub_headline')) {
              echo '<div class="subheadline"><h1>'.$sub_headline.'</h1></div>';
            }
          echo '</div>';
          if ($jumplink = get_field('jump_link_text')) {
            echo '<div class="jumplink-wrapper"><a class="jump" href="'.$target.'">';
              echo '<div class="icon-wrap"><span class="icon-down ease"></span></div><div class="link-text ease">'.$jumplink.'</div></a>';
            echo '</div>';
          }

          if ($disclaimer = get_field('disclaimer')) {
            echo '<div class="disclaimer">'.$disclaimer.'</div>';
          }
          echo '<div class="circle" style="background: '.$color.';"></div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }
}

// Small Header
function print_small_img_header() {
  if ($headline = get_field('headline')) {
    echo '<div class="headline-container small">';
      echo '<div class="wrapper">';
        echo '<div class="sm-featured-image responsive-bg" data-m="'.get_the_post_thumbnail_url(get_the_ID(), 'mobile-fullscreen').'" data-m-l="'.get_the_post_thumbnail_url(get_the_ID(), 'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url(get_the_ID(), 'tablet-fullscreen').'" data-d="'.get_the_post_thumbnail_url().'" >';
          echo '<div id="headline-content">';
            echo '<div class="headline"><h2>'.$headline.'</h2></div>';
            if ($sub_headline = get_field('sub_headline')) {
              echo '<div class="subheadline"><h1>'.$sub_headline.'</h1></div>';
            }
          echo '</div>';
          echo '<div class="circle"></div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }
}

// Small Header - no image
function print_small_header() {
  if ($headline = get_field('headline')) {
    echo '<div class="headline-container small">';
      echo '<div class="wrapper">';
        echo '<div class="no-featured-image">';
          echo '<div id="headline-content">';
            echo '<div class="headline"><h2>'.$headline.'</h2></div>';
            if ($sub_headline = get_field('sub_headline')) {
              echo '<div class="subheadline"><h1>'.$sub_headline.'</h1></div>';
            }
          echo '</div>';
          echo '<div class="circle"></div>';
        echo '</div>';
        if(is_page_template('page-templates/thank-you.php')) { 
          if($copy = get_field('copy')) {
            echo '<div class="copy">'.$copy.'</div>';
          }
          print_social();
        }
      echo '</div>';
    echo '</div>';
  }
}

// Bottom Call Out Cards (to pull data from "options" page, pass the argument of 'options' when calling the function.)
function print_callout_cards($arg) {
  if($arg == 'options') {
    $cards = get_field('bottom_call_out_cards','options');
  } else {
    $cards = get_field('bottom_call_out_cards');
  }
  if($cards) {
    echo '<div id="bottom-callouts">';
    foreach ($cards as $card) {
      echo '<div class="callout-wrapper">';
        echo '<div class="callout vertical-center-parent" style="background-image: url('.$card['image']['url'].'); ">';
          if($card['image']){
              echo '<div class="callout-wrap vertical-center-child">';
                echo '<div class="pre-title">'.$card['pre_title'].'</div>';
                echo '<div class="title">'.$card['title'].'</div>';
                if($card['callout_page_link']) {
                  echo '<div class="link"><a href="'.$card['callout_page_link'].'">'.$card['callout_link_text'].'<span class="icon-arrow ease"></span></a></div>';
                }
              echo '</div>';
            }
          echo '</div>';
        echo '</div>';
      }
    echo '</div>';
  }
}

// Print Icon Grid (About Us & Careers.  The 'prefix' is taken from the machine name of the repeater field.)
function print_icon_grid($prefix) {
  if($grid_content = get_field($prefix)) {
    echo '<div id="'.$prefix.'" class="icon-grid">';
      if($headline = get_field($prefix.'_headline')) {
        echo '<h2 class="headline">'.$headline.'</h2>';
        if($sub_headline = get_field($prefix.'_sub_headline')) {
          echo '<div class="sub-headline">'.$sub_headline.'</div>';
        }
      }
      echo '<div id="grid-wrapper">';
        $count = 0;
        foreach ($grid_content as $row) {
          $count++;
          echo '<div class="row-container row-'.$count.'">';
            echo '<div class="row-wrap">';
              echo '<div class="icon vertical-center-parent"><span class="icon-'.$row['icon'].' vertical-center-child"></span></div>';
              echo '<div class="content">';
                echo '<div class="headline">'.$row['title'].'</div>';
                echo '<div class="copy">'.$row['copy'].'</div>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
        }
      echo '</div>';
    echo '</div>';
  }
}

// Bottom Related Content - this function has a lot going on, so read the notes if you change it.
function print_related_content() {
  if($related = get_field('related_content')) {
    echo '<div id="related-content">';
      echo '<div class="related-title"><span class="title">Related</span></div>';
      echo '<div id="related-content-rows">';
        foreach ($related as $id) {
          $page = get_post($id['page']); // Post ID derived from repeater field.
          $count++;
          echo '<div class="content-wrapper row-'.$count.'">';
            echo '<div class="content responsive-bg" data-m="'.get_the_post_thumbnail_url($page).'" data-m-l="'.get_the_post_thumbnail_url($page,'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url($page).'" data-d="'.get_the_post_thumbnail_url($page).'">';
              echo '<div class="overlay"></div>';
              echo '<div class="inner-wrap">';

                // Check type to rename "post" to "Blog".
                if($page->post_type == 'case_study') {
                  echo '<div class="type">'.str_replace('_', ' ', $page->post_type).'</div>';
                } else {
                  echo '<div class="type">Blog</div>';
                }
                // Check type to get the right Title/Headline
                if($page->post_type == 'post') {
                  echo '<div class="title"><a href="'.get_the_permalink($page).'">'.get_the_title($page->ID).'</a></div>';
                } else {
                  echo '<div class="title"><a href="'.get_the_permalink($page).'">'.ucwords(str_replace('-', ' ', get_field('headline',$page))).'</a></div>';
                }
                // Check type to print correct link text.
                if($page->post_type == 'case_study') {
                  echo '<div class="link"><a href="'.get_the_permalink($page).'">See it<span class="icon-arrow ease"></span></a></div>';
                } else {
                  echo '<div class="link"><a href="'.get_the_permalink($page).'">Read it<span class="icon-arrow ease"></span></a></div>';
                }
              echo '</div>';
            echo '</div>';
          echo '</div>';
        }
      echo '</div>';
    echo '</div>';
  }
}

// Options Header
function print_options_header($prefix) {
  if ($headline = get_field($prefix.'_headline','options')) {
    echo '<div class="headline-container options">';
      echo '<div class="wrapper">';
        echo '<div class="no-featured-image">';
          echo '<div id="headline-content">';
            echo '<div class="headline"><h2>'.$headline.'</h2></div>';
            if ($sub_headline = get_field($prefix.'_title','options')) {
              echo '<div class="subheadline"><h1>'.$sub_headline.'</h1></div>';
            }
            if(is_404()){
              echo '<div class="link"><a href="'.get_home_url().'">Go home<span class="icon-arrow ease"></span></a></div>';
            }
          echo '</div>';
          echo '<div class="circle"></div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }
}

function print_current_positions() {
  if($jobs = get_field('current_positions')){
    echo '<div id="current-positions" style="display:none;">';
      foreach($jobs as $link) {
        echo '<div class="link"><a href="'.$link['job_title']['url'].'" target="'.$link['job_title']['target'].'">'.$link['job_title']['title'].'<span class="icon-arrow ease"></span></a></div>';
      }
    echo '</div>';
  }
}

// Simple Call Out
function print_callout() {
  global $post; $post_slug = $post->post_name;
  if($headline = get_field('call_out_headline')) {
    echo '<div id="call-out" class="'.$post_slug.' inner-wrap">';
      echo '<div class="circle"></div><div class="square"></div>';
      echo '<div class="content-wrap">';
        echo '<h2>'.$headline.'</h2>';
        if($subheadline = get_field('call_out_sub_headline')) { echo '<h3>'.$subheadline.'</h3>'; }

        if(is_page_template( 'page-templates/careers.php' )){
          print_current_positions();
        }

        //if($link = get_field('call_out_link')) {
          //echo '<div class="link"><a href="'.$link['url'].'" target="'.$link['target'].'">'.$link['title'].'<span class="icon-arrow ease"></span></a></div>';
        //}

        // if(is_front_page()) {
        //   echo do_shortcode('[formidable id=7]');
        // }
        
      echo '</div>';
    echo '</div>';
  }
}

// Homepage Features Case Study
function print_featured_case_study() {
  if($case_studies = get_field('case_studies')){
    echo '<div id="case-studies">';
      echo '<div class="case-studies-wrap">';
      foreach ($case_studies as $case_study) {
        // echo '<pre>'; print_r($case_study); echo '</pre>';
       echo '<div class="case-study">';
        echo '<img class="responsive-img" data-m="'.get_the_post_thumbnail_url($case_study['featured_case_study'],'mobile-fullscreen').'" data-m-l="'.get_the_post_thumbnail_url($case_study['featured_case_study'],'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url($case_study['featured_case_study'],'tablet-fullscreen').'" data-d="'.get_the_post_thumbnail_url($case_study['featured_case_study']).'"/>';
        echo '<div class="content-wrapper">';
          echo '<div class="headline-wrapper">';
            echo '<div class="shape" style="background: '.get_field('case_study_color', $case_study['featured_case_study']).';"></div>';
            if ($headline = get_field('headline', $case_study['featured_case_study'])) {
              echo '<h2>'.$headline.'</h2>';
            }
            if ($subheadline = get_field('sub_headline', $case_study['featured_case_study'])) {
              echo '<h3>'.$subheadline.'</h3>';
            }
            echo '<div class="link">';
              echo '<a style="background: '.get_field('case_study_color', $case_study['featured_case_study']).';" href="'.get_the_permalink($case_study['featured_case_study']).'">';
                echo 'Enter Case Study <span class="icon-arrow ease"></span>';
              echo '</a>';
            echo '</div>';

            echo '<div class="link mobile">';
              echo '<a style="background: '.get_field('case_study_color', $case_study['featured_case_study']).';" href="/case-studies/">';
                echo 'See All Case Studies <span class="icon-arrow ease"></span>';
              echo '</a>';
            echo '</div>';

          echo '</div>';
        echo '</div>';
      echo '</div>';
      }
      echo '</div>';
    echo '</div>';
  }
}

// Homepage B-Roll Carousels
function print_carousels() {
  if($carousels = get_field('carousels')) {
    echo '<div id="b-roll-carousels">';
      if($headline = get_field('employees_headline')) {
        echo '<h2 class="title">'.$headline.'</h2>';
      }
      if($subheadline = get_field('employees_sub_headline')) {
        echo '<div class="sub-headline">'.$subheadline.'</div>';
      }
      // Carousels Loop
      echo '<div class="carousels-wrapper">';
        $count = 0;
        foreach ($carousels as $carousel) {
          $count++;
          echo '<div class="carousel row-'.$count.'">';
            foreach ($carousel as $images) {
              $isFirst = true;
              foreach ($images as $image) {
                // echo '<pre>'.print_r($image['image']->ID).'</pre>';
                $imgID = ($image['image']->ID);
                $bRollImage = get_field('image',$imgID);
                // echo '<pre>'.print_r($bRollImage).'</pre>';
                // if($isFirst) { echo '<img src="'.$image['image']['url'].'" style="display: block;" />';}
                if($isFirst) { echo '<div style="background-image: url('.$bRollImage['url'].'); display: block;"></div>';}
                // else { echo '<img src="'.$image['image']['url'].'" />'; }
                else { echo '<div style="background-image: url('.$bRollImage['url'].');"></div>'; }
                $isFirst = false;
              }
            }
          echo '</div>';
        }
      echo '</div>';

      // Links Loop
      if($links = get_field('links')) {
        echo '<div class="links-wrapper">';
          foreach ($links as $link) {
            echo '<div class="link"><a href="'.$link['link_target'].'">'.$link['link_text'].'<span class="icon-arrow ease"></a></div>';
          }
        echo '</div>';
      }

    echo '</div>';
  }
}

// Careers Homepage Section
function print_homepage_careers() {
  if($headline = get_field('careers_headline')) {
    $background = get_field('careers_background_image');
    echo '<div id="home-careers" class="vertical-center-parent" style="background-image: url('.$background['url'].');">';
      echo '<div class="careers-wrap vertical-center-child">';
        echo '<div class="headline">'.$headline.'</div>';
      if($subheadline = get_field('careers_sub_headline')) {
        echo '<div class="subheadline">'.$subheadline.'</div>';
      }
      if ($link = get_field('careers_link_target')){
        $link_text = get_field('careers_link_text');
        echo '<div class="link"><a href="'.$link.'">'.$link_text.'<span class="icon-arrow ease"></span></a></div>';
      }
      echo '</div>';
    echo '</div>';
  }
}

// About Us Content
function print_about_us_content() {
  if($copy = get_field('copy')) {
    echo '<div id="about-us-copy">';
      echo '<div class="wrap">'.$copy.'</div>';
    echo '</div>';
  }
  if($content = get_field('content_repeater')) {
    $count = 0;
    echo '<div id="about-us-content">';
      echo '<div class="wrap">';
      foreach ($content as $row) {
        $count++;
        echo '<div class="content-row row-'.$count.'">';
          echo '<h2 class="headline">'.$row['headline'].'</h2>';
          echo '<div class="copy">'.$row['copy'].'</div>';
        echo '</div>';
      }
      echo '</div>';
    echo '</div>';
  }
}

// Clients
function print_clients() {
  if($clients = get_field('client_logos')){
    echo '<div id="clients">';
      if($headline = get_field('clients_headline')) {
        echo '<h2 class="headline">'.$headline.'</h2>';
        if($copy = get_field('clients_copy')) {
          echo '<div class="copy">'.$copy.'</div>';
        }
      }

      echo '<div id="clients-wrapper">';
        $count = 0;
        foreach ($clients as $client) {
          $count++;
          echo '<div class="client row-'.$count.'">';
            if($client['client_url']) {
              echo '<div class="client-logo">';
              echo '<a href="'.$client['client_url'].'"><img src="'.$client['logo']['url'].'" /></a>';
              echo '</div>';
            } else {
              echo '<div class="client-logo"><img src="'.$client['logo']['url'].'" /></div>';
            }
          echo '</div>';
        }
      echo '</div>';
    echo '</div>';
  }
}

// GSA
function print_gsa_callout() {
  if($headline = get_field('gsa_headline')) {
    echo '<div id="gsa">';
      echo '<h2 class="headline">'.$headline.'</h2>';
      if ($copy = get_field('gsa_copy')){
        echo '<div class="copy">'.$copy.'</div>';
      }
      if ($link = get_field('link_target')){
        $link_text = get_field('link_text');
        echo '<div class="link"><a href="'.$link.'">'.$link_text.'<span class="icon-arrow ease"></span></a></div>';
      }
    echo '</div>';
  }
}

// Employee Headline
function print_employee_headline() {
  if($headline = get_field('employee_headline')) {
    echo '<div id="employee-headline">';
      echo '<h2 class="title">'.$headline.'</h2>';
      if($subtitle = get_field('employee_sub_headline')){
        echo '<div class="subtitle">'.$subtitle.'</div>';
      }
    echo '</div>';
  }
}

// Employee Profile
function print_employee() {
  if ($employees = get_field('employees')) {
    echo '<div id="employees">';
      $count = 0;
      foreach ( $employees as $employee ) {
        $count++;
        echo '<div class="employee row-'.$count.'">';
          echo '<a href="'.get_the_permalink($employee['employee']).'">';
            echo '<div class="image-wrap">';
              echo '<div class="overlay ease"></div>';
              echo '<img src="'.get_field('profile_photo', $employee['employee'])['sizes']['profile-small'].'" />';
            echo '</div>';
            echo '<div class="bottom-wrap ease">';
              echo '<div class="name-wrap">';
                echo '<h2>'.get_the_title($employee['employee']).'</h2>';
                echo '<div class="position">'.get_field('position', $employee['employee']).'</div>';
              echo '</div>';
            echo '</div>';
            echo '<div class="bio-link">';
              echo '<div class="link">Read Bio <span class="icon-wrap"><span class="icon-gallery-nav ease"></span></span></div>';
            echo '</div>';
          ECHO '</a>';
        echo '</div>';
      }
    echo '</div>';
  }
} 


// Employee incrementer
function print_employee_incrementor() {
  global $post;
  $current_page_id = $post->ID;
  // Get list of employee post IDs from Employee Landing page.
  if($employee = get_field('employees',9)) {
    $index_of_current_page = array_search($current_page_id, array_column($employee, 'employee'));
    $prev = $employee[$index_of_current_page-1]['employee'];
    $next = $employee[$index_of_current_page+1]['employee'];
    echo '<div id="incrementor">';
      if($prev != ''){
       echo '<div class="button prev"><a href="'.get_the_permalink($prev).'"><span class="icon-gallery-nav ease"></a></div>';
      }
      if($next != ''){
        echo '<div class="button next"><a href="'.get_the_permalink($next).'"><span class="icon-gallery-nav ease"></a></div>';
      }
    echo '</div>';
  }
}

// Employee Profile Header
function print_profile_header() {
  if($image = get_field('profile_photo')) {
    echo '<div id="employee-header">';
      echo '<div class="content">';
        echo '<div class="content-outer-wrap vertical-center-parent">';
          echo '<div class="content-inner-wrap vertical-center-child">';
            echo '<div id="employee-link"><a href="/employees" class="ease"><span class="icon-close ease"></span></a></div>';
            print_employee_incrementor();
            echo '<div class="circle"></div>';
            echo '<div class="name-wrap">';
              echo '<h1 class="name">'.get_the_title().'</h1>';
              if($position = get_field('position')) {
                echo '<h2 class="position">'.$position.'</h2>';
              }
              if ($rows = get_field('social_media_identity')){
                echo '<div class="icons social">';
                foreach($rows as $row){
                 echo '<a class="icon ease" href="'.$row['url'].'" target="_blank">';
                  echo '<span class="fa-stack fa-lg">';
                    echo '<i class="fa fa-circle fa-stack-2x"></i>';
                    echo '<i class="fa ease '.$row['social_media_type'].' fa-stack-1x fa-inverse"></i>';
                  echo '</span>';
                  echo '</a>';
                }
                echo '</div>';
              }
            echo '</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
      echo '<div class="img-container">';
        echo '<img src="'.$image['sizes']['profile-full'].'" />';
      echo '</div>';
    echo '</div>';
  }
}

// Employee Content
function print_employee_content() {
  if($quote = get_field('quote')) {
    echo '<div id="employee-quote">';
      echo '<div class="inner-wrap sm">'.$quote.'</div>';
    echo '</div>';
  }
  if($content = get_field('copy')) {
    $headline = get_field('headline');
    echo '<div id="employee-content">';
      echo '<div class="inner-wrap sm">';
        echo '<div class="headline">'.$headline.'</div>';
        echo '<div class="content">'.$content.'</div>';
      echo '</div>';
    echo '</div>';
  }
}

// Case Study Landing Page
function print_case_studies() {
  if ($casestudies = get_field('case_studies')) {
    $count = 0;
    foreach ($casestudies as $project) {
      $count++;

      // Determine class for the size of the case study and which size image to use.
      if ( $count % 3 == 1) {
        $size = 'full';
        $imageSize = 'full';
      } else if ( $count % 3 == 2) {
        $size = 'small';
        $imageSize = 'case-study-sm';
      } else if ( $count % 3 == 0) {
        $size = 'small';
        $imageSize = 'case-study-sm';
      };

      $post_ID = $project['case_study'];
      echo '<div class="case-study '.$size.'">';
        echo '<img class="responsive-img" data-m="'.get_the_post_thumbnail_url($post_ID, 'mobile-fullscreen').'" data-m-l="'.get_the_post_thumbnail_url($post_ID, 'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url($post_ID, 'full').'" data-d="'.get_the_post_thumbnail_url($post_ID, $imageSize).'"/>';
        echo '<div class="content-wrapper">';
          echo '<div class="headline-wrapper">';
            echo '<div class="shape" style="background: '.get_field('case_study_color', $post_ID).';"></div>';
            if ($headline = get_field('headline', $post_ID)) {
              echo '<h2>'.$headline.'</h2>';
            }
            if ($subheadline = get_field('sub_headline', $post_ID)) {
              echo '<h3>'.$subheadline.'</h3>';
            }
            echo '<div class="link">';
              echo '<a style="background: '.get_field('case_study_color', $post_ID).';" href="'.get_the_permalink($project['case_study']).'">';
                echo 'Enter Case Study <span class="icon-arrow ease"></span>';
              echo '</a>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    }
  }
}


// Case Study Content loop
function print_case_study_content() {
  // Check if the flexible content field has rows of data
  if( have_rows('case_study_content') ): $id = 0; // Set ID before incrementing.
    // Loop through the rows of data
    while ( have_rows('case_study_content') ) : the_row(); $id++;  // Increment ID
      // Text Area with List layout
      if( get_row_layout() == 'text_area_with_list' ):
        echo '<div id="row-'.$id.'" class="content-row text-area-with-list">';
          echo '<div class="list-items">';
            if(get_sub_field('list_items')) {
              echo '<div class="list-header">'.get_sub_field('list_title').':</div>';
              if( have_rows('list_items') ):  // Check to see if there's content in the list repeater.
                echo '<ul class="list">';
                while ( have_rows('list_items') ) : the_row();
                  $list_item = get_sub_field('item');
                  echo '<li>'.$list_item.'</li>';
                endwhile;
                echo '</ul>';
              endif;
            }
          echo '</div>';
          echo '<div class="text-area">';
            echo '<div class="topic">'.get_sub_field('topic').'</div>';
            echo '<div class="headline">'.get_sub_field('intro_headline').'</div>';
            echo '<div class="copy">'.get_sub_field('copy').'</div>';
          echo '</div>';
        echo '</div>';

      // Text Area layout
      elseif( get_row_layout() == 'text_area' ):
        echo '<div id="row-'.$id.'" class="content-row text-area">';
          echo '<div class="text-area">';
            echo '<div class="topic">'.get_sub_field('topic').'</div>';
            echo '<div class="headline">'.get_sub_field('intro_headline').'</div>';
            echo '<div class="copy">'.get_sub_field('copy').'</div>';
          echo '</div>';
        echo '</div>';

      // Split Content Text Area layout
      elseif( get_row_layout() == 'split_content_text_area' ):
        echo '<div id="row-'.$id.'" class="content-row split-text-area">';
          echo '<div class="split-text-area">';
            echo '<div class="topic">'.get_sub_field('topic').'</div>';
            echo '<div class="headline">'.get_sub_field('intro_headline').'</div>';
            echo '<div class="copy">';
              echo '<div class="left">'.get_sub_field('copy_left').'</div>';
              echo '<div class="right">'.get_sub_field('copy_right').'</div>';
            echo '</div>';
          echo '</div>';
        echo '</div>';

      // Static Image layout
      elseif( get_row_layout() == 'content_image' ): 
        $file = get_sub_field('image');
        echo '<div id="row-'.$id.'" class="content-row static-image">';
          echo '<img src="'.$file['url'].'" />';
        echo '</div>';

      // Static Image Grid layout
      elseif( get_row_layout() == 'image_grid' ): 
        if( have_rows('grid_images') ): // Check if the Grid Images repeater field has data
          echo '<div id="row-'.$id.'" class="content-row image-grid">';
            $imageCount = 0; while ( have_rows('grid_images') ) : the_row(); $imageCount++; endwhile; // Get number of rows.
            // Loop through the rows of image data
            echo '<div class="img-layout-'.$imageCount.'">'; $imageNum = 0;
              while ( have_rows('grid_images') ) : the_row(); $imageNum++;
                $image = get_sub_field('image');
                echo '<img class="img-'.$imageNum.'"src="'.$image['url'].'" alt="'.$image['alt'].'" />';
              endwhile;
            echo '</div>';
          echo '</div>';
        endif;

      // Gallery layout
      elseif( get_row_layout() == 'gallery' ): 
        if( have_rows('gallery_images') ): // Check if the Gallery repeater field has data
          echo '<div id="row-'.$id.'" class="content-row gallery">';
            // Loop through the rows of image data
            while ( have_rows('gallery_images') ) : the_row();
              $image = get_sub_field('image');
              echo '<img src="'.$image['url'].'" alt="'.$image['alt'].'" />';
            endwhile;
          echo '</div>';
        endif;
      endif;

    endwhile;  // End flex content loop.  Nothing more to see here.
  else :
    // no layouts found
  endif;
}

// Single Blog Header
function print_blog_header() {
  if(has_post_thumbnail()) {
    echo '<div class="headline-container blog">';
      echo '<div class="wrapper">';
        echo '<div class="featured-image vertical-center-parent ease">';
          echo '<div id="headline-content" class="vertical-center-child">';
            echo '<div class="headline"><h2>'.get_the_title().'</h2></div>';
            if ($page_headline = get_field('page_headline')) {
              echo '<div class="subheadline"><h1>'.$page_headline.'</h1></div>';
            }
          echo '</div>';
          echo '<div class="circle"></div>';
          echo '<div class="square"></div>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
  }
}

// Single Blog Attribution
function print_blog_attribution() {
  if($post_ID = get_field('name')) {
    echo '<div id="post-attribution">';
      echo '<div class="profile-photo"><img src="'.get_field('profile_photo', $post_ID)['sizes']['profile-thumb'].'" /></div>';
      echo '<div class="author-info">';
        echo '<span class="name"><span class="credit">By&nbsp;</span>'.get_the_title($post_ID).'</span><span class="comma">,&nbsp;</span>';
        echo '<span class="position">'.get_field('position', $post_ID).'</span>';
        echo '<div class="link"><a class="ease" href="'.get_the_permalink($post_ID).'">Learn More about ';
        $name = get_the_title($post_ID);
        $nameArray = explode(' ',trim($name));
        echo $nameArray[0]; // Gives us the first name.
        echo '<span class="icon-arrow ease"></spasn></a></div>';
        echo '<div class="link standard">';
          echo '<a class="ease" href="/case-studies/">See our work <span class="icon-arrow ease"></span></a>';
        echo '</div>';  
      echo '</div>';
    echo '</div>';
  } else {

  }
}

// Single Blog Post
function print_blog_content() {
  if($copy = get_field('first_copy_block')) {

    echo '<div id="blog-content">';
      echo '<div class="inner-wrap sm">';
      if( $image = get_field('image')) {
        echo '<div class="content-wrap row-0 image">';
          echo '<div class="image-wrap"><img class="responsive-img" data-m="'.$image['sizes']['blog-mobile'].'" data-t="'.$image['url'].'" data-d="'.$image['url'].'" /></div>';
        echo '</div>';
      }

      $headline = get_field('copy_headline');
        echo '<div class="content-wrap row-1 initial">';
          echo '<div class="content-headline">'.$headline.'</div>';
          echo '<div class="copy">'.$copy.'</div>';
        echo '</div>';
        // Check for additional content.

        if( have_rows('content_blocks') ):
          $count = 1; // Set ID before incrementing.  We start at 1 because 1 is hardcoded above.
          // Loop through the rows of data
          while ( have_rows('content_blocks') ) : the_row();
            $count++;  // Increment ID

            // Text Area layout
            if( get_row_layout() == 'content_area' ):
              $copy = get_sub_field('copy');
              echo '<div class="content-wrap row-'.$count.' content">';
              if($headline = get_sub_field('headline')) {
                echo '<div class="content-headline">'.$headline.'</div>';
              }
                echo '<div class="copy">'.$copy.'</div>';
              echo '</div>';

            // Static Image Layout
            elseif( get_row_layout() == 'image' ):
              $image = get_sub_field('image');
              echo '<div class="content-wrap row-'.$count.' image">';
              if($headline = get_sub_field('headline_image')) {
                echo '<div class="content-headline">'.$headline.'</div>';
              }
                echo '<div class="image-wrap"><img class="responsive-img" data-m="'.$image['sizes']['blog-mobile'].'" data-t="'.$image['url'].'" data-d="'.$image['url'].'" /></div>';
              echo '</div>';

            // Image w/ Copy Layout (Left)
            elseif( get_row_layout() == 'image_copy_left' ):
              $copy = get_sub_field('copy_w_copy_l');
              $image = get_sub_field('image_w_copy_l');
              echo '<div class="content-wrap row-'.$count.' image-content">';
                echo '<div class="image-wrap left"><img class="responsive-img" data-m="'.$image['sizes']['blog-mobile'].'" data-t="'.$image['url'].'" data-d="'.$image['url'].'" /></div>';
                echo '<div class="copy-wrap right">';
                if($headline = get_sub_field('headline_w_copy_l')) {
                   echo '<div class="content-headline">'.$headline.'</div>';
                 }
                  echo '<div class="copy">'.$copy.'</div>';
                echo '</div>';
              echo '</div>';

            // Image w/ Copy Layout (Right)
            elseif( get_row_layout() == 'image_copy_right' ):
              $copy = get_sub_field('copy_w_copy_r');
              $image = get_sub_field('image_w_copy_r');
              echo '<div class="content-wrap row-'.$count.' image-content">';

                echo '<div class="copy-wrap left">';
                if($headline = get_sub_field('headline_w_copy_r')) {
                  echo '<div class="content-headline">'.$headline.'</div>';
                }
                  echo '<div class="copy">'.$copy.'</div>';
                echo '</div>';

                echo '<div class="image-wrap right"><img class="responsive-img" data-m="'.$image['sizes']['blog-mobile'].'" data-t="'.$image['url'].'" data-d="'.$image['url'].'" /></div>';
              echo '</div>';

            // Double Image
            elseif( get_row_layout() == 'double_image' ):
              $headline = get_sub_field('headline_double');
              $imageL = get_sub_field('image_left');
              $imageR = get_sub_field('image_right');
              echo '<div class="content-wrap row-'.$count.' double-image">';
              if($headline = get_sub_field('headline_double')) {
                echo '<div class="content-headline">'.$headline.'</div>';
              }
                echo '<div class="image-wrap left"><img class="responsive-img" data-m="'.$imageL['sizes']['blog-mobile'].'" data-t="'.$imageL['url'].'" data-d="'.$imageL['url'].'" /></div>';
                echo '<div class="image-wrap right"><img class="responsive-img" data-m="'.$imageR['sizes']['blog-mobile'].'" data-t="'.$imageR['url'].'" data-d="'.$imageR['url'].'" /></div>';
              echo '</div>';
            endif;
          endwhile;  // End flex content loop.  Nothing more to see here.
          else :
        // No layouts found
        endif;
      echo '</div>';
    echo '</div>'; // End of #blog-content
  }
}

// Featured Posts
function print_featured_post(){
  echo '<div id="featured-post">';
    echo '<div class="wrapper">';
      echo '<h2 class="title">Featured Post</h2>';
      // Set up arguments
      $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1, // Showing only 1 post because, well, it's featured.
        'order' => 'DESC',
        'orderby' => 'date'
      );

      // Query
      $the_query = new WP_Query( $args );

      if( $the_query->have_posts() ) {
        while( $the_query->have_posts() ) {
          $the_query->the_post();
          echo '<div class="post featured">';
            echo '<div class="overlay"></div>';
            echo '<div class="post-wrap responsive-bg" data-m="'.get_the_post_thumbnail_url($post_ID,'mobile-fullscreen').'" data-m-l="'.get_the_post_thumbnail_url($post_ID,'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url($post_ID,'tablet-fullscreen').'" data-d="'.get_the_post_thumbnail_url($post_ID,'blog-featured').'">';
              echo '<div class="post-content-container">';
                echo '<div class="post-title">'.get_the_title().'</div>';
                echo '<h1 class="post-headline">'.get_field('page_headline').'</h1>';
                echo '<div class="link">';
                  echo '<a class="ease" href="'.get_the_permalink().'" rel="nofollow">read it <span class="icon-arrow ease"></span></a>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
        }
      }
      wp_reset_query(); // Reset so we don't break stuff.
    echo '</div>';
  echo '</div>';
}

// Blog Posts
function print_posts($num,$offset,$category){
  global $post;
    echo '<div id="blog-posts">';
       
      // Special argument case for employee page blog section (Checks author's 'name' meta value).
      if(is_singular('employee')) {
        $author_query[] = array (
          'key' => 'name',
          'value' => $post->ID
        );
      }

      // Normal blog query arguments.
      $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $num, // Rather than show all (-1), we can set to a high number so we can offset.  Wordpress's rules, not mine. 
        'offset' => $offset,
        'category_name' => $category,
        'order' => 'DESC',
        'orderby' => 'date',
        'meta_query' => $author_query
      );

      // Query
      $the_query = new WP_Query( $args );

      if( $the_query->have_posts() ) {
        $count = 0;

        echo '<div class="shape"></div>';
        echo '<div class="wrapper">';

          // If on front page (and has posts) then print the section title
          if(is_front_page()) {
            echo '<h2 class="title">Something\'s going on</h2>';
          }
          // If category page (and has posts) then print the section title
          elseif(is_category()) {
            echo '<h2 class="title">'.ucfirst(str_replace("-", " ", $category)).'</h2>';
          }
          // If Employee page (and has posts) then print the section title
          elseif(is_singular('employee')) {
            $name = get_the_title($post->ID);
            $nameArray = explode(' ',trim($name));
            echo '<h2 class="title">'.$nameArray[0].'\'s Blogs</h2>';
          }
          // Blog Page (and has posts) then print the section title
          else { echo '<h2 class="title">Older Posts</h2>'; }
          echo '<div class="posts">';

          while( $the_query->have_posts() ) {
            $count++;
            $the_query->the_post();
            echo '<div class="post row-'.$count.'">';
              echo '<div class="post-wrap">';
                echo '<div class="post-image"><a href="'.get_the_permalink().'"><img class="responsive-img" data-m="'.get_the_post_thumbnail_url($post_ID,'blog-thumb').'" data-m-l="'.get_the_post_thumbnail_url($post_ID,'mobile-fullscreen-l').'" data-t="'.get_the_post_thumbnail_url($post_ID,'blog-thumb').'" data-d="'.get_the_post_thumbnail_url($post_ID,'blog-full').'" /></a></div>';
                echo '<div class="post-title"><a class="ease" href="'.get_the_permalink().'" rel="nofollow">'.get_the_title().'</a></div>';
                echo '<div class="posted-date">'.get_the_date('F d, Y', $post_ID).'</div>';
                echo '<div class="excerpt">'.custom_ACF_excerpt().'</div>';
              echo '</div>';
            echo '</div>';
          }
        }
        wp_reset_query(); // Reset so we don't break stuff.
      echo '</div>'; // End .posts
      if(is_front_page()) {
        echo '<div class="link">';
          echo '<a class="ease" href="'.get_permalink(get_option('page_for_posts')).'" rel="nofollow">See all blogs <span class="icon-arrow ease"></span></a>';
        echo '</div>';
      }
    echo '</div>';
  echo '</div>'; // End #older-posts
}

// Office Image Gallery
function print_office_gallery() {
  if($gallery = get_field('office_image_gallery')) {
    echo '<div id="office-gallery" class="gallery office">';
      // echo '<div class="slidesjs-previous slidesjs-navigation"><span class="icon-gallery-nav ease"></span></div>';
      // echo '<div class="slidesjs-next slidesjs-navigation"><span class="icon-gallery-nav ease"></div>';
      foreach ($gallery as $image) { echo '<img class="responsive-img" data-m="'.$image['image']['sizes']['mobile-gallery'].'" data-m-l="'.$image['image']['sizes']['mobile-fullscreen-l'].'" data-t="'.$image['image']['url'].'" data-d="'.$image['image']['url'].'" />'; }
    echo '</div>';
  }
}

function get_instagram_pics(){
    // @merricktowle // merrick2020
    // Token: 399357217.c61a5dc.9a8ef20ad8cb40548ec1152c4e17c422
    //  merricktowle id399357217

  $your_token = '399357217.c61a5dc.9a8ef20ad8cb40548ec1152c4e17c422';
 
  // I recommend to use "self" if your application is not approved
  $ig_user_id = 'self';
   
  $remote_wp = wp_remote_get( "https://api.instagram.com/v1/users/" . $ig_user_id . "/media/recent/?access_token=" . $your_token );

   
  $instagram_response = json_decode( $remote_wp['body'] );
   
  if( $remote_wp['response']['code'] == 200 ) {

    // Uncomment this for Instagram response data.
    // echo '<pre>'; print_r($instagram_response->data); echo '</pre>';
    echo '<div class="instagram-carousel">';
      foreach( $instagram_response->data as $m ) {
        // // Build images
        echo '<div class="ig-image"><img class="responsive-height" src="' . $m->images->standard_resolution->url . '" title="' . $m->caption->text . '" data-m="200" data-m-l="200" data-t="300" data-d="400" /></div>';
      }
    echo '</div>';
   
  } elseif ( $remote_wp['response']['code'] == 400 ) {
    echo '<b>' . $remote_wp['response']['message'] . ': </b>' . $instagram_response->meta->error_message;
  }
}


function print_IG_section() {
  if($title = get_field('instagram_carousel_title','options')) {
    echo '<div id="instagram">';
      echo '<div class="content-wrap">';
        echo '<div class="shape"></div>';
        echo '<div class="title">'.$title.'</div>';
        if($subtitle = get_field('instagram_carousel_subtitle','options')){
          echo '<div class="subtitle">'.$subtitle.'</div>';
        }
      echo '</div>';
      get_instagram_pics();

      if($link = get_field('link','options')){
        echo '<div class="carousel-links">';
          echo '<div class="link">';
            echo '<a class="ease real-link" href="'.$link['url'].'" rel="nofollow">'.$link['title'].'<span class="icon-arrow ease"></span></a>';
          echo '</div>';

          echo '<div class="link social-links">';
            echo '<span class="faux-link">follow us<span class="icon-arrow ease"></span></span>';
            echo '<div class="social-container">';
            echo '<div class="triangle"></div>';
              print_social();
            echo '</div>';
          echo '</div>';

        echo '</div>';

      }
    echo '</div>';
  }
}

// Contact Page
function print_contact_content() {
  if($copy = get_field('form_copy')) {
    echo '<div class="contact-wrapper">';
      echo '<div class="contact-right">';
        echo '<div class="telephone">P: ';
          echo '<a href="tel:+1'.clean_phone(get_field('phone','options')).'" class="phone-number ease">'.get_field('phone','options').'</a>';
        echo '</div>';
        print_social();
        print_logo();
        print_address();
        print_office_hours();
        print_directions();
      echo '</div>';
      echo '<div class="contact-left">';
        echo '<div class="copy">'.$copy.'</div>';
        print_form();
      echo '</div>';
    echo '</div>';
  }
}

//Career Page
function print_career_content() {
  echo '<div class="career-wrapper">';
    echo '<div class="career-left">';
      if($content = get_field('description')) {
        echo '<div class="copy">';
          echo $content;
        echo '</div>';
      }
    echo '</div>';
    echo '<div class="career-right">';
    if ($form_snippet = get_field('form_snippet')) {
      echo '<div class="form">';
        eval($form_snippet);
        // echo FrmFormsController::get_form_shortcode( array( 'id' => 10, 'title' => false, 'description' => false ) );
      echo '</div>';
    }
    echo '</div>';
  echo '</div>';
}