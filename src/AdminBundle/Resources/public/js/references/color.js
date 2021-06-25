import Datatable from '../entries/Datatable.js';

$(() => {
  const store = {
    entityId: '',
  };

  let $datatable = $('#datatable-preference').DataTable({
    language: new Datatable().translateDefaultValues(),
    processing: true,
    serverSide: true,
    searchDelay: 300,
    pageLength: 25,
    columnDefs: [
      { width: "50px", targets: 0, orderable: false, className: "text-center" },
      { width: "50px", targets: 1, orderable: false, className: "text-center" },
    ],
    ajax: {
      url: ajaxData,
      type: 'GET',
      data: (d) => {
        d.entityId = store.entityId;
      }
    },
    columns: columns(),
    "createdRow": (row, aData) => {
      $(row).find('td:eq(0)')
          .text('')
          .append(`
            <a href="${editRoute +`/`+ aData['entityId']}">
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

  $('#datatable-preference tbody').on( 'click', 'a.open-modal-for-delete', function() {
    let $data = $datatable.row($(this).closest('tr')).data();
    store.entityId = $data.entityId;

    $('.custom-modal-body').empty().append(`
      <p><strong>${entity}:</strong> ${$data.title}</p>
    `);
  });

  $('#button-delete-item').click(() => {
    $datatable.ajax.url(deleteRoute).load();
  });
  
  function columns() {
    let $result = [
      {
        'name': 'edit',
        'data': 'entityId',
      },
      {
        'name': 'delete',
        'data': 'entityId',
      },
    ];

    switch(type) {
      case 'model':
        $result.push({'name': 'brand', 'data': 'brand'});
        $result.push({'name': 'title', 'data': 'title'});
        break;
      case 'vendor':
        $result.push({'name': 'place', 'data': 'place'});
        $result.push({'name': 'title', 'data': 'title'});
        break;
      case 'color':
        $result.push({'name': 'polish', 'data': 'polish'});
        $result.push({'name': 'german', 'data': 'german'});
        $result.push({'name': 'baseColor', 'data': 'baseColor'});

        break;
      case 'basecolor':
        $result.push({'name': 'polish', 'data': 'polish'});
        $result.push({'name': 'german', 'data': 'german'});
        break;
      case 'version':
        $result.push({'name': 'brand', 'data': 'brand'});
        $result.push({'name': 'model', 'data': 'model'});
        $result.push({'name': 'polish', 'data': 'polish'});
        $result.push({'name': 'german', 'data': 'german'});
        $result.push({'name': 'isVisible', 'data': 'isVisible'});
        $result.push({'name': 'sort', 'data': 'sort'});
        break;
      case 'standartComplectation':
        $result.push({'name': 'brand', 'data': 'brand'});
        $result.push({'name': 'model', 'data': 'model'});
        $result.push({'name': 'version', 'data': 'version'});
        $result.push({'name': 'german', 'data': 'german'});
        $result.push({'name': 'polish', 'data': 'polish'});
        break;
      case 'description':
        $result.push({'name': 'title', 'data': 'title'});
        $result.push({'name': 'description', 'data': 'description'});
        break;
      case 'phoneNumber':
        $result.push({'name': 'title', 'data': 'title'});
        $result.push({'name': 'phoneNumber', 'data': 'phoneNumber'});
        break;
      default:
        $result.push({'name': 'title', 'data': 'title'});
        break;
    }
    return $result;
  }
});