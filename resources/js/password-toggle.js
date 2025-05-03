class PasswordToggle {
    static init() {
        $(document).on('click','.password_toggle', function(event) {
            event.preventDefault();
            var input = $('#' + $(this).data('target'));
            if(input.attr("type") == "text"){
                input.attr('type', 'password');
                $(this).children('i').addClass("fa-eye-slash");
                $(this).children('i').removeClass("fa-eye");
            }else if(input.attr("type") == "password"){
                input.attr('type', 'text');
                $(this).children('i').removeClass("fa-eye-slash");
                $(this).children('i').addClass("fa-eye");
            }
        });
    }
}
// Initialize when page loads
One.onLoad(() => PasswordToggle.init());