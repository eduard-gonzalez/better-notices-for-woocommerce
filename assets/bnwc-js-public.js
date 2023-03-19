jQuery(function($) {
  $('.single_add_to_cart_button').on('click', function(event) {
    var $button = $(this);

    if ($button.hasClass('disabled')) {
      event.preventDefault();

      var errorMessage;

      if ($button.hasClass('wc-variation-is-unavailable')) {
        errorMessage = 'Sorry, this product is unavailable. Please choose a different combination.';
      } else if ($button.hasClass('wc-variation-selection-needed')) {
        errorMessage = 'Please choose product options before adding this product to your cart.';
      }

      if (errorMessage) {
        Swal.fire({
          title: errorMessage,
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }

      return false;
    }
  });
});
