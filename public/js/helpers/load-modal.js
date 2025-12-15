$(document).ready(function () {
    $(document).on("click", ".loadModal", function (e) {
        e.preventDefault();
        const modalId = $(this).attr("data-modal-id");

        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            success: function (data) {
                $("#modalContainer").html(data);
                $("#modalContainer").find(".modal").modal("show");

                // if (modalId) {
                //     $(`#${modalId}`).modal("show");
                // } else {
                //     $("#modalContainer").find(".modal:last").modal("show");
                // }
                // var myModal = new bootstrap.Modal(
                //     document.querySelector("#modalContainer .modal")
                // );
                // myModal.show();
            },
        });
    });

    // Listen for the hidden.bs.modal event to remove the modal from the DOM
    // $(".loadModal").on("hidden.bs.modal", function () {
    //     $("#modalContainer").html("");
    // });

    $(document).on("click", '[data-bs-dismiss="modal"]', function () {
        $(this).parents(".modal").modal("hide");
    });

    $(".modal").on("show.bs.modal", function () {
        console.log('111');
        
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function () {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });

    $(".modal").on("hidden.bs.modal", function () {
        console.log('sss');
        
        if ($(".modal:visible").length) {
            $("body").addClass("modal-open");
        }
    });
});
