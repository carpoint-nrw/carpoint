import Datatable from '../Datatable.js';

$(() => {
  let $datatableHomepage = $('#datatable-homepage').DataTable({
	language: new Datatable().translateFrontSiteValues(),
	processing: true,
	serverSide: true,
	pageLength: 50,
	ordering: false,
	searching: false,
	scrollY: window.innerHeight - 263 + 'px',
	columnDefs: accessFrontendSite
	  ? [{targets: [7], "className": "text-center"}]
	  : [],
	ajax: {
	  url: ajaxData,
	  type: 'GET',
	},
	columns: [
	  {
		'name': 'brand',
		'data': 'brand',
	  },
	  {
		'name': 'model',
		'data': 'model'
	  },
	  {
		'name': 'versionGerman',
		'data': 'versionGerman'
	  },
	  {
		'name': 'colorGerman',
		'data': 'colorGerman'
	  },
	  {
		'name': 'vinNumber',
		'data': 'vinNumber'
	  },
	  {
		'name': 'date',
		'data': 'date'
	  },
	  {
		'name': 'preisePln',
		'data': 'preisePln'
	  },
	  {
		'name': 'detail',
		'data': 'carId'
	  },
	],
	"createdRow": (row, aData) => {
	  $(row).find(`td:eq(7)`)
		.text('')
		.append(`
            <a class="open-modal-for-detail" href="#" data-target="#modal-for-detail-item" data-toggle="modal">
                Details
            </a>`
		);
	},
  });

  $('#datatable-homepage tbody').on( 'click', 'a.open-modal-for-detail', function() {
	let $data = $datatableHomepage.row($(this).closest('tr')).data();

	$('.car-body').empty().append(`
      <h4><p><strong>Marke:</strong> ${$data.brand}</p></h4>
      <h4><p><strong>Modell:</strong> ${$data.model}</p></h4>
      <h4><p><strong>Ausführung:</strong> ${$data.versionGerman}</p></h4>
      <h4><p><strong>Farbe:</strong> ${$data.colorGerman}</p></h4>
      <h4><p><strong>Fahrgestellnummer:</strong> ${$data.vinNumber}</p></h4>
      <h4><p><strong>Liefertermin:</strong> ${$data.date}</p></h4>
    `);

	if ($data.ez !== '') {
	  $('.car-body').append(
		`
          <h4><p><strong>EZ:</strong> ${$data.ez}</p></h4>
        `
	  );
	}

	if (userAuthorized) {
	  $('.car-body').append(
		`
          <h4><p><strong>Preis PLN:</strong> ${$data.preisePln}</p></h4>
          <h4><p><strong>Preis €:</strong> ${$data.preiseEur}</p></h4>
        `
	  );
	} else {
	  $('.car-body').append(
		`
          <h4><p><strong>Preis PLN:</strong> <a href="${loginPath}">Login</a></p></h4>
          <h4><p><strong>Preis €:</strong> <a href="${loginPath}">Login</a></p></h4>
        `
	  );
	}

	$('.car-complectation').empty().append(
	  `
        <h4><p><strong>Serienausstattung:</strong> ${$data.complectationStandart}</p></h4>
        <h4><p><strong>Sonderausstattung:</strong> ${$data.complectationOther}</p></h4>
      `
	);

	$('.car-photo').empty().append(`
      <img class="car-photo-body" src="${modelRelativePath}/${$data.modelImageName}" alt="">
    `);
  });
});