import Datatable from '../Datatable.js';

$(() => {
  const store = {
    filters: {},
    columnSort: null,
    sortType: null,
  };

  $('#datatable-homepage thead tr:nth-child(2) th').each( function () {
    let $id = $(this).attr('data-identifier');
    if (typeof $id !== 'undefined') {
      $(this).html(`
        <div class="dropdown">
            <div class="dropdown-toggle homepage-filters" id="${$id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="dropdown-menu ${$id}" aria-labelledby="${$id}">
            </div>
        </div>
      `);
    } else {
      $(this).html(``);
    }
  });

  let $datatableHomepage = $('#datatable-homepage').DataTable({
    language: new Datatable().translateFrontSiteValues(),
    processing: true,
    serverSide: true,
    pageLength: 50,
    ordering: false,
    scrollY: window.innerHeight - 300 + 'px',
    columnDefs: getColumnsDef(),
    ajax: {
      url: ajaxData,
      type: 'POST',
      data: (d) => {
        d.filters = store.filters;
        d.columnSort = store.columnSort;
        d.sortType = store.sortType;
      }
    },
    columns: getColumns(),
    "createdRow": (row, aData) => {
      if (accessFrontendSite) {
        $(row).find('td:eq(0)')
          .text('')
          .append(`
            <a class="add-to-order" data-car-id="${aData.carId}">
                <i class="fas fa-shopping-cart"></i>
            </a>`
          );

        $(row).find(`td:eq(9)`)
          .text('')
          .append(`
            <a class="open-modal-for-detail" href="#" data-target="#modal-for-detail-item" data-toggle="modal">
                Details
            </a>`
          );

        let $pricePln = $(row).find(`td:eq(7)`);
        if ($pricePln.text() === 'not_authorization') {
          $pricePln.text('').append(`<a href="${login}">Login</a>`);
        }
        let $priceEur = $(row).find(`td:eq(8)`);
        if ($priceEur.text() === 'not_authorization') {
          $priceEur.text('').append(`<a href="${login}"">Login</a>`);
        }
      } else {
        $(row).find(`td:eq(8)`)
          .text('')
          .append(`
            <a class="open-modal-for-detail" href="#" data-target="#modal-for-detail-item" data-toggle="modal">
                Details
            </a>`
          );

        let $pricePln = $(row).find(`td:eq(6)`);
        if ($pricePln.text() === 'not_authorization') {
          $pricePln.text('').append(`<a href="${login}">Login</a>`);
        }
        let $priceEur = $(row).find(`td:eq(7)`);
        if ($priceEur.text() === 'not_authorization') {
          $priceEur.text('').append(`<a href="${login}"">Login</a>`);
        }
      }
    },
  });

  function getColumns() {
    let $result = [];
    if (accessFrontendSite) {
      $result = [
        {
          'name': 'basket',
          'data': 'carId'
        },
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
          'name': 'preiseEur',
          'data': 'preiseEur'
        },
        {
          'name': 'detail',
          'data': 'carId'
        },
      ];
    } else {
      $result = [
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
          'name': 'preiseEur',
          'data': 'preiseEur'
        },
        {
          'name': 'detail',
          'data': 'carId'
        },
      ];
    }

    return $result;
  }

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

    if ($data.km !== '') {
      $('.car-body').append(`<h4><p><strong>Laufleistung:</strong> ${$data.km}</p></h4>`);
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

  $($datatableHomepage.table().container()).on( 'click', 'thead .homepage-filters', function (e) {
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
      url: filtersAjaxData,
      data: {
        'filter': $id,
        'filters': store.filters,
        'searchValue': $datatableHomepage.search()
      },
    })
      .done((data) => {
        if (data.length !== 0) {
          $elem.empty();

          data.forEach($value => {
            let $addedClass = '';
            if ($.inArray($value, store.filters[$id]) !== -1) {
              $addedClass = 'filter-added';
            }
            $elem.append(`
				<div>
					<div class="filter-field ${$addedClass}" data-value="${$value}" data-id="${$id}">${$value}</div>
				</div>
			  `);
          });
        } else {
          $elem.append(`
			<div class="filter-empty">Empty</div>
		  `);
        }
      })
      .fail(() => {
        console.log('fail');
      });
  });

  $($datatableHomepage.table().container()).on( 'click', 'thead .dropdown-menu .filter-field', function (e) {
    let $id = $(this).attr('data-id');
    let $value = $(this).attr('data-value');

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

      let $dropDownMenu = $(this).parent().parent().parent().find('.homepage-filters');
      if (!$($dropDownMenu[0]).hasClass('filter-dropdown-menu')) {
        $($dropDownMenu[0]).addClass('filter-dropdown-menu');
      }
    }
    $datatableHomepage.ajax.url(ajaxData).load();
    e.stopPropagation();
    e.preventDefault();
  });

  $('#datatable-homepage tbody').on( 'click', 'a.add-to-order', function() {
    let $data = $datatableHomepage.row($(this).closest('tr')).data();

    $.ajax({
      method: 'GET',
      url: addToOrder + '/' + $data.carId,
    })
      .done((data) => {
        if (data.result !== false) {
          $('.menu-button .fa-shopping-cart').text(data.result);
        }
      })
      .fail(() => {
        console.log('fail');
      });
  });

  $('.dropdown-menu-elem').click(function() {
    $('.dropdown-menu-elem').removeClass('cars-sorting-selected');
    $(this).addClass('cars-sorting-selected');

    let $column = $(this).attr('data-column');
    let $sort = $(this).attr('data-sort');

    store.columnSort = $column;
    store.sortType = $sort;

    $datatableHomepage.ajax.url(ajaxData).load();
  });

  function getColumnsDef() {
    if (accessFrontendSite) {
      return [
        {targets: [0], "className": "text-center"},
        {targets: [9], "className": "text-center"}
      ];
    } else {
      return [
        {targets: [8], "className": "text-center"}
      ];
    }
  }
});