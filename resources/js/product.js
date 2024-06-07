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

    let myValue = $(".window");
    function updateValueBasedOnScreenSize() {
        const mediaQuery = window.matchMedia("(max-width: 640px)");
        function handleScreenSizeChange(event) {
            if (event.matches) {
                myValue.val("mobile");
            } else {
                myValue.val("desktop");
            }
            console.log("El valor actual es:", myValue);
        }
        mediaQuery.addListener(handleScreenSizeChange);
        handleScreenSizeChange(mediaQuery);
    }
    updateValueBasedOnScreenSize();

    $("#inputSearchProduct").on("input", function () {
        let data = $("#formSearch").serialize();
        $("#inputSearchStatus").val("");
        $.ajax({
            url: $("#formSearch").attr("action"),
            type: "POST",
            data: data,
            success: function (response) {
                if (myValue.val() == "mobile") {
                    $("#cardsProduct").html(response);
                } else {
                    $("#tableProduct").html(response);
                }
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
                if (myValue.val() == "mobile") {
                    $("#cardsProduct").html(response);
                } else {
                    $("#tableProduct").html(response);
                }
            },
        });
    });
});
