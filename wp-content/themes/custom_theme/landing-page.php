<?php
/*
Template Name: Custom Landing Page
*/

get_header();

// Custom landing page content goes here
?>
<div class="landing-page" style="background-image: url(<?php echo esc_url(get_theme_mod('hero_background_image')); ?>);">
    <section class="hero">
        <h1 style="color: <?php echo esc_attr(get_theme_mod('hero_title_color', '#ffffff')); ?>"><?php the_title(); ?></h1>
        <p><?php the_content(); ?></p>
    </section>

    <section class="features">
        <h2>Features</h2>
        <!-- Add your feature content here -->
    </section>
</div>
<?php

get_footer();
