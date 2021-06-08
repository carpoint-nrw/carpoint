import Datatable from '../entries/Datatable.js';

$(() => {
    const store = {
        typeId: '',
    };

    let $datatableFileType = $('#datatable-car-file-type').DataTable({
        language: new Datatable().translateDefaultValues(),
        processing: true,
        serverSide: true,
        searching: false,
        pageLength: 25,
        columnDefs: [
            { width: "50px", targets: 0, orderable: false, className: "text-center" },
            { width: "50px", targets: 1, orderable: false, className: "text-center" },
        ],
        ajax: {
            url: ajaxData,
            type: 'GET',
            data: (d) => {
                d.typeId = store.typeId;
            }
        },
        columns: [
            {
                'name': 'edit',
                'data': 'typeId',
            },
            {
                'name': 'delete',
                'data': 'typeId',
            },
            {
                'name': 'type',
                'data': 'type',
            }
        ],
        createdRow: (row, aData) => {
            $(row).find('td:eq(0)')
                .text('')
                .append(`
                    <a href="${editRoute +`/`+ aData['typeId']}">
                        <i class="fas fa-pencil-alt fa-2x pages-edit-icon"></i>
                    </a>`
                );
            $(row).find('td:eq(1)')
                .text('')
                .append(`
                    <a class="open-modal-for-delete" href="#" data-target="#modal-for-delete-item" data-toggle="modal">
                        <i class="fas fa-trash-alt fa-2x pages-delete-icon"></i>
                    </a>`
                );
        },
    });

    $('#datatable-car-file-type tbody').on( 'click', 'a.open-modal-for-delete', function() {
        let $data = $datatableFileType.row($(this).closest('tr')).data();
        store.typeId = $data.typeId;
    });

    $('#button-delete-item').click(() => {
        $datatableFileType.ajax.url(deleteRoute).load();
    });
});