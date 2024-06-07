$(document).ready(function () {
    var selectsContent = $(".selected");
    var items = $(".items-selected span");
    $(selectsContent).each(function () {
        $(this).on("click", function () {
            closeSelects(this);
            var selectedItems = $(this).next(".items-selected");
            selectedItems.toggleClass("show");
            $(this).find(".arrow-select").toggleClass("rotate");
            if (selectedItems.hasClass("show")) {
                selectedItems.css("display", "flex");
                $(this).find(".arrow-select").addClass("rotate");
            } else {
                selectedItems.css("display", "none");
                $(this).find(".arrow-select").removeClass("rotate");
            }
        });
    });

    $(items).each(function () {
        $(this).on("click", function () {
            var item = $(this).html();
            var value = $(this).data("value");
            var input = $(this).data("input");
            var selected = $(this)
                .closest(".items-selected")
                .prev(".selected")
                .find(".item-selected");
            selected.html(item);
            $("#" + input)
                .val(value)
                .trigger("searchStatus");
            $(this)
                .closest(".items-selected")
                .css("display", "none")
                .removeClass("show");
            $(this)
                .closest(".selected")
                .find(".arrow-select")
                .removeClass("rotate");
        });
    });

    function closeSelects(thisSelect) {
        $(".items-selected")
            .not($(thisSelect).next())
            .removeClass("show")
            .css("display", "none");
        $(".arrow-select")
            .not($(thisSelect).find(".arrow-select"))
            .removeClass("rotate");
    }

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".selected").length) {
            $(".items-selected").css("display", "none");
            $(".items-selected").removeClass("show");
            $(".arrow-select").removeClass("rotate");
        }
    });
});
