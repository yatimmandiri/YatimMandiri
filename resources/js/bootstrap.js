import Popper from "@popperjs/core/dist/umd/popper.js";
import jQuery from "jquery";
import axios from "axios";
import ajaxForm from "jquery-form";
import Select2 from "select2";
import Swal from "sweetalert2";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import moment from "moment";
import "bootstrap";
import "datatables.net-bs4";
import "datatables.net-buttons-bs4";
import "datatables.net-responsive-bs4";
import "datatables.net-select-bs4";

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// PopperJs
window.Popper = Popper;

// JQuery
window.$ = window.jQuery = jQuery;

// Jquery CSRF
jQuery.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// AjaxForm
ajaxForm(window, jQuery);

// AjaxRequest
window.ajaxRequest = ({ url, type = "GET", params }) => {
    return $.ajax({
        url: url,
        type: type,
        data: params,
        dataType: "JSON",
    });
};

// Select2
Select2(window, jQuery);
$.fn.select2.defaults.set("theme", "bootstrap-5");
$.fn.select2.defaults.set("width", "100%");

// Set Data Select2
window.setDataSelect = ({
    tagid,
    placeholder,
    data,
    dataSelected,
    modalid,
}) => {
    if (modalid) {
        $.fn.select2.defaults.set("dropdownParent", $(modalid));
    }

    $(tagid)
        .select2({
            placeholder: placeholder,
            data: data,
        })
        .val(dataSelected)
        .trigger("change");
};

// Reset Data Select2
window.resetDataSelect = ({ tagid, placeholder }) => {
    $(tagid)
        .select2({
            placeholder: placeholder,
        })
        .val(null)
        .trigger("change");
};

// Set Input Value
window.setInputValue = function (idtag, value) {
    $(idtag).val(value);
};

// Set Text Value
window.setTextValue = function (idtag, value) {
    $(idtag).text(value);
};

// Toast
const Toast = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 5000,
});
window.Toast = Toast;

// Populer Confirmation
window.populerConfirmation = function ({ populer, url, methods, tableId }) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: `btn ${
                populer == "Y" ? "btn-danger" : "btn-success"
            } text-white`,
            cancelButton: "btn btn-secondary text-white",
            actions: "g-3",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            icon: "warning",
            title: "Confirmation",
            text: `Do you want to ${
                populer == "Y" ? "Not Populer" : "Populer"
            } this?`,
            confirmButtonText: `${populer == "Y" ? "Not Populer" : "Populer"}`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: methods,
                    error: function (request, error) {
                        Toast.fire({
                            icon: "error",
                            title: request.responseJSON.message,
                        });
                    },
                    success: function (result) {
                        Toast.fire({
                            icon: "success",
                            title: result.message,
                        });
                        $(tableId).DataTable().ajax.reload();
                    },
                });
            }
        });
};

// Recoomendation Confirmation
window.recomendationConfirmation = function ({
    populer,
    url,
    methods,
    tableId,
}) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: `btn ${
                populer == "Y" ? "btn-danger" : "btn-success"
            } text-white`,
            cancelButton: "btn btn-secondary text-white",
            actions: "g-3",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            icon: "warning",
            title: "Confirmation",
            text: `Do you want to ${
                populer == "Y" ? "Not Recomendation" : "Recomendation"
            } this?`,
            confirmButtonText: `${
                populer == "Y" ? "Not Recomendation" : "Recomendation"
            }`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: methods,
                    error: function (request, error) {
                        Toast.fire({
                            icon: "error",
                            title: request.responseJSON.message,
                        });
                    },
                    success: function (result) {
                        Toast.fire({
                            icon: "success",
                            title: result.message,
                        });
                        $(tableId).DataTable().ajax.reload();
                    },
                });
            }
        });
};

// Active Confirmation
window.activeConfirmation = function ({ active, url, methods, tableId }) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: `btn ${
                active == "Y" ? "btn-danger" : "btn-success"
            } text-white`,
            cancelButton: "btn btn-secondary text-white",
            actions: "g-3",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            icon: "warning",
            title: "Confirmation",
            text: `Do you want to ${
                active == "Y" ? "Disable" : "Enable"
            } this?`,
            confirmButtonText: `${active == "Y" ? "Disable" : "Enable"}`,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: methods,
                    error: function (request, error) {
                        Toast.fire({
                            icon: "error",
                            title: request.responseJSON.message,
                        });
                    },
                    success: function (result) {
                        Toast.fire({
                            icon: "success",
                            title: result.message,
                        });
                        $(tableId).DataTable().ajax.reload();
                    },
                });
            }
        });
};

// Restore Confirmation
window.restoreConfirm = function (url, tableid) {
    Swal.fire({
        icon: "warning",
        text: "Do you want to restore this?",
        showCancelButton: true,
        confirmButtonText: "Restore",
        confirmButtonColor: "#32CD32",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "PUT",
                error: function (request, error) {
                    Toast.fire({
                        icon: "error",
                        title: request.responseJSON.message,
                    });
                },
                success: function (result) {
                    Toast.fire({
                        icon: "success",
                        title: result.message,
                    });

                    $(tableid).DataTable().ajax.reload();
                },
            });
        }
    });
};

// Delete Confirmation
window.deleteConfirm = function (url, tableid) {
    Swal.fire({
        icon: "warning",
        text: "Do you want to delete this?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "#e3342f",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                error: function (request, error) {
                    Toast.fire({
                        icon: "error",
                        title: request.responseJSON.message,
                    });
                },
                success: function (result) {
                    Toast.fire({
                        icon: "success",
                        title: result.message,
                    });

                    $(tableid).DataTable().ajax.reload();
                },
            });
        }
    });
};

// Format Rupiah
window.formatRupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(number);
};

// Get Date Between Array
window.getDates = (startDate, stopDate) => {
    var dateArray = [];
    var currentDate = moment(startDate);
    var stopDate = moment(stopDate);
    while (currentDate <= stopDate) {
        dateArray.push(moment(currentDate).format("D"));
        currentDate = moment(currentDate).add(1, "days");
    }
    return dateArray;
};

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
