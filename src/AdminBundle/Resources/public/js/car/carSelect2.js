$(() => {
  const store = {
    selecting: false
  };

  const userData = [
    'firstName', 'lastName', 'street', 'city', 'placeIndex',
    'firmNumber', 'email', 'phoneNumber', 'mobileNumber', 'fax'
  ];

  let $firmSelect = $('#firm-select');
  $firmSelect.select2({
    width: '100%',
    ajax: {
      url: getCarFirmNames,
      dataType: 'json',
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return item;
          }),
        };
      },
    }
  })
    .on('select2:selecting', function (e) {
      store.selecting = true;
    })
    .on('select2:closing', function (e) {
      if (store.selecting === false) {
        let newOption = new Option($('.select2-search__field').val(), 'newValue', false, true);
        $firmSelect.append(newOption).trigger('change');
      }
      store.selecting = false;
      $('#firma').val($('#firm-select').select2('data')[0].text);


      setFirmaBackgroundColor();
    })
    .on('select2:select', function (e) {
      let $carId = $('#firm-select').select2('data')[0].id;
      $.ajax({
        method: 'GET',
        url: getCarUserData,
        data: {
          'carId': $carId
        },
      })
        .done($data => {
          userData.forEach($value => {
            let $field = $('#'+$value);
            $field.val($data[$value]);
          });
        })
        .fail(() => {
          console.log('fail');
        });
    });

  let $firmInput    = $('#firma');
  let $carId        = $firmInput.attr('cardataid');
  let $carFirmValue = $firmInput.attr('value');
  let newOption     = new Option($carFirmValue, $carId, false, false);
  $firmSelect.append(newOption).trigger('change');

  function setFirmaBackgroundColor() {
    if ($('#firm-select').select2('data')[0].text === '') {
      $('.select2-selection--single').addClass('car-form-required-field');
    } else {
      $('.select2-selection--single').removeClass('car-form-required-field')
    }
  }
  setFirmaBackgroundColor();
});