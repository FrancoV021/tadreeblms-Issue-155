$(function () {
    const dt = $('#learning-pathways-table').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: '/user/learning-pathways',
        columns: [
            {
                data: "pathway_name",
                name: 'pathway_name'
            },
            {
                data: "users_assigned",
                name: 'users_assigned'
            },
            {
                data: "actions",
                render: function (data, type, row, meta) {
                    return `<div class="actions d-flex">
                                <a class="btn btn-info mr-2" href="/user/assign-learning-pathways/${row.id}/edit"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger delete-record" href="#" data-url="/user/assign-learning-pathways/${row.id}" data-name="${row.title} learning pathway"
                                    data-type="delete" data-method="delete"><i class="fa fa-trash"></i></a>
                            </div>`;
                },
            },
        ],
    });

    $(document).on("assign_pathway_deleted", ".modal", function (event, params) {
        dt.draw();
    });
});