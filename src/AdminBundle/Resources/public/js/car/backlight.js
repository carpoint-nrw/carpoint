$(() => {
  const carpointFields = [
    'firma', 'placeOfIssue', 'sellingPrice', 'taxType', 'deposit', 'paymentType', 'paymentCondition',
    'firstName', 'lastName', 'street', 'city', 'placeIndex', 'phoneNumber',
    'mobileNumber', 'clientStatus', 'bodyType', 'carStatus', 'fuel', 'date', 'user', 'salePriceWithOutVAT'
  ];

  carpointFields.forEach($value => {
    let $field = $('#'+$value);
    if ($field.val() === '' && $field.val() !== undefined) {
      $field.addClass('car-form-required-field');
    }

    $field.on('change keyup paste', () => {
      if ($field.val() === '' && $field.val() !== undefined) {
        $field.addClass('car-form-required-field');
      } else if ($field.val() !== '' && $field.val() !== undefined) {
        $field.removeClass('car-form-required-field');
      }
    });
  });
});