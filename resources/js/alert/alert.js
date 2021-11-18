import Swal from "sweetalert2";


export function AMDelete(callback) {
    Swal.fire({
        title: 'Estas seguro de  eliminar?',
        text: "Este dato ya no se podra recuperar!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    })

}
export function AMError(message) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message
    });
}
export function AMSuccess(message) {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
}