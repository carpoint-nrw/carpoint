import CarTable from '../entries/car/CarTable.js';

$(() => {
  const store = {
	carId: '',
	selectedRowIndex: null,
	showAndHideColumn: true,
	changeValue: '',
	changeField: '',
	addedType: null,
	filters: {},
	columnSearch: {},
  };

  $('#datatable-car thead tr:first-child th').each( function () {
	let $id = $(this).attr('data-identifier');
	if (typeof $id !== 'undefined') {
	  if ($id === 'vinNumber') {
		$(this).html(`
		   <input class="car-table-vinNumber-search" data-id="${$id}">
	    `);
	  } else if ($id === 'discharge') {
		$(this).html(`
		   <input class="car-table-discharge-search" data-id="${$id}">
	    `);
	  } else {
		$(this).html(`
		   <div class="dropdown">
			<div class="dropdown-toggle cartable-filters" id="${$id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			 <i class="fas fa-chevron-down"></i>
			</div>
			<div class="dropdown-menu ${$id}" aria-labelledby="${$id}">
			</div>
		  </div>
	    `);
	  }
	} else {
	  $(this).html(``);
	}
  });

  let $carTable = new CarTable();
  let $datatableCar = $carTable.initCarTable(store, 'archive');
  $('div.dataTables_filter input').unbind().on('keyup', function(e) {
	if(e.which === 13) {
	  $datatableCar.search(this.value).draw();
	}
  });

  let delay = (function() {
	let timer = 0;
	return function(callback, ms){
	  clearTimeout (timer);
	  timer = setTimeout(callback, ms);
	};
  })();

  $($datatableCar.table().container()).on( 'keyup change clear', 'thead .car-table-vinNumber-search', function (e) {
	let $self = $(this);
	delay(function() {
	  let $id = $self.attr('data-id');
	  if (store.columnSearch[$id] !== $self.val()) {
		store.columnSearch[$id] = $self.val();
		$datatableCar.ajax.url(ajaxData).load();
	  }
	}, 400);
  });

  $($datatableCar.table().container()).on( 'keyup change clear', 'thead .car-table-discharge-search', function (e) {
	let $self = $(this);
	delay(function() {
	  let $id = $self.attr('data-id');
	  if (store.columnSearch[$id] !== $self.val()) {
		store.columnSearch[$id] = $self.val();
		$datatableCar.ajax.url(ajaxData).load();
	  }
	}, 400);
  });

  $($datatableCar.table().container()).on( 'click', 'thead .cartable-filters', function (e) {
	let $self = $(this);
	let $id = $self.attr('id');
	let $elem = $self.parent().find('.' + $id);

	if (!$(this).parent().hasClass('open')) {
	  $.each($('.open'), (index, value) => {
		$(value).removeClass('open');
	  });
	  $(this).parent().toggleClass('open');
	  e.stopPropagation();
	  let $coordinates = $(this).offset();
	  $elem.offset({top: $coordinates.top + 30, left: $coordinates.left})
	}

	$.ajax({
	  method: 'POST',
	  url: getCarFilterData,
	  data: {
		'filter': $id,
		'filters': store.filters,
		'columnSearch': store.columnSearch,
		'searchValue': $datatableCar.search(),
		'carStatus': 'archive'
	  },
	})
	  .done((data) => {
		if (data.length !== 0) {
		  let $index = 0;
		  $elem.empty();

		  let $selectAllAddedClass = '';
		  if ($.inArray('selectAll', data) !== -1) {
			$selectAllAddedClass = 'filter-added';
			data = data.slice(0, -1);
		  } else {
			$selectAllAddedClass = '';
		  }

		  data.forEach($value => {
			let $outputValue = $value;
			if (($id === 'paymentDate' || $id === 'downloadDate') && $outputValue !== 'Empty') {
			  $outputValue = $value.slice(0, -5)
			} else if ($outputValue === 'Empty') {
			  $outputValue = userLocale === 'de' ? 'Leerfeld' : 'pusty';
			} else if ($outputValue === 'true') {
			  $outputValue = userLocale === 'de' ? 'Ausgeführt' : 'gotow';
			} else if ($outputValue === 'false') {
			  $outputValue = userLocale === 'de' ? 'Leerfeld' : 'pusty';
			} else if ($outputValue === 'Only blue') {
			  $outputValue = userLocale === 'de' ? 'Neu markiert' : 'nowo oznaczone';
			} else if ($id === 'discount') {
			  $outputValue = $outputValue.toFixed(1);
			}

			if ($value === 'Empty') {
			  let $emptyClass = $.inArray('Empty', store.filters[$id]) !== -1 ? 'filter-added' : '';
			  $elem.prepend(`
				<div>
					<div class="filter-field ${$emptyClass}" data-value="${$value}" data-id="${$id}">${$outputValue}</div>
				</div>
			  `);
			} else if ($value === 'Only blue') {
			  let $onlyBlueClass = $.inArray('Only blue', store.filters[$id]) !== -1 ? 'filter-added' : '';
			  $elem.prepend(`
				<div>
					<div class="filter-field ${$onlyBlueClass}" data-value="${$value}" data-id="${$id}">${$outputValue}</div>
				</div>
			  `);
			} else {
			  if ($value !== 'Only blue') {
				// Select selected value
				let $addedClass = '';
				let $chekedValue = $.inArray($id, ['paymentDate', 'downloadDate', 'paid', 'taxReturned', 'pay', 'paidSuccess'])
				  ? $value : $outputValue;
				if ($id === 'discount') {
				  $chekedValue = $chekedValue.toString();
				}
				if ($.inArray($chekedValue, store.filters[$id]) !== -1) {
				  $addedClass = 'filter-added';
				}
				// ---------------------
				$elem.append(`
				<div>
					<div class="filter-field ${$addedClass}" data-value="${$value}" data-id="${$id}">${$outputValue}</div>
				</div>
			  `);
			  }
			}
			$index++;
		  });

		  $elem.prepend(`
			<div>
				<div class="filter-field ${$selectAllAddedClass}" data-value="selectAll" data-id="${$id}">${userLocale === 'de' ? 'Alles' : 'Wszystko'}</div>
			</div>
		  `);
		} else {
		  $elem.append(`
			<div>Empty</div>
		  `);
		}
	  })
	  .fail(() => {
		console.log('fail');
	  });
  });

  $($datatableCar.table().container()).on( 'click', 'thead .dropdown-menu .filter-field', function (e) {
	let $id = $(this).attr('data-id');
	let $value = $(this).attr('data-value');
	let $input = $(this).find('input');

	if ($value === 'selectAll') {
	  if ($(this).hasClass('filter-added')) {
		store.filters[$id] = [];
		$(this).parent().parent().find('div>div').removeClass('filter-added')
		$(this).removeClass('filter-added');
		$(this).parent().parent().parent().find('.filter-dropdown-menu').removeClass('filter-dropdown-menu');
	  } else {
		store.filters[$id] = [];
		store.filters[$id].push('selectAll');
		let $filterValues = $(this).parent().parent().find('div>div');
		$.each($filterValues, (index, value) => {
		  if ($(value).attr('data-value') !== 'selectAll') {
			store.filters[$id].push($(value).attr('data-value'));
		  }
		  $(value).addClass('filter-added')
		});

		let $dropDownMenu = $(this).parent().parent().parent().find('.cartable-filters');
		if (!$($dropDownMenu[0]).hasClass('filter-dropdown-menu')) {
		  $($dropDownMenu[0]).addClass('filter-dropdown-menu');
		}
	  }
	} else {
	  if ($(this).hasClass('filter-added')) {
		if ($.inArray($value, store.filters[$id]) !== -1) {
		  store.filters[$id].splice($.inArray($value, store.filters[$id]), 1)
		}
		$(this).removeClass('filter-added');

		let $dropDownMenuElems = $(this).parent().parent();
		if ($dropDownMenuElems.find('.filter-added').length === 0) {
		  $($dropDownMenuElems.parent().find('.filter-dropdown-menu')[0]).removeClass('filter-dropdown-menu');
		}
	  } else {
		if (typeof store.filters[$id] === 'undefined') {
		  store.filters[$id] = [];
		}
		if ($.inArray($value, store.filters[$id]) === -1) {
		  store.filters[$id].push($value);
		}
		$(this).addClass('filter-added');

		let $dropDownMenu = $(this).parent().parent().parent().find('.cartable-filters');
		if (!$($dropDownMenu[0]).hasClass('filter-dropdown-menu')) {
		  $($dropDownMenu[0]).addClass('filter-dropdown-menu');
		}
	  }
	}
	$datatableCar.ajax.url(ajaxData).load();
	e.stopPropagation();
	e.preventDefault();
  });

  $('.car-show-hide-button').click(() => {
	  showAndHideColumns();
  });

  function showAndHideColumns() {
	store.showAndHideColumn = !store.showAndHideColumn;
	$datatableCar.columns($carTable.getShowAndHideColumns()).visible(store.showAndHideColumn, false);
	$datatableCar.columns.adjust().draw(false);

	let $text;
	if (store.showAndHideColumn) {
	  $text = userLocale === 'de' ? 'Ausblenden' : 'ukryc';
	} else {
	  $text = userLocale === 'de' ? 'Einblenden' : 'pokaz';
	}
	$('.car-show-hide-button').text($text);
  }
  showAndHideColumns();

  $('#datatable-car tbody').on( 'click', 'tr', function() {
	  let $index = $datatableCar.row(this).index();
	  store.selectedRowIndex = $index;
	  $('.car-table-select-row').removeClass('car-table-select-row');
	  $(`.car-table-row-${$index}`).addClass('car-table-select-row');
  });

  $('.car-edit-button').click(() => {
	if (store.selectedRowIndex !== null) {
	  let $dataId = $datatableCar.row(store.selectedRowIndex).data().id;
	  window.open(editRoute + '/' + $dataId, '_blank');
	}
  });

  $('#datatable-car tbody').on('dblclick', 'tr', function () {
	if (store.selectedRowIndex !== null) {
	  let $dataId = $datatableCar.row(store.selectedRowIndex).data().id;
	  window.open(editRoute + '/' + $dataId, '_blank');
	}
  });

  $datatableCar.on('mouseenter', 'td', function() {
	  $(this).attr('title', this.innerText);
  });

  // Change select inputs
  $datatableCar.on("change", "select.select-input-change", function() {
	let $data = $datatableCar.row($(this).closest('tr')).data();
	store.carId = $data.id;
	store.changeField = $(this).attr('data-select-type');
	store.changeValue = $(this).val();
	$datatableCar.ajax.url(changeSelectInput).load();
  });
  // --------------------

  // Change checkbox
  $('#datatable-car tbody').on( 'change', 'input.car-table-checkbox-edit', function() {
	let $data = $datatableCar.row($(this).closest('tr')).data();
	store.carId = $data.id;
	store.changeValue = $(this).is(':checked');
	store.changeField = $(this).attr('data-field');

	$datatableCar.ajax.url(changeCheckbox).load();
  });
  // ---------------

  // Field with edit inputs
  $('#datatable-car tbody').on( 'click', 'input.car-table-text-input-edit', function() {
	let $self = $(this);
	let $currentValue = $self.val();
	let $data = $datatableCar.row($(this).closest('tr')).data();
	$self.focusout(function() {
	  let $newValue = $self.val();
	  if ($currentValue !== $newValue) {
		store.carId = $data.id;
		store.changeValue = $newValue;
		store.changeField = $self.attr('data-field');

		$datatableCar.ajax.url(changeInputField).load();
	  }
	});
	$(document).off('keydown').keydown(e => {
	  if(e.which === 13) {
		$self.blur();
	  }
	});
  });
  // ----------------------

  $('.archive-only-german').click(() => {
    store.addedType = 'de';
	$datatableCar.ajax.url(ajaxData).load();
  });
  $('.archive-only-polish').click(() => {
	store.addedType = 'pl';
	$datatableCar.ajax.url(ajaxData).load();
  });
  $('.archive-only-all').click(() => {
	store.addedType = null;
	$datatableCar.ajax.url(ajaxData).load();
  });
  $('.return-from-archive').click(() => {
	if (store.selectedRowIndex !== null) {
	  let $dataId = $datatableCar.row(store.selectedRowIndex).data().id;
	  store.carId = $dataId;
	  $datatableCar.ajax.url(returnFromArchive).load();
	}
  });
});