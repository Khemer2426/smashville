class tfaNotification {
    static init() {
        Swal.fire({
            html: `
                <p>Enhance your account security by enabling Two-Factor Authentication in your account security.</p>
                <label>
                    <input type="checkbox" id="tfa_not_show"> Don't show this again.
                </label>`,
            showCancelButton: true,
            icon: 'info',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-success m-2 mb-4',
                cancelButton: 'btn btn-black m-2 mb-4'
            },
            buttonsStyling: false,
            confirmButtonText: 'Set Up Now',
            cancelButtonText: 'Set Up Later',
        }).then((result) => {
            var isChecked = document.getElementById('tfa_not_show').checked;
            if (result.isConfirmed) {
                if (isChecked) {
                    localStorage.setItem('tfa_not_show', true);
                }
                if ($('#modal-in-review-profile').hasClass('show') || $('#modal-notification').hasClass('show') || $('#modal-migrated-user').hasClass('show')) {
                    $('#modal-in-review-profile').modal('hide');
                    $('#modal-notification').modal('hide');
                    $('#modal-migrated-user').modal('hide');
        
                    $('#modal-in-review-profile, #modal-notification, #modal-migrated-user').on('hidden.bs.modal', function () {
                        window.location.href = profile_route;
                    });
                } else {
                    window.location.href = profile_route;
                }
            } else if (isChecked) {
                $.ajax({
                    url: tfa_hide_route,
                    method: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
        });
    }
}

One.onLoad(() => tfaNotification.init());