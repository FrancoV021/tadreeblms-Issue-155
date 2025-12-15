$(function () {

  $('#reset').click(function (){
                //initializeDates();
        $('#user').val(null).trigger('change');
        
        $('#course_id').val(null).trigger('change');
        
        $('#advace_filter').submit();
        
    })

  $('#advace_filter').submit(function (e) {
      e.preventDefault();
      //$('#advance-search-btn').prop('disabled', true);
      loadDataTable(); // 👉 filter submission
  });

  $(document).ready(function () {
      loadDataTable(); 
  });

  function loadDataTable() {

    let user_id = $('#user').val();
    let course_id = $('#course_id').val() || null;

    if ($.fn.DataTable.isDataTable('#myTable')) {
        dt.clear().destroy();
        $('#myTable tbody').empty();
    }

    dt = $("#myTable").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    //ajax: "/user/pathway-assignments",
    ajax: {
        url: "/user/pathway-assignments",
        type: "GET",
        data: function (d) {
            d.user_id = user_id;
            d.course_id = course_id;
            // d.dept_id = dept_id;
            // d.from = $('#assign_from_date').val();
            // d.to = $('#assign_to_date').val();
            // d.due_date = $('#due_date').val();
        }
    },
    columns: [
      {
        data: "pathway_title",
        name: "pathway_title",
        orderable: false,
      },
      // {
      //   data: "pathway_name",
      //   name: "pathway_name",
      //   orderable: false,
      // },
      {
        data: "course_name",
        name: "course_name",
        orderable: false,
      },
      {
        data: "assign_by",
        name: "assign_by",
        orderable: false,
      },
      {
        data: "assigned_user_names",
        name: "assigned_user_names",
        orderable: false,
      },
      {
        data: "user_email",
        name: "user_email",
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
      // {
      //   data: "actions",
      //   render: function (data, type, row, meta) {
      //     return `<div class="actions d-flex">
      //                               <a class="btn btn-info mr-2" href="/user/pathway-assignments/${row.id}/edit"><i class="icon-pencil"></i></a>
      //                               <a class="btn btn-danger delete-record mr-2" href="#" data-url="/user/pathway-assignments/${row.id}" data-name="${row.title} pathway assignment"
      //                           data-type="delete" data-method="delete"><i class="fa fa-trash"></i></a>
      //                           </div>`;
      //   },
      // },
    ],
    paginate: true,
    sort: true,
    language: {
      emptyTable: "No Data Is Available.",
      search:"",
    
    },
    order: [[0, "desc"]],
    dom:  "<'table-controls'lf>" +
                     "<'table-responsive't>" +
                     "<'d-flex justify-content-between align-items-center mt-3 pagination-responsive'ip><'actions'>",
    buttons: [],
     initComplete: function () {
                   let $searchInput = $('#myTable_filter input[type="search"]');
    $searchInput
        .addClass('custom-search')
        .wrap('<div class="search-wrapper position-relative d-inline-block"></div>')
        .after('<i class="fa fa-search search-icon"></i>');

    $('#myTable_length select').addClass('form-select form-select-sm custom-entries');
                },
                  
  });

    dt.on('draw', function () {
        $('#advance-search-btn').prop('disabled', false);
    });
  }
  

  // <a class="btn btn-info loadModal" href="/user/learning-pathways/manage-users/${row.id}">Manage Users</i></a>
  $(document).on(
    "pathway_assignment_deleted",
    ".modal",
    function (event, params) {
      dt.draw();
    }
  );
});
