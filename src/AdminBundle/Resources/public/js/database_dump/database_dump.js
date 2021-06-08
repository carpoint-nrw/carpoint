import Datatable from '../entries/Datatable.js';

$(() => {
  const store = {
	dumpId: '',
  };

  let $datatableDump = $('#datatable-dump').DataTable({
	language: new Datatable().translateDefaultValues(),
	processing: true,
	serverSide: true,
	searching: false,
	order: [[ 0, 'desc' ]],
	columnDefs: [
	  {targets: 1, orderable: false, className: "text-center" },
	],
	ajax: {
	  url: ajaxData,
	  type: 'GET',
	  data: (d) => {
		d.dumpId = store.dumpId;
	  }
	},
	columns: [
	  {
		'name': 'date',
		'data': 'date',
	  },
	  {
		'name': 'restore',
		'data': 'dumpId',
	  }
	],
	createdRow: (row, aData) => {
	  $(row).find('td:eq(1)')
		.text('')
		.append(`
            <a class="open-modal-for-restore"  data-target="#modal-for-restore" data-toggle="modal">
                <i class="fas fa-window-restore fa-2x pages-edit-icon restore-icon"></i>
            </a>`
		);
	},
  });

  $('#datatable-dump tbody').on( 'click', 'a.open-modal-for-restore', function() {
	let $data = $datatableDump.row($(this).closest('tr')).data();
	store.dumpId = $data.dumpId;
  });

  $('#button-restore').click(() => {
    location.href = `${restore}/${store.dumpId}`;
  });
});