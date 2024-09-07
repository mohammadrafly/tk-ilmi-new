import './bootstrap';
import Swal from 'sweetalert2';

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
