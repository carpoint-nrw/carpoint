import Datatable from '../entries/Datatable.js';

$(() => {
  const store = {
    filterData: [],
    year: null,
    month: null
  };

  let $datatableInvoice = $('#datatable-invoice').DataTable({
    language: new Datatable().translateDefaultValues(),
    processing: true,
    serverSide: true,
    searching: false,
    pageLength: 25,
    order: [[ 1, 'desc' ]],
    columnDefs: [
      { targets: 2, orderable: false, className: "text-center"},
      { targets: 3, orderable: false, className: "text-center"},
    ],
    ajax: {
      url: ajaxData,
      type: 'POST',
      data: d => {
        d.year  = store.year;
        d.month = store.month;
      }
    },
    columns: [
      {
        'name': 'invoiceFileName',
        'data': 'invoiceFileName',
      },
      {
        'name': 'carInvoiceDate',
        'data': 'carInvoiceDate'
      },
      {
        'name': 'open',
        'data': 'invoiceFileName'
      },
      {
        'name': 'download',
        'data': 'invoiceFileName'
      },
    ],
    createdRow: (row, aData) => {
      $(row).find('td:eq(2)')
        .text('')
        .append(`
          <a href="${carInvoiceRelativePath +`/`+ aData['invoiceFileName']}" target="_blank">
              <i class="far fa-eye fa-2x pages-edit-icon"></i>
          </a>`
        );
      $(row).find('td:eq(3)')
        .text('')
        .append(`
          <a href="${carInvoiceRelativePath +`/`+ aData['invoiceFileName']}" download="${aData['invoiceFileName']}">
              <i class="fas fa-file-download fa-2x pages-edit-icon"></i>
          </a>`
        );
    }
  });

  $.ajax({
    method: 'GET',
    url: filterData,
  })
      .done($data => {
        store.filterData = $data;
        let $yearSelect  = $('.sort-year-select');
        $.each($data, (index, value) => {
          let $option = new Option(index, index, false, true);
          $yearSelect.prepend($option);
        });
      })
      .fail(() => {
        console.log('fail');
      })
      .always(() => {
        renderFilterMonth($('.sort-year-select :selected').val());
      });

  $('.sort-year-select').change(() => {
    renderFilterMonth($('.sort-year-select :selected').val());
  });
  $('.sort-month-select').change(() => {
    loadData();
  });

  function renderFilterMonth($year) {
    $(".sort-month-select option").remove();

    let $monthSelect = $('.sort-month-select');
    let $yearData   = store.filterData[$year];
    $.each($yearData, (index, value) => {
      let $option = new Option(value, value, false, true);
      $monthSelect.prepend($option);
    });

    loadData();
  }

  function loadData() {
    store.year  = $('.sort-year-select :selected').val();
    store.month = $('.sort-month-select :selected').val();
    $datatableInvoice.ajax.url(ajaxData).load();
  }

  $('.invoice-download-files').click(() => {
    let $year  = $('.sort-year-select :selected').val();
    let $month = $('.sort-month-select :selected').val();

    location.href = `${downloadFiles}?year=${$year}&month=${$month}`;
  });
});