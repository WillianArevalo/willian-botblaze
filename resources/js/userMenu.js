$(document).ready(function () {
    const userMenu = $(".userMenu");
    $(".userImage").on("click", function () {
        userMenu.toggleClass("active");
    });

    $(document).on("click", function (e) {
        if (
            !$(e.target).closest(".userImage").length &&
            !$(e.target).closest(".userMenu").length
        ) {
            userMenu.removeClass("active");
        }
    });

    $(document).on("scroll", function () {
        if (userMenu.hasClass("active")) {
            userMenu.removeClass("active");
        }
    });

    $(".buttonHamburger").click(function () {
        $(".adminHeader").toggleClass("active");
    });

    $(".buttonClose").click(function () {
        $(".adminHeader").removeClass("active");
    });
});
