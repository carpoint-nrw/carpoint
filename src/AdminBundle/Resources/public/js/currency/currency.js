import Datatable from '../entries/Datatable.js';

$(() => {
  $('#datatable-currency').DataTable({
	language: new Datatable().translateDefaultValues(),
	processing: true,
	serverSide: true,
	searching: false,
	pageLength: 25,
	columnDefs: [
	  { targets: 0, orderable: false, className: "text-center"},
	  { targets: 1, orderable: false},
	  { targets: 2, orderable: false},
	  { targets: 3, orderable: false},
	],
	ajax: {
	  url: ajaxData,
	  type: 'GET',
	},
	columns: [
	  {
		'name': 'edit',
		'data': 'currencyId',
	  },
	  {
		'name': 'realCurrency',
		'data': 'realCurrency'
	  },
	  {
		'name': 'ourCurrency',
		'data': 'ourCurrency'
	  },
	  {
		'name': 'date',
		'data': 'date'
	  },
	],
	"createdRow": (row, aData) => {
	  $(row).find('td:eq(0)')
		.text('')
		.append(`
            <a href="${editRoute +`/`+ aData['currencyId']}">
                <i class="fas fa-pencil-alt fa-2x pages-edit-icon"></i>
            </a>`
		);
	},
  });
});