$(function () {
  const dt = $("#myTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "/user/manual-assessments",
    columns: [
      {
        data: "assessment_name",
        name: "assessment_name",
        orderable: false,
      },
      {
        data: "user_details",
        name: "user_details",
        orderable: false,
      },
      {
        data: "qualifying_percent",
        name: "qualifying_percent",
        orderable: false,
      },
      {
        data: "created_at",
        name: "created_at",
        orderable: false,
      },
      {
        data: "due_date",
        name: "due_date",
        orderable: false,
      },
      {
        data: "score",
        name: "score",
        orderable: false,
      },
      {
        data: "status",
        name: "status",
        orderable: false,
      },
      {
        data: "actions",
        render: function (data, type, row, meta) {
          return `<div class="actions d-flex">
                                    <a class="btn btn-info mr-2" href="/user/manual-assessments/${row.id
            }/edit"><i class="icon-pencil"></i></a>
                                    <a class="btn btn-danger delete-record mr-2" href="#" data-url="/user/manual-assessments/${row.id
            }" data-name="${row.assessment_name
            } manual assessment"
                                data-type="delete" data-method="delete"><i class="fa fa-trash"></i></a>
                                ${row.status == "Test Not Taken"
              ? `<a class="btn btn-info mr-2 loadModal" href="/user/send-reminder/${row.id}">Send Reminder</a>
                                </div>`
              : ""
            }
                                `;
        },
      },
    ],
    paginate: true,
    sort: true,
    language: {
      emptyTable: "No Data Is Available.",
      search: "",
      //    paginate: {
      //     previous: '<i class="fa fa-angle-left"></i>',
      //     next: '<i class="fa fa-angle-right"></i>'
      // },
    },
    order: [[0, "desc"]],
    dom: "<'table-controls'lf>" +
      "<'table-responsive't>" +
      "<'d-flex justify-content-between align-items-center mt-3'ip><'actions'>",
    initComplete: function () {
      let $searchInput = $('#myTable_filter input[type="search"]');
      $searchInput
        .addClass('custom-search')
        .wrap('<div class="search-wrapper position-relative d-inline-block"></div>')
        .after('<i class="fa fa-search search-icon"></i>');

      $('#myTable_length select').addClass('form-select form-select-sm custom-entries');
    },
    //     drawCallback: function () {
    //     $('.dataTables_paginate .paginate_button.previous, .dataTables_paginate .paginate_button.next').css({
    //         'border-radius': '20px',
    //         'padding': '6px 15px',
    //         'font-weight': '500',

    //         'color': 'white',
    //         'border': 'none',
    //         'margin': '0 5px'
    //     });
    //     $('.dataTables_paginate .paginate_button').not('.previous, .next').css({
    //         'background-color': '#f0f0f0',
    //         'color': '#333',
    //         'border': '1px solid #ccc',
    //         'border-radius': '7px',
    //         'padding': '6px 12px',
    //         'margin': '0 4px',
    //         'font-weight': '500'
    //     });

    //     // Style current/active page
    //     $('.dataTables_paginate .paginate_button.current').css({
    //         'background-color': '#0d6efd',
    //         'color': 'white',
    //         'border': 'none',
    //         'font-weight': 'bold'
    //     });
    // },
  });

  // <a class="btn btn-info loadModal" href="/user/learning-pathways/manage-users/${row.id}">Manage Users</i></a>
  $(document).on(
    "manual_assessment_deleted",
    ".modal",
    function (event, params) {
      dt.draw();
    }
  );

  $("#send-reminder-all-users").click(function (e) {
    e.preventDefault();
    $.ajax({
      type: "get",
      url: "/user/send-reminder-all-users",
      success: function (response) {
        toastr.success("Reminders sent successfully");
      },
      error: function (response) {
        toastr.error("Reminders could not be sent. Please try later.");
      },
    });
  });
});

