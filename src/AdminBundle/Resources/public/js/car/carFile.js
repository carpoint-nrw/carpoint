import Datatable from '../entries/Datatable.js';

$(() => {
    const store = {
        fileId: '',
    };

    let $datatableFile = $('#datatable-car-file').DataTable({
        language: new Datatable().translateDefaultValues(),
        processing: true,
        serverSide: true,
        searching: false,
        bLengthChange: false,
        paging: false,
        info: false,
        pageLength: 25,
        scrollY: 220 + 'px',
        columnDefs: [
            { width: "50px", targets: 4, orderable: false, className: "text-center" },
            { width: "50px", targets: 5, orderable: false, className: "text-center" },
        ],
        ajax: {
            url: fileAjaxData,
            type: 'GET',
            data: (d) => {
                d.fileId = store.fileId;
                d.carId = fileCarId;
            }
        },
        columns: [
            {
                'name': 'type',
                'data': 'type',
            },
            {
                'name': 'fileName',
                'data': 'fileName',
            },
            {
                'name': 'admin',
                'data': 'admin',
            },
            {
                'name': 'createdAt',
                'data': 'createdAt',
            },
            {
                'name': 'download',
                'data': 'fileId',
            },
            {
                'name': 'delete',
                'data': 'fileId',
            }
        ],
        createdRow: (row, aData) => {
            $(row).find('td:eq(4)')
                .text('')
                .append(`
                    <a href="${carFilesRelativePath}/${aData.carId}/${aData.fileName}" download>
                        <i class="fas fa-file-download pages-edit-icon"></i>
                    </a>`
                );
            $(row).find('td:eq(5)')
                .text('')
                .append(`
                    <a class="open-modal-for-delete" href="#" data-target="#modal-for-delete-item" data-toggle="modal">
                        <i class="fas fa-trash-alt fa-2x pages-delete-icon"></i>
                    </a>`
                );
        }
    });

    $('#datatable-car-file tbody').on( 'click', 'a.open-modal-for-delete', function() {
        let $data = $datatableFile.row($(this).closest('tr')).data();
        store.fileId = $data.fileId;
    });

    $('#button-delete-item').click(() => {
        $datatableFile.ajax.url(fileDeleteRoute).load();
    });

    $.ajax({
        method: 'GET',
        url: getCarFileTypes,
    })
        .done($data => {
            $.each($data, ($index, $value) => {
                let $option = new Option($value, $index, false, false);
                $('#fileType').append($option);
            });
        })
        .fail(() => {
            console.log('fail');
        });

    $('#carUploadFile').click(() => {
        $('#carFile').val('');
    });

    $('#button-upload-file').click(() => {
        let $input = $('#carFile');
        let $fd    = new FormData();
        $fd.append('file', $input[0].files[0]);
        $fd.append('type', $('#fileType').val());
        $fd.append('carId', fileCarId);

        $.ajax({
            method: 'POST',
            url: fileUploadRoute,
            data: $fd,
            processData: false,
            contentType: false,
        })
            .done(() => {
                $datatableFile.ajax.reload();
            })
            .fail(() => {
                console.log('fail');
            });
    });

    $('#carSale').on('shown.bs.collapse', function () {
        $('.sidebar').css('height', getSidebarHeight() + 'px');
    });

    $('#carline').on('shown.bs.collapse', function () {
        $('.sidebar').css('height', getSidebarHeight() + 'px');
        $datatableFile.ajax.reload();
    });

    function getSidebarHeight() {
        let $bodyHeight = $('body').innerHeight();
        let $browserHeight = window.innerHeight;
        return $bodyHeight < $browserHeight ? $browserHeight : $bodyHeight;
    }
});