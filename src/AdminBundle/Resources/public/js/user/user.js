import Datatable from '../entries/Datatable.js';

$(() => {
  const store = {
    userId: '',
  };

  let $datatableUser = $('#datatable-user').DataTable({
    language: new Datatable().translateDefaultValues(),
    processing: true,
    serverSide: true,
    searchDelay: 300,
    columnDefs: [
      { width: "50px", targets: 0, orderable: false, className: "text-center" },
      { width: "50px", targets: 1, orderable: false, className: "text-center" },
    ],
    ajax: {
      url: ajaxData,
      type: 'GET',
      data: (d) => {
        d.userId = store.userId;
      }
    },
    columns: [
      {
        'name': 'edit',
        'data': 'userId',
      },
      {
        'name': 'delete',
        'data': 'userId',
      },
      {
        'name': 'firstName',
        'data': 'firstName'
      },
      {
        'name': 'lastName',
        'data': 'lastName'
      },
      {
        'name': 'email',
        'data': 'email'
      },
      {
        'name': 'phoneNumber',
        'data': 'phoneNumber'
      },
      {
        'name': 'role',
        'data': 'role'
      },
    ],
    "createdRow": (row, aData) => {
      $(row).find('td:eq(0)')
        .text('')
        .append(`
            <a href="${editRoute +`/`+ aData['userId']}">
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

  $('#datatable-user tbody').on( 'click', 'a.open-modal-for-delete', function() {
    let $data = $datatableUser.row($(this).closest('tr')).data();
    store.userId = $data.userId;

    $('.custom-modal-body').empty().append(`
      <p><strong>${firstName}:</strong> ${$data.firstName}</p>
      <p><strong>${lastName}:</strong> ${$data.lastName}</p>
      <p><strong>${email}:</strong> ${$data.email}</p>
    `);
  });

  $('#button-delete-item').click(() => {
    $datatableUser.ajax.url(deleteUser).load();
  });
});