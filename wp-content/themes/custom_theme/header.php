<header id="masthead" class="site-header" style="background-color: <?php echo get_theme_mod('header_background_color', '#ffffff'); ?>; color: <?php echo get_theme_mod('header_text_color', '#333333'); ?>;">
    <div class="header-content">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <div class="site-logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php else : ?>
                <?php if (get_theme_mod('header_logo')) : ?>
                    <div class="site-logo">
                        <img src="<?php echo esc_url(get_theme_mod('header_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                    </div>
                    
                        <head>
    <?php $font_family = get_theme_mod('font_family', 'Arial, sans-serif'); ?>
    <style>
        body {
            font-family: <?php echo esc_attr($font_family); ?>;
        }
    </style>
</head>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                    </h1>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <nav id="site-navigation" class="main-navigation">
            <?php wp_nav_menu(array('theme_location' => 'primary-menu')); ?>
        </nav>
    </div>
<?php
$custom_logo_id = get_theme_mod('custom_logo');
$custom_logo = wp_get_attachment_image_src($custom_logo_id, 'full');
?>
<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
    <?php if ($custom_logo) : ?>
        <img src="<?php echo esc_url($custom_logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <?php else : ?>
        <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
    <?php endif; ?>
</a>

</header>

