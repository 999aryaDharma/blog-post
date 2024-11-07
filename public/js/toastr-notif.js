$(document).ready(function () {
    // Set global toastr options
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right", // Sesuaikan dengan kebutuhan
        preventDuplicates: true,
        onclick: null,
        showDuration: "5000",
        hideDuration: "5000",
        timeOut: "5000",
        extendedTimeOut: "3000",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    // Cek session success dan tampilkan toastr jika ada
    if (sessionStorage.getItem("successMessage")) {
        toastr.success(sessionStorage.getItem("successMessage"));
        sessionStorage.removeItem("successMessage");
    }

    // Cek session error dan tampilkan toastr jika ada
    if (sessionStorage.getItem("errorMessage")) {
        toastr.error(sessionStorage.getItem("errorMessage"));
        sessionStorage.removeItem("errorMessage");
    }
});
