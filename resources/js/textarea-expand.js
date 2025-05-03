class textareaExand {

    static init() {

      $(document).on('input', '.textarea-expand', function () {
         $(this).css('height', '');
         $(this).css('height', ($(this).prop('scrollHeight') + 2) + 'px');
      });

      $('.textarea-expand').each(function () {
         $(this).css('height', '');
         $(this).css('height', ($(this).prop('scrollHeight') + 2) + 'px');
      });
    }
  }
  
  // Initialize when page loads
  One.onLoad(() => textareaExand.init());