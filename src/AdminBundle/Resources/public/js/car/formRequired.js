$(() => {
  const store = {
    submit: false,
    fail: false,
  };

  $('.car-table-form').submit(function(e) {
    store.fail = false;
    checkVinNumberFunc();
    if (store.fail) {
      e.preventDefault();
    }
  });

  function checkVinNumberFunc() {
    let $vinNumber = $('#vinNumber');
    if ($vinNumber.val() !== '') {
      $.ajax({
        method: 'GET',
        url: checkVinNumber,
        async: false,
        data: {
          'vinNumber': $vinNumber.val(),
          'carId': formType === 'new' ? 0 : carId
        },
      })
        .done($data => {
          checkRequired();
        })
        .fail(() => {
          $("#warning-modal").modal();
          $('.modal-title-warning').text(
            userLocale === 'de'
            ? 'Ein Fahrzeug mit dieser Nummer existiert bereits im System. Bitte überprüfen Sie die Angaben!'
            : 'Pojazd o tym numerze już istnieje w systemie.  Sprawdź informacje!'
          );
          store.fail = true;
        });
    } else {
      checkRequired();
    }
  }

  function checkRequired(e) {
    if (store.submit === false) {
      store.submit = true;

      let $vinNumber = $('#vinNumber');

      let $allFields = userLocale === 'de' ? germanFields() : polishFields();
      let $emptyFields = '';

      [$vinNumber].forEach($value => {
        if ($value.length === 1 && ($value.val() === '' || $value.val() === null)) {
          let $name = $value.attr('name');
          $emptyFields = $emptyFields === '' ? $allFields[$name] : $emptyFields + ', ' + $allFields[$name];
        }
      });

      let $message = userLocale === 'de'
        ? 'Füllen Sie die folgenden Felder aus: '
        : 'Wypełnij następujące polas: ';

      if ($emptyFields !== '') {
        $("#warning-modal").modal();
        $('.modal-title-warning').text($message);
        $('.custom-modal-body-warning').text($emptyFields);
        store.fail = true;
      }
    }
  }

  function germanFields() {
    return {
      'vinNumber': 'Fahrgestellnummer',
    };
  }

  function polishFields() {
    return {
      'vinNumber': 'NUMER VIN',
    };
  }
});