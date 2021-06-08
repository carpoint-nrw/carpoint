import Datatable from "../entries/Datatable.js";

$(() => {
  $('#datatable-car-edit-history').DataTable({
	language: new Datatable().translateDefaultValues(),
	processing: true,
	serverSide: true,
	searchDelay: 300,
    pageLength: 25,
	scrollX: true,
	order: [[ 0, 'desc' ]],
	ajax: {
	  url: ajaxData,
	  type: 'GET',
	},
	columns: [
	  {
		'name': 'editDate',
		'data': 'editDate'
	  },
	  {
		'name': 'admin',
		'data': 'admin'
	  },
	  {
		'name': 'vinNumber',
		'data': 'vinNumber'
	  },
	  {
		'name': 'column',
		'data': 'column'
	  },
	  {
		'name': 'oldValue',
		'data': 'oldValue'
	  },
	  {
		'name': 'newValue',
		'data': 'newValue'
	  },
	],
  });
});