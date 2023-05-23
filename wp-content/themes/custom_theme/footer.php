  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <?php if (is_active_sidebar('footer-1')) {
            dynamic_sidebar('footer-1');
          } ?>
        </div>
        <div class="col-md-3">
          <?php if (is_active_sidebar('footer-2')) {
            dynamic_sidebar('footer-2');
          } ?>
        </div>
        <div class="col-md-3">
          <?php if (is_active_sidebar('footer-3')) {
            dynamic_sidebar('footer-3');
          } ?>
        </div>
        <div class="col-md-3">
          <?php if (is_active_sidebar('footer-4')) {
            dynamic_sidebar('footer-4');
          } ?>
        </div>
      </div>
      <div class="row">
        <div class="col">
               
          <footer id="colophon" class="site-footer" style="background-color: <?php echo get_theme_mod('footer_background_color', '#f5f5f5'); ?>; color: <?php echo get_theme_mod('footer_text_color', '#333333'); ?>;">
    <div class="footer-content">
        <div class="footer-text">
            <?php echo get_theme_mod('footer_copyright_text', ''); ?>
        </div>
    </div>
</footer>
        </div><!-- .col -->
      </div><!-- .row -->
    </div><!-- .container -->
  </footer>

  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/jquery-3.2.1.slim.min.js"></script>
  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/popper.min.js"></script>
  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
  <script src="<?php echo get_bloginfo('template_directory'); ?>/js/app.js"></script>
  
  <?php wp_footer(); ?>
</body>
</html>
