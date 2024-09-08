import './bootstrap';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const alertTitle = window.sweetAlertTitle || 'Notification';

    if (window.sessionSuccess) {
        Swal.fire({
            icon: 'success',
            title: alertTitle,
            text: window.sessionSuccess,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = window.redirectUrl;
            }
        });
    }

    if (window.errorMessages) {
        Swal.fire({
            icon: 'error',
            title: alertTitle,
            html: window.errorMessages,
            confirmButtonText: 'Try Again'
        });
    }
});

window.confirmDelete = (event, form) => {
    event.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
};
