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

    $(".btnDeleteProduct").on("click", function () {
        Swal.fire({
            title: "¿Estas seguro?",
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

    $("#inputSearchProduct").on("input", function () {
        let data = $("#formSearch").serialize();
        $("#inputSearchStatus").val("");
        $.ajax({
            url: $("#formSearch").attr("action"),
            type: "POST",
            data: data,
            success: function (response) {
                $("#tableProduct").html(response);
            },
        });
    });

    $("#searchStatus").on("searchStatus", function () {
        let data = $("#formSearchStatus").serialize();
        $("#inputSearchProduct").val("");
        $.ajax({
            url: $("#formSearchStatus").attr("action"),
            type: "POST",
            data: data,
            success: function (response) {
                $("#tableProduct").html(response);
            },
        });
    });
});
