<?php get_header(); ?>

  <main>
    <div class="container">

      <div class="row">

        <section class="col-md-9">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    				get_template_part( 'single', get_post_format() );
    			endwhile; endif;

          if (comments_open() || get_comments_number()) {
            comments_template();
          } ?>
        </section>

        <?php get_sidebar(); ?>

      </div><!-- .row -->
    </div><!-- .container -->
       <?php if (get_theme_mod('home_page_layout', 'default') === 'custom') {
    // Custom home page layout
    get_template_part('template-parts/home-custom');
} else {
    // Default home page layout
    get_template_part('template-parts/home-default');
}?>
  </main>

<?php get_footer(); ?>
