$(() => {
  const store = {
    carId: '',
    showAndHideColumn: true,
    changeValue: '',
    changeField: '',
    filters: {},
    singleSelection: true,
    selectedAll: false,
  };

  $('#datatable-car thead tr:first-child th').each( function () {
    let $id = $(this).attr('data-identifier');
    if (typeof $id !== 'undefined') {
      $(this).html(`
		   <div class="dropdown">
			<div class="dropdown-toggle cartable-filters" id="${$id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

  let $datatableCar = $('#datatable-car').DataTable({
    language: {
      search:      userLocale === 'de' ? 'Suche' : 'Szukaj',
      processing:  userLocale === 'de' ? 'Wird bearbeitet' : 'Przetwarzanie',
      sLengthMenu: userLocale === 'de' ? 'Einträge _MENU_ anzeigen' : 'Pokaż _MENU_ wpisy',
      info:        userLocale === 'de' ? 'Zeige _START_ bis _END_ von _TOTAL_ Einträgen' : 'Pokazuje _START_ do _END_ z _TOTAL_ wpisów',
      paginate: {
        previous:  userLocale === 'de' ? 'Bisherige' : 'Poprzedni',
        next:      userLocale === 'de' ? 'Nächster' : 'Kolejny'
      }
    },
    processing: true,
    serverSide: true,
    pageLength: 100,
    scrollX: true,
    dom: 'fiptr',
    scrollY: window.innerHeight - 233 + 'px',
    columnDefs: [
      {targets: [0], visible: false, searchable: false},
      {targets: [9], 'width': '40px'},
      {targets: [16], 'className': 'statistic-width-kunde'},
      {targets: [27], 'className': 'statistic-width-info',
        createdCell: function (td, cellData) {
          let $data = cellData === null ? '' : cellData;
          let $name = 'infoStatistic';
          let $center = false;
          $(td).empty().append(
              `<input class="car-table-text-input-edit ${$center === true ? 'car-table-text-center' : ''}" type="text" value="${$data}" data-field="${$name}">`
          );
        }
      },
      {targets: [26], "className": "text-center"},
    ],
    order: [[0, 'asc']],
    fixedColumns:   {
      leftColumns: 6,
    },
    ajax: {
      url: ajaxData,
      type: 'POST',
      data: (d) => {
        d.carId       = store.carId;
        d.changeValue = store.changeValue;
        d.changeField = store.changeField;
        d.filters     = store.filters;
      }
    },
    columns: [
      {'name': 'id', 'data': 'id'},
      {'name': 'ankauf', 'data': 'ankauf'},
      {'name': 'brand', 'data': 'brand'},
      {'name': 'model', 'data': 'model'},
      {'name': 'zustand', 'data': 'zustand'},
      {'name': 'vinNumber', 'data': 'vinNumber'},
      {'name': 'customer', 'data': 'customer'},
      {'name': 'ekNetto', 'data': 'ekNetto'},
      {'name': 'ekBrutto', 'data': 'ekBrutto'},
      {'name': 'ust', 'data': 'ust'},
      {'name': 'invoiceNumber', 'data': 'invoiceNumber'},
      {'name': 'paymentDate', 'data': 'paymentDate'},
      {'name': 'preisTr', 'data': 'preisTr'},
      {'name': 'datumPayFour', 'data': 'datumPayFour'},
      {'name': 'discharge', 'data': 'discharge'},
      {'name': 'datum', 'data': 'datum'},
      {'name': 'company', 'data': 'company'},
      {'name': 'proformaNumber', 'data': 'proformaNumber'},
      {'name': 'proformaDate', 'data': 'proformaDate'},
      {'name': 'carInvoiceNumber', 'data': 'carInvoiceNumber'},
      {'name': 'carInvoiceDate', 'data': 'carInvoiceDate'},
      {'name': 'paymentType', 'data': 'paymentType'},
      {'name': 'zahldatum', 'data': 'zahldatum'},
      {'name': 'vkNetto', 'data': 'vkNetto'},
      {'name': 'vkBrutto', 'data': 'vkBrutto'},
      {'name': 'gewinn', 'data': 'gewinn'},
      {'name': 'seller', 'data': 'seller'},
      {'name': 'infoStatistic', 'data': 'infoStatistic'},
      {'name': 'standtage', 'data': 'standtage'},
    ],
    drawCallback: () => {
      let $filters = $('.dataTables_scrollHeadInner .open .dropdown-menu');
      if ($filters.length > 0) {
        $.each($filters, (index, value) => {
          let $coordinates = $(value).parent().offset();
          $(value).offset({top: $coordinates.top + 30, left: $coordinates.left})
        });
      }

      let $datatableScrollBody = $('.DTFC_LeftBodyLiner');
      let $datatableScrollYPosition = $datatableScrollBody.scrollTop();
      $datatableScrollBody.scrollTop($datatableScrollYPosition+1);
      $datatableScrollBody.scrollTop($datatableScrollYPosition-1);

      $.ajax({
        method: 'POST',
        url: statisticSumme,
        data: $datatableCar.ajax.params(),
      })
        .done($data => {
          $.each($data, ($index, $value) => {
            $(`.${$index}-summe`).text($value);
          });
        })
        .fail(() => {
          console.log('fail');
        });
    },
    createdRow: (row, aData, index) => {
      $(row)
          .addClass(`car-table-row-${index}`)
          .attr('data-id', index);

      let $i = 0;
      let $carInvoiceDate = true;
      let $paymentType = true;
      let $zahldatum = true;
      let $gewinn = true;
      let $seller = true;
      let $vkNettoAndBrutto = true;
      if (aData.carInvoiceDate !== '' && aData.carInvoiceDate !== null) {
        $i++;
        $carInvoiceDate = false;
      }
      if (aData.paymentType !== '' && aData.paymentType !== null) {
        $i++;
        $paymentType = false;
      }
      if (aData.zahldatum !== '' && aData.zahldatum !== null) {
        $i++;
        $zahldatum = false;
      }
      if (aData.gewinn !== '' && aData.gewinn !== null) {
        $i++;
        $gewinn = false;
      }
      if (aData.seller !== '' && aData.seller !== null) {
        $i++;
        $seller = false;
      }
      if ((aData.vkNetto !== '' && aData.vkNetto !== null) || ((aData.vkBrutto !== '' && aData.vkBrutto !== null))) {
        $i++;
        $vkNettoAndBrutto = false;
      }

      if ($i >= 3) {
        if ($carInvoiceDate) {
          $(row).find(`td:eq(${getColumnPosition('carInvoiceDate')})`).addClass('statistic-table-yellow-background');
        }
        if ($paymentType) {
          $(row).find(`td:eq(${getColumnPosition('paymentType')})`).addClass('statistic-table-yellow-background');
        }
        if ($zahldatum) {
          $(row).find(`td:eq(${getColumnPosition('zahldatum')})`).addClass('statistic-table-yellow-background');
        }
        if ($gewinn) {
          $(row).find(`td:eq(${getColumnPosition('gewinn')})`).addClass('statistic-table-yellow-background');
        }
        if ($seller) {
          $(row).find(`td:eq(${getColumnPosition('seller')})`).addClass('statistic-table-yellow-background');
        }
        if ($vkNettoAndBrutto) {
          $(row).find(`td:eq(${getColumnPosition('vkNetto')})`).addClass('statistic-table-yellow-background');
          $(row).find(`td:eq(${getColumnPosition('vkBrutto')})`).addClass('statistic-table-yellow-background');
        }
      }
    },
  });

  $('#datatable-car tbody').on('mouseover', 'tr', function () {
    let $index = $datatableCar.row(this).index();
    let $hoverRow = $(`.car-table-row-${$index}`);
    $hoverRow.addClass('car-table-hover-row');
  });

  $('#datatable-car tbody').on('mouseleave', 'tr', function () {
    let $index = $datatableCar.row(this).index();
    let $hoverRow = $(`.car-table-row-${$index}`);
    $hoverRow.removeClass('car-table-hover-row');
  });

  $('#datatable-car tbody').on('dblclick', 'tr', function () {
    let $data   = $datatableCar.row($(this).closest('tr')).data();
    let $dataId = $data.id;
    window.open(editRoute + '/' + $dataId, '_blank');
  });

  $('.car-selection-button').click(function () {
    if (store.singleSelection) {
      store.singleSelection = false;
      $(this).text(userLocale === 'de' ? 'Einzelauswahl' : 'pojedynczy wybor');
    } else {
      store.singleSelection = true;
      $(this).text(userLocale === 'de' ? 'Mehrfachauswahl' : 'wielokrotny wybor');
    }
  });

  $('#datatable-car tbody').on('click', 'tr', function () {
    let $index = $datatableCar.row(this).index();
    if (store.singleSelection) {
      $('.car-table-select-row').removeClass('car-table-select-row');
      $(`.car-table-row-${$index}`).addClass('car-table-select-row');
    } else {
      let $clickedRow = $(`.car-table-row-${$index}`);
      $clickedRow.hasClass('car-table-select-row')
          ? $clickedRow.removeClass('car-table-select-row')
          : $clickedRow.addClass('car-table-select-row')
    }
  });

  $('.car-select-all-button').click(() => {
    let $rows = $datatableCar.rows().indexes();
    if (store.selectedAll === false) {
      $.each($rows, ($index, $value) => {
        $(`.car-table-row-${$value}`).addClass('car-table-select-row');
      });
      store.selectedAll = true;
    } else {
      $.each($rows, ($index, $value) => {
        $(`.car-table-row-${$value}`).removeClass('car-table-select-row');
      });
      store.selectedAll = false;
    }
  });

  function getShowAndHideColumns() {
    return [
      'invoiceNumber:name',
      'paymentDate:name',
      'company:name',
      'proformaNumber:name',
      'proformaDate:name',
      'standtage:name',
    ];
  }

  $('.car-show-hide-button').click(() => {
    showAndHideColumns();
  });

  function showAndHideColumns() {
    store.showAndHideColumn = !store.showAndHideColumn;
    $datatableCar.columns(getShowAndHideColumns()).visible(store.showAndHideColumn, false);
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

  $('div.dataTables_filter input').unbind().on('keyup', function(e) {
    if(e.which === 13) {
      $datatableCar.search(this.value).draw();
    }
  });

  $('#datatable-car tbody').on( 'click', 'input.car-table-text-input-edit', function() {
    let $self = $(this);
    let $currentValue = $self.val();
    let $data = $datatableCar.row($(this).closest('tr')).data();
    $self.focusout(function() {
      let $newValue = $self.val();
      if ($currentValue !== $newValue) {
        store.carId       = $data.id;
        store.changeValue = $newValue;
        store.changeField = $self.attr('data-field');

        $datatableCar.ajax.url(changeInputFieldStatistics).load(null, false);
      }
    });
    $(document).off('keydown').keydown(e => {
      if(e.which === 13) {
        $self.blur();
      }
    });
  });

  $($datatableCar.table().container()).on( 'click', 'thead .cartable-filters', function (e) {
    let $self = $(this);
    let $id   = $self.attr('id');
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
        'searchValue': $datatableCar.search()
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
              if (($id === 'downloadDate') && $outputValue !== 'Empty') {
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

  $('.car-statistic-export-excel').click(() => {
    let $rows  = $('.car-table-select-row');
    let $array = [];
    $.each($rows, ($index, $value) => {
      $array.push($($value).attr('data-id'));
    });
    let $uniq = [...new Set($array)];
    let $data = $datatableCar.rows($uniq).data();

    let $ids = '';
    $.each($data, ($index, $value) => {
      $ids = $ids === '' ? $value.id : $ids + ',' + $value.id;
    });

    if (store.selectedAll) {
      let $params = $datatableCar.ajax.params();
      let $length = $datatableCar.rows().data().length;
      $params.start = $length;
      $params.paramLength = true;

      if ($length === $params.length) {
        $.ajax({
          method: 'POST',
          url: ajaxData,
          data: $params,
          async: false
        })
          .done((data) => {
            $.each(data.data, (index, value) => {
              $ids = $ids === '' ? value.id : $ids + ',' + value.id;
            });
          })
          .fail(() => {
            console.log('fail');
          });
      }
    }

    if ($ids !== '') {
      $('#export-excel-form').remove();

      let $form = `
        <form action="${exportExcel}" method="POST" id="export-excel-form" target="_blank">
          <input type="hidden" id="car-ids" name="car-ids" value="${$ids}"/>
        </form>
      `;

      $('.users').append($form);
      $('#export-excel-form').submit();
    }
  });

  function getColumnPosition($columnName) {
    switch ($columnName) {
      case 'carInvoiceDate':
        return store.showAndHideColumn ? 19 : 14;
      case 'paymentType':
        return store.showAndHideColumn ? 20 : 15;
      case 'zahldatum':
        return store.showAndHideColumn ? 21 : 16;
      case 'vkNetto':
        return store.showAndHideColumn ? 22 : 17;
      case 'vkBrutto':
        return store.showAndHideColumn ? 23 : 18;
      case 'gewinn':
        return store.showAndHideColumn ? 24 : 19;
      case 'seller':
        return store.showAndHideColumn ? 25 : 20;
    }
  }

  $('.statistic-export-csv').click(() => {
    let $rows  = $('.car-table-select-row');
    let $array = [];
    $.each($rows, ($index, $value) => {
      $array.push($($value).attr('data-id'));
    });
    let $uniq = [...new Set($array)];
    let $data = $datatableCar.rows($uniq).data();

    let $ids = '';
    $.each($data, ($index, $value) => {
      $ids = $ids === '' ? $value.id : $ids + ',' + $value.id;
    });

    if (store.selectedAll) {
      let $params = $datatableCar.ajax.params();
      let $length = $datatableCar.rows().data().length;
      $params.start = $length;
      $params.paramLength = true;

      if ($length === $params.length) {
        $.ajax({
          method: 'POST',
          url: ajaxData,
          data: $params,
          async: false
        })
          .done((data) => {
            $.each(data.data, (index, value) => {
              $ids = $ids === '' ? value.id : $ids + ',' + value.id;
            });
          })
          .fail(() => {
            console.log('fail');
          });
      }
    }

    if ($ids !== '') {
      $.ajax({
        method: 'POST',
        url: exportCsv,
        data: {'ids': $ids},
      })
        .done($data => {
          location.href = $data.filePath;
        })
        .fail(() => {
          console.log('fail');
        });
    }
  });
});