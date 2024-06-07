$(document).ready(function () {
    $(".btnDeleteMovement").on("click", function () {
        Swal.fire({
            title: "¿Estas seguro de eliminar este movimiento?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6d28d9",
            cancelButtonColor: "#c41b22",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).parent().submit();
            }
        });
    });
});
