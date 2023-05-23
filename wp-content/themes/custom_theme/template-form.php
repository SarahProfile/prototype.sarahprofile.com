<?php
/*
Template Name: Custom Form Template
*/

get_header();
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <div class="form-container">
      <h2>Contact Form</h2>
      <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
        <input type="hidden" name="action" value="custom_form_submission">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>

  </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
