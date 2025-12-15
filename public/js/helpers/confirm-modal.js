"use strict";

function appendDeleteModal() {
    const delete_modal = `

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-body">

              <div class="centerContPopup">
                  <div class="suspendContBlock">
                      <div class="icon"><i id="status-icon" class="icon-delete"></i></div>
                      <h4 id="Modal_head"></h4>
                      <p id="Modal_msg"></p>
                  </div>
              </div>

              <div class="text-center mt-4">
                  <button type="button" class="btn btn-primary me-2 modal-confirm" id="confirm-modal-yes">Confirm</button>
                  <button type="button" data-bs-dismiss="modal"
                      class="btn btn-outline-primary waves-effect">Cancel</button>
              </div>

          </div>

      </div>
  </div>
</div>`;

    $("#confirmModal").remove();
    $("body").append(delete_modal);
}

function openConfirmModal(
    type,
    name,
    data_url,
    data_method = "get",
    data_post_data
) {
    appendDeleteModal();

    $("#Modal_head").html(`${type} ${name.replace(/_/g, " ")}`);
    $("#Modal_msg").html(
        `Are you sure! Do you want to ${type} the ${name.replace(/_/g, " ")}?`
    );

    $("#confirm-modal-yes").attr("data-url", data_url);
    $("#confirm-modal-yes").attr("data-method", data_method);
    $("#confirm-modal-yes").attr(
        "data-post-data",
        JSON.stringify(data_post_data)
    );
    $("#delete_modal_name").text(name);

    $("#confirmModal").modal("show");
}

$(function () {
    let name = "";
    // delete user
    $(document).on("click", ".delete-record", function (e) {
        e.preventDefault();
        const data_url = $(this).data("url");
        let data_method = "get";
        if ($(this)?.data("method")?.length) {
            data_method = $(this).data("method");
        }
        name = $(this).attr("data-name");
        const type = $(this).attr("data-type");
        const postData = $(this).attr("data-post-data");
        openConfirmModal(type, name, data_url, data_method, postData);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", "#confirm-modal-yes", function () {
        $(this).addClass("disabled");

        $.ajax({
            type: $(this).data("method"),
            url: $(this).data("url"),
            data: $(this).attr("data-post-data")
                ? JSON.parse($(this).attr("data-post-data"))
                : [],
            beforeSend: function () {
                $("#loader").removeClass("d-none");
            },
            complete: function () {
                $("#loader").addClass("d-none");
            },
            success: function (response) {
                let message = "Operation successful";
                if (response?.message) {
                    message = response.message;
                }
                displayNotification("success", message);
                $("#confirmModal").modal("hide");

                let event = "dataDeleted";
                if (response?.event) {
                    event = response?.event;
                }
                $("#confirmModal").on("hidden.bs.modal", function () {
                    $(this).trigger(event, name);
                });
            },
            error: function (response) {
                const errors = response?.responseJSON?.errors;

                if (errors) {
                    $.each(errors, function (key, value) {
                        $.each(value, function (index, message) {
                            displayNotification("error", message);
                            // Example: Append to an error list
                            $("#error-container").append(
                                "<li>" + message + "</li>"
                            );
                        });
                    });
                } else {
                    displayNotification(
                        "error",
                        response?.responseJSON?.message ??
                            "Something went wrong!"
                    );
                }

                $("#confirmModal").modal("hide");
            },
        });
    });
    $(document).on("click", '[data-bs-dismiss="modal"]', function () {
        $("#confirmModal").modal("hide");
        $(".modal").trigger("dismissModal", name);
    });

    function displayNotification(type, message) {
        toastr.remove();
        toastr[type](message);
    }
});
