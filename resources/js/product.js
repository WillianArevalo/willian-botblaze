$(document).ready(function () {
    $("#uploadImage").on("click", function () {
        $("#image").click();
    });

    $("#image").on("change", function () {
        var photo = this.files[0];
        if (photo) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#previewImage").attr("src", e.target.result);
            };
            reader.readAsDataURL(photo);
        }
    });

    /*  $(".btnDeleteUser").on("click", function () {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3b82f6",
            cancelButtonColor: "#ef4444",
            confirmButtonText: "Sí, eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#formUser").submit();
            }
        });
    }); */
});
