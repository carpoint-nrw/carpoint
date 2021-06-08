import Datatable from '../entries/Datatable.js';

$(() => {
  const store = {
	buyerId: '',
  };

  let $datatableBuyer = $('#datatable-buyer').DataTable({
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
		d.buyerId = store.buyerId;
	  }
	},
	columns: [
	  {
		'name': 'edit',
		'data': 'buyerId',
	  },
	  {
		'name': 'delete',
		'data': 'buyerId',
	  },
	  {
		'name': 'firmNumber',
		'data': 'firmNumber'
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
	],
	"createdRow": (row, aData) => {
	  $(row).find('td:eq(0)')
		.text('')
		.append(`
            <a href="${editRoute +`/`+ aData['buyerId']}">
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

  $('#datatable-buyer tbody').on( 'click', 'a.open-modal-for-delete', function() {
	let $data = $datatableBuyer.row($(this).closest('tr')).data();
	store.buyerId = $data.buyerId;

	$('.custom-modal-body').empty().append(`
      <p><strong>${firstName}:</strong> ${$data.firstName}</p>
      <p><strong>${lastName}:</strong> ${$data.lastName}</p>
      <p><strong>${firma}:</strong> ${$data.firmNumber}</p>
    `);
  });

  $('#button-delete-item').click(() => {
	$datatableBuyer.ajax.url(deleteRoute).load();
  });
});