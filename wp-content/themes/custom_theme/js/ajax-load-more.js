jQuery(function($) {
  var page = 2; // Initial page number
  var loading = false; // Variable to prevent multiple AJAX requests

  function loadMorePosts() {
    if (!loading) {
      loading = true;
      $('.load-more-button').addClass('loading');

      $.ajax({
        url: ajaxurl, // WordPress AJAX handler URL
        type: 'post',
        data: {
          action: 'load_more_products',
          page: page,
        },
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
  }

  $('.load-more-button').on('click', function(e) {
    e.preventDefault();
    loadMorePosts();
  });
});
