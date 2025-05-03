class jsRequest {
    
    static bindRequest(el, msg, method = 'post') {
        $(el).validate({
            submitHandler: function (form) {
                var form = $(form);
                form.find('.btn-submit').prop('disabled', true);
                form.find('.btn-submit').addClass('disabled');
                var url = form.attr('action');
                $.ajax({
                    url: url,
                    data: form.serialize(),
                    method: method,
                    success: function () {
                        Swal.fire({
                            title: 'Success',
                            text: msg,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (res) {
                        form.find('.btn-submit').prop('disabled', false);
                        form.find('.btn-submit').removeClass('disabled');
                        if (res.status == 422) {
                            var errors = res.responseJSON.errors;
                            var key = Object.keys(errors)[0];
                            Swal.fire('Sorry', res.responseJSON.errors[key][0], 'error');
                        } else if (res.status == 400) {
                            var error = res.responseJSON.error;
                            Swal.fire('', error, 'error');
                        } else {
                            Swal.fire('Sorry', 'Something went wrong. Please try again', 'error');
                        }
                    }
                });
            }
        });
    }

    static onClickConfirm(el, confirmMessage, msg, method = 'post') {

        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $(document).on('click', el, function(e) {
            e.preventDefault();
            var $this = $(this);
            Swal.fire({
                title: '',
                text: confirmMessage,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#A569BD'
            }).then((result) => {
                if (result.value) {
                    var url = $this.attr('href');
                    $.ajax({
                        url: url,
                        method: method,
                        success: function () {
                            Swal.fire({
                                title: 'Success',
                                text: msg,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (res) {
                            if (res.status == 422) {
                                var errors = res.responseJSON.errors;
                                var key = Object.keys(errors)[0];
                                Swal.fire('Sorry', res.responseJSON.errors[key][0], 'error');
                            } else if (res.status == 400) {
                                var error = res.responseJSON.error;
                                Swal.fire('', error, 'error');
                            } else {
                                Swal.fire('Sorry', 'Something went wrong. Please try again', 'error');
                            }
                        }
                    });
                }
            });
        });
    }
}

// Export if using ES6 modules
export default jsRequest;