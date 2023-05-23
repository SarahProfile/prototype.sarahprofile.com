<?php
function register_my_menus() {
  register_nav_menus(array(
		'header-menu' => 'Header Menu',
	));
}
add_action( 'init', 'register_my_menus' );

function register_my_widgets() {
  register_sidebar(array(
    'name' => 'Sidebar',
    'id' => 'sidebar-1',
		'description'   => 'Custom Sidebar Widget',
    'before_widget' => '<div class="sidebar-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'name' => 'Footer 1',
    'id' => 'footer-1',
		'description'   => 'Custom Footer Widget',
    'before_widget' => '<div class="footer-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'name' => 'Footer 2',
    'id' => 'footer-2',
		'description'   => 'Custom Footer Widget',
    'before_widget' => '<div class="footer-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'name' => 'Footer 3',
    'id' => 'footer-3',
    'description'   => 'Custom Footer Widget',
    'before_widget' => '<div class="footer-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
  register_sidebar(array(
    'name' => 'Footer 4',
    'id' => 'footer-4',
    'description'   => 'Custom Footer Widget',
    'before_widget' => '<div class="footer-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
  ));
}
add_action( 'widgets_init', 'register_my_widgets' );

function register_my_customizations( $wp_customize ) {
   // setting
   $wp_customize->add_setting( 'header_color' , array(
    'default'   => '#000000',
    'transport' => 'refresh',
    ));
    // section
    $wp_customize->add_section( 'colors' , array(
      'title'      => __( 'Colors', 'custom_theme' ),
      'priority'   => 30,
    ));
    // control
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
    	 'label'      => __( 'Header Color', 'custom_theme' ),
  	   'section'    => 'colors',
  	   'settings'   => 'header_color',
     ))
    );
}
add_action( 'customize_register', 'register_my_customizations' );

function apply_my_customizations() {
  echo '<style type="text/css">'.
          'h1 { color: '.get_theme_mod('header_color','#000000').'; }'.
       '</style>';
}
add_action( 'wp_head', 'apply_my_customizations');
function custom_theme_customizer_settings($wp_customize) {
    // Add a section for header settings
    $wp_customize->add_section('header_settings', array(
        'title' => __('Header Settings', 'custom-theme'),
        'priority' => 30,
    ));

    // Add a setting for the header background color
    $wp_customize->add_setting('header_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Add a control for the header background color
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_background_color', array(
        'label' => __('Header Background Color', 'custom-theme'),
        'section' => 'header_settings',
        'settings' => 'header_background_color',
    )));

    // Add a setting for the header text color
    $wp_customize->add_setting('header_text_color', array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Add a control for the header text color
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_text_color', array(
        'label' => __('Header Text Color', 'custom-theme'),
        'section' => 'header_settings',
        'settings' => 'header_text_color',
    )));
        add_theme_support('custom-logo');
    // Add a setting for the header logo
    $wp_customize->add_setting('header_logo');

    // Add a control for the header logo
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array(
        'label' => __('Header Logo', 'custom-theme'),
        'section' => 'header_settings',
        'settings' => 'header_logo',
    )));
        // Add a section for landing page settings
    $wp_customize->add_section('landing_page_settings', array(
        'title' => __('Landing Page Settings', 'custom-theme'),
        'priority' => 30,
    ));

    // Add a setting for the hero background image
    $wp_customize->add_setting('hero_background_image');

    // Add a control for the hero background image
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Hero Background Image', 'custom-theme'),
        'section' => 'landing_page_settings',
        'settings' => 'hero_background_image',
    )));

    // Add a setting for the hero title color
    $wp_customize->add_setting('hero_title_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Add a control for the hero title color
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_title_color', array(
        'label' => __('Hero Title Color', 'custom-theme'),
        'section' => 'landing_page_settings',
        'settings' => 'hero_title_color',
    )));
   // Add a section for font settings
    $wp_customize->add_section('font_settings', array(
        'title' => __('Font Settings', 'custom-theme'),
        'priority' => 30,
    ));

    // Add a setting for the font family
    $wp_customize->add_setting('font_family', array(
        'default' => 'Arial, sans-serif',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add a control for the font family
    $wp_customize->add_control('font_family', array(
        'label' => __('Font Family', 'custom-theme'),
        'section' => 'font_settings',
        'type' => 'text',
    ));
    $wp_customize->add_section('custom_home_page', array(
        'title' => __('Home Page Settings', 'custom_theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('home_page_layout', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('home_page_layout', array(
        'label' => __('Select Home Page Layout', 'custom_theme'),
        'section' => 'custom_home_page',
        'type' => 'select',
        'choices' => array(
            'default' => __('Default', 'custom_theme'),
            'custom' => __('Custom', 'custom_theme'),
        ),
    ));
}
add_action('customize_register', 'custom_theme_customizer_settings');

function load_more_products() {
  $page = $_POST['page'];

  $args = array(
    'post_type' => 'product',
    'posts_per_page' => 3,
    'paged' => $page,
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      wc_get_template_part('content', 'product');
    }
    wp_reset_postdata();
  } else {
    echo false; // No more products to load
  }

  die();
}
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

//add short code for the see more product list

function custom_product_shortcode() {
  ob_start();
  ?>
  <div class="product-container">
    <?php
    $args = array(
      'post_type' => 'product',
      'posts_per_page' => 3,
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        wc_get_template_part('content', 'product');
      }
      wp_reset_postdata();
    }
    ?>
  </div>

  <button class="load-more-button">Load More<span style="font-size: 15px;
    padding: 15px;
    position: relative;
    bottom: 5px;">▼</span> </button>

  <script>
    jQuery(function($) {
      var page = 2; // Initial page number
      var loading = false; // Variable to prevent multiple AJAX requests

      $('.load-more-button').on('click', function(e) {
        e.preventDefault();

        if (!loading) {
          loading = true;
          $(this).addClass('loading');

          var data = {
            action: 'load_more_products',
            page: page,
          };

          $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: data,
            success: function(response) {
              if (response) {
                $('.product-container').append(response);
                page++;
                loading = false;
                $('.load-more-button').removeClass('loading');
              } else {
                $('.load-more-button').addClass('disabled').text('No more products');
              }
            },
            error: function() {
              console.log('Error loading products');
              loading = false;
              $('.load-more-button').removeClass('loading');
            },
          });
        }
      });
    });
  </script>
  <?php
  return ob_get_clean();
}
add_shortcode('custom_product', 'custom_product_shortcode');
function handle_custom_form_submission() {
  // Retrieve form data
  $name = sanitize_text_field( $_POST['name'] );
  $email = sanitize_email( $_POST['email'] );
  $message = sanitize_textarea_field( $_POST['message'] );

  // Process the form data (e.g., send an email, store in the database, etc.)
  // Add your custom logic here

  // Redirect the user after form submission
  wp_redirect( home_url( '/thank-you' ) );
  exit;
}
add_action( 'admin_post_nopriv_custom_form_submission', 'handle_custom_form_submission' );
add_action( 'admin_post_custom_form_submission', 'handle_custom_form_submission' );

//add custome form

function custom_form_shortcode() {
  ob_start();

  if (isset($_POST['submit_custom_form'])) {
    // Form submitted, process the data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone_code = sanitize_text_field($_POST['phone_code']);
    $phone_number = sanitize_text_field($_POST['phone_number']);
    $price = sanitize_text_field($_POST['price']);
    $message = sanitize_textarea_field($_POST['message']);

    // Perform form processing tasks (e.g., send an email, store data)

    // Display success message
    echo '<div class="custom-form-success">Form submitted successfully!</div>';
  }

  // Display the form
  ?>
  <style>
    .custom-form-container {
    max-width: 100%;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 20px;
    border: none;
    border-radius: 5px;
}

    .custom-form-container h2 {
      margin-top: 0;
    }

    .custom-form-container input[type="text"],
    .custom-form-container input[type="email"],
    .custom-form-container select,
    .custom-form-container textarea {
      
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: none;
    border-radius: 4px;
    background-color: #f4f4f9;
}

    

    .custom-form-container button {
      background-color: #b8834d;
    color: #fff;
    border: none;
    padding: 10px 100px;
    cursor: pointer;
    border-radius: 4px;
    }

    .custom-form-success {
      margin-top: 20px;
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      border: 1px solid #c3e6cb;
      border-radius: 4px;
    }
    
  </style>
  <div class="custom-form-container">
  
    <form method="post">
      <label for="name" >Name</label> <br>
      <input  type="text" name="name" id="name"  required>

      <label for="email">Email</label><br>
      <input type="email" name="email" id="email"  required>

     
        <label for="phone">Phone Number</label><br>
       
        <input type="hidden" name="phone_code" value="+971">
        <input type="tel" name="phone_number" id="phone" required><br>
        
    

      <label for="price">Investment Amount</label><br>
      <select name="price" id="price-investment" required>
        <option value="100">100,000 EUR</option>
        <option value="200">200,000 EUR</option>
        <option value="300">300,000 EUR</option>
      </select>

      <label for="message">Message</label><br>
      <textarea style="padding:40px" name="message" id="message"  required></textarea>

      <button type="submit" name="submit_custom_form">Submit</button>
    </form>
  </div>
  <?php

  return ob_get_clean();
}
add_shortcode('custom_form', 'custom_form_shortcode');

//add text after price
function custom_price_text( $price, $product ) {
    $text = '<br> <table>
<thead style="color:black; font-size:20px; ">
<th style="padding-left:10px">Quarterly</th>
<th>20%</th>

</thead>
<tbody style="font-size:20px;     color: #a2a4a8;
    font-weight: 100; ">
<tr>
<td>paid return</td><td>annual yield</td>

</tr>
</tbody>
</table>'; // Change this to the desired text
    
    $price .= $text;
    
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'custom_price_text', 10, 2 );

//add button after price

function custom_button_after_price() {
    echo '<a href="#" class="custom-button">Enquire Now</a>';
}
add_action( 'woocommerce_after_shop_loop_item_title', 'custom_button_after_price' );



?>
