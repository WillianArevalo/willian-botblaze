$(document).ready(function () {
    var selectsContent = $(".selected");
    var items = $(".items-selected span");
    $(selectsContent).each(function () {
        selectsContent.on("click", function () {
            var selectedItems = $(this).next(".items-selected");
            selectedItems.toggleClass("show");
            $(".arrow-select").toggleClass("rotate");
            if (selectedItems.hasClass("show")) {
                selectedItems.css("display", "flex");
                $(".arrow-select").addClass("rotate");
            } else {
                selectedItems.css("display", "none");
                $(".arrow-select").removeClass("rotate");
            }
        });
    });

    $(items).each(function () {
        items.on("click", function () {
            var item = $(this).text();
            var role = $(this).data("role");
            var selected = $(this)
                .parent()
                .prev(".selected")
                .children(".item-selected");
            selected.text(item);
            $("#role").val(role);
            $(this).parent().css("display", "none");
            $(this).parent().removeClass("show");
            $(".arrow-select").removeClass("rotate");
        });
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".selected").length) {
            $(".items-selected").css("display", "none");
            $(".items-selected").removeClass("show");
            $(".arrow-select").removeClass("rotate");
        }
    });
});
