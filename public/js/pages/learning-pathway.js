$(function () {
    const dt = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: '/user/learning-pathways',
        columns: [
            {
                data: "title",
                name: 'title'
            },
            {
                data: "courses",
                name: 'courses'
            },
            {
                data: "description",
                name: 'description'
            },
            {
                data: "in_sequence",
                name: 'in_sequence'
            },
            {
                data: "actions",
                render: function (data, type, row, meta) {
                    return `<div class="actions d-flex">
                                <a class="btn btn-info mr-2" href="/user/learning-pathways/${row.id}/edit"><i class="fa fa-edit"></i></a>
                                <!--a class="btn btn-danger delete-record mr-2" href="#" data-url="/user/learning-pathways/${row.id}" data-name="${row.title} learning pathway"
                                    data-type="delete" data-method="delete"><i class="fa fa-trash"></i></a-->
                            </div>`;
                },
            },
        ],
        dom: "<'table-controls'lf>" +
                     "<'table-responsive't>" +
                     "<'d-flex justify-content-between align-items-center mt-3 pagination-responsive'ip><'actions'>",
        initComplete: function () {
                   let $searchInput = $('#myTable_filter input[type="search"]');
    $searchInput
        .addClass('custom-search')
        .wrap('<div class="search-wrapper position-relative d-inline-block"></div>')
        .after('<i class="fa fa-search search-icon"></i>');

    $('#myTable_length select').addClass('form-select form-select-sm custom-entries');
                },
                   
language:{
    search:""
}
        
    });

    // <a class="btn btn-info loadModal" href="/user/learning-pathways/manage-users/${row.id}">Manage Users</i></a>   
    $(document).on("pathway_deleted", ".modal", function (event, params) {
        dt.draw();
    });
});