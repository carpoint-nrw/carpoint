$(() => {
  const store = {
    invoiceNumber: false,
  };

  let $brand = $('#brand');
  let $model = $('#model');
  let $versionPolish = $('#versionPolish');
  let $versionGerman = $('#versionGerman');
  let $complecatationPolish = $('#standartComplectationPolish');
  let $complecatationGerman = $('#standartComplectationGerman');
  let $currentVersionId = $versionPolish.val();

  if (formType === 'new') {
    $brand.val('1');
    $model.empty();
    $versionPolish.empty();
    $versionGerman.empty();
    getModel(true);
  } else {
    let $selectedModel = $model.val();
    let $selectedVersion = $versionPolish.val();
    getModel(false, false);
    getVersion(false, $selectedModel, false);
    $model.val($selectedModel);
    $versionPolish.val($selectedVersion);
    $versionGerman.val($selectedVersion);
    getComplectation();
  }

  $brand.change(() => {
    getModel(true);
  });
  $model.change(() => {
    getVersion();
  });
  $versionPolish.change(function() {
    let $valueSelected = this.value;
    $versionGerman.val($valueSelected);
    getComplectation();
  });
  $versionGerman.change(function() {
    let $valueSelected = this.value;
    $versionPolish.val($valueSelected);
    getComplectation();
  });

  function getModel($version = false, $async = true) {
    $model.empty();
    $.ajax({
      method: 'GET',
      url: ajaxGetModel,
      data: {'brand': $brand.val()},
      async: $async,
    })
      .done((data) => {
        data.forEach((value) => {
          let $option = new Option(value.title, value.id, false, false);
          $model.append($option);
        });
        if ($version) {
          getVersion();
        }
      })
      .fail(() => {
        console.log('fail');
      });
  }

  function getVersion($async = true, $currentModel = null, $complectation = true) {
    $versionPolish.empty();
    $versionGerman.empty();
    $.ajax({
      method: 'GET',
      url: ajaxGetVersion,
      data: {
        'model': $currentModel === null ? $model.val() : $currentModel,
        'version': $currentVersionId
      },
      async: $async,
    })
      .done((data) => {
        data.forEach((value) => {
          let $optionPolish = new Option(value.polish, value.id, false, false);
          $versionPolish.append($optionPolish);

          let $optionGerman = new Option(value.german, value.id, false, false);
          $versionGerman.append($optionGerman);
        });
        if ($complectation) {
          getComplectation();
        }
      })
      .fail(() => {
        console.log('fail');
      });
  }

  function getComplectation() {
    $complecatationPolish.val('');
    $complecatationGerman.val('');
    $.ajax({
      method: 'GET',
      url: ajaxGetStandartComplectation,
      data: {'version': $versionPolish.val()},
    })
      .done((data) => {
        if ($complecatationPolish.length === 1 && data !== '') {
          $complecatationPolish.val(data.polish.title)
        }
        if ($complecatationGerman.length === 1 && data !== '') {
          $complecatationGerman.val(data.german.title)
        }
      })
      .fail(() => {
        console.log('fail');
      });
  }

  // Calculate discount
  let $initialPrice = $('#initialPriceWithOutVat');
  let $ourPrice = $('#ourDiscountPrice');
  let $discount = $('#discount');
  $initialPrice.on('change keyup paste', () => {
    calculateDiscount();
    setPrices();
  });

  $('#zakupBrut').on('change keyup paste', () => {
    calculateOurDiscount();
    calculateDiscount();
    culculateVat();
  });

  function calculateOurDiscount() {
    let $result = ($('#zakupBrut').val() / 1.23).toFixed(2);
    if (isNaN($result)) {
      return;
    }

    $('#ourDiscountPrice').val($result);
    culculateZysk();
  }

  $('#ourDiscountPrice').on('change keyup paste', () => {
    calculateDiscount();
    culculateZysk();
  });
  
  function calculateDiscount() {
    let $initialPriceNumber = Number($initialPrice.val());
    let $ourPriceNumber     = Number($ourPrice.val());

    if (isNaN($initialPriceNumber) || isNaN($ourPriceNumber)) {
      $discount.val('');

      return;
    }

    if ($ourPriceNumber > $initialPriceNumber) {
      $discount.val('');
    } else {
      let $discountNumber = (($initialPriceNumber - $ourPriceNumber) / $initialPriceNumber) * 100;
      if (isNaN($discountNumber)) {
        $discount.val('');

        return;
      }
      $discount.val($discountNumber.toFixed(1))
    }
  }
  // ------------------

  // Calculate Listenpreis Netto
  let $initialVatPrice = $('#initialVatPrice');

  $initialVatPrice.on('change keyup paste', () => {
    calculateInitialWithOutVat();
    setPrices();
  });

  function calculateInitialWithOutVat() {
    $initialPrice.val(($initialVatPrice.val() / 1.23).toFixed(0));
    calculateDiscount();
  }
  // ---------------------------

  function setPrices() {
    let $start = $initialPrice.val();
    let $price1 = '';
    let $price2 = '';
    let $price3 = '';
    if ($start !== '') {
      $price1 = parseInt($start) + 800;
      $price2 = parseInt($start)  + 1500;
      $price3 = parseInt($start);
    }

    $('#priceRoleFive').val($price1);
    $('#priceRoleSix').val($price2);
    $('#priceRoleSeven').val($price3);
  }

  // Change Customer
  $('#customer').change(function() {
    let $carConditionVal = $('#carCondition').val();
    if ($('#customer option:selected').text() === 'CP') {
      $('#carCondition').val('reservation');
    } else {
      if ($carConditionVal === 'reservation') {
        $('#carCondition').val('');
      }
    }

    setCarVisibilityCheckbox();
    changePrices();
  });
  // ---------------

  function setCarVisibilityCheckbox() {
    let $bestellerText = $('#customer option:selected').text();
    if ($bestellerText === 'CP' || $bestellerText === 'LB') {
      $('#carVisibility').prop('disabled', false);
    } else {
      $('#carVisibility').prop('disabled', true).prop('checked', false);
    }
  }
  setCarVisibilityCheckbox();

  changePrices();
  function changePrices() {
    if (userRole === 'ROLE_ADMIN_14') {
      return;
    }
    let $selected = $('#customer option:selected').text();
    if ($selected == '' || $selected == 'CL' || $selected == 'I') {
      $('#zakupBrut').attr('readonly', false);
      $('#ourDiscountPrice').attr('readonly', true);
      calculateOurDiscount();
    } else {
      $('#zakupBrut').attr('readonly', true);
      $('#ourDiscountPrice').attr('readonly', false);
      $('#zakupBrut').val('');
    }
  }
  
    let $baseColor = $('#baseColor');
    let $colorPolish = $('#colorPolish');
    let $colorGerman = $('#colorGerman');
    let $colorDescription = $('#colorDescription');
  
    $baseColor.change(() => {
        $colorPolish.empty();
        $colorGerman.empty();
        $colorDescription.empty();
        $.ajax({
          method: 'GET',
          url: ajaxGetColorDescription,
          data: {'baseColor': $('#baseColor').val()},
        })
          .done((data) => {
            data.forEach((value) => {
              let $germanOption = new Option(value.german, value.id, false, false);
              $colorGerman.append($germanOption);
              let $polishOption = new Option(value.polish, value.id, false, false);
              $colorPolish.append($polishOption);
              let $colorOption = new Option(value.title, value.id, false, false);
              $colorDescription.append($colorOption);
            });
          })
          .fail(() => {
            console.log('fail');
          });
  });
  $('#colorDescription').change(() => {
    $('#colorGerman').val($('#colorDescription').val());
  });
  $('#colorPolish').change(() => {
    $('#colorGerman').val($('#colorPolish').val());
  });
  $('#colorGerman').change(() => {
    $('#colorPolish').val($('#colorGerman').val());
  });

  // Place and Vendor
  let $place = $('#place');
  let $vendor = $('#vendor');

  $place.change(() => {
    $vendor.val('');
  });
  $vendor.change(() => {
    $.ajax({
      method: 'GET',
      url: ajaxGetPlace,
      data: {'vendor': $vendor.val()},
    })
      .done((data) => {
        $place.val(data);
      })
      .fail(() => {
        console.log('fail');
      });
  });
  // ----------------

  // Select Ort
  if (formType === 'new') {
    $('#ort > option').each(function($index) {
      if (this.text === 'Neukirchen-Vluyn') {
        $('#ort').val(this.value);
      }
    });
  }
  // ----------

  // vat
  culculateVat();
  function culculateVat() {
    let $result = ($('#zakupBrut').val() - $ourPrice.val()).toFixed(2);
    if (isNaN($result)) {
      return;
    }
    $('#vat').val($result);
  }
  // ----------

  $('#paidSuccess').on('click', () => {
    if (userRole !== 'ROLE_ADMIN_2') {
      if ($('#paidSuccess').is(":checked") && $('#invoiceDate').val() === '') {
        $('#invoiceDate').val(getCurrentDate());
      } else {
        $('#invoiceDate').val('');
      }
    }
  });

  $('#pay').on('click', () => {
    if (userRole !== 'ROLE_ADMIN_2') {
      if ($('#pay').is(":checked") && $('#data2').val() === '') {
        $('#data2').val(getCurrentDate());
      } else {
        $('#data2').val('');
      }
    }
  });

  function getCurrentDate() {
    let now = new Date();
    let day = ('0' + now.getDate()).slice(-2);
    let month = ('0' + (now.getMonth() + 1)).slice(-2);
    let today = now.getFullYear()+'-'+(month)+'-'+(day) ;

    return today;
  }

  $('#salePriceWithVAT').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#salePriceWithOutVATType').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#salePriceWithVATType').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#shippingCostType').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#shippingCost').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#salePriceWithOutVAT').on('change keyup paste', () => {
    culculateZysk();
  });
  $('#user').on('change keyup paste', () => {
    changeInvoiceNumber();
  });
  $('#nrPro2').on('change keyup paste', () => {
    changeInvoiceNumber();
  });
  $('#salesInvoiceNumber').on('change keyup paste', () => {
    changeInvoiceNumber();
  });
  $('#invoiceNumber').on('change keyup paste', () => {
    if ($('#paymentDate').val() === '') {
      $('#paymentDate').val(getCurrentDate());
    }
    if ($('#invoiceNumber').val() === '') {
      store.invoiceNumber = true;
      $('#paymentDate').val('');
    }
  });
  $('#zahldatumPay').on('click', () => {
    if ($('#zahldatumPay').is(":checked") && $('#zahldatum').val() === '') {
      $('#zahldatum').val(getCurrentDate());
    } else {
      $('#zahldatum').val('');
    }
  });
  $('#sellingPrice').on('change keyup paste', () => {
    calculateRestsumme();
    calculateGewinn();
  });
  $('#deposit').on('change keyup paste', () => {
    calculateRestsumme();
  });
  $('#mwst').on('change keyup paste', () => {
    if ($('#mwst').is(":checked")) {
      $('#taxType').find('option').remove();
      $('#taxType').append(new Option('inkl. 16% Ust.', 7));
      $('#taxType').append(new Option('inkl. 16% Ust. ( Export)', 8));
      $('#taxType').append(new Option('inkl. 19% Ust.', 1));
      $('#taxType').append(new Option('inkl. 19% Ust. ( Export)', 2));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §4 Nr.1a UStG (Export innerhalb der EU)', 4));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)', 5));


      $('#ekNetto')
        .val(($('#ekBrutto').val() / 1.19).toFixed(0))
        .attr('readonly', true);
    } else {
      $('#taxType').find('option').remove();
      $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG', 3));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG (Export)', 6));

      $('#ekNetto').val('');
    }

    calculateUst();
    calculateGewinn();
  });
  $('#taxType').on('change keyup paste', () => {
    calculateGewinn();
  });
  $('#ekNetto').on('change keyup paste', () => {
    if ($('#ekNetto').val() === '') {
      $('#ekBrutto').attr('readonly', false);
      if (!$("#taxType option[value='3']").length > 0) {
        $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG', 3));
        $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG (Export)', 6));
      }
    } else {
      $('#ekBrutto').attr('readonly', true).val('');
      $('#mwst').prop('disabled', true).prop('checked', false);
      $("#taxType option[value='3']").remove();
      $("#taxType option[value='6']").remove();
    }

    calculateUst();
    calculateGewinn();
  });
  $('#preisTr').on('change keyup paste', () => {
    calculateGewinn();
  });
  $('#ekBrutto').on('change keyup paste', () => {
    if ($('#ekBrutto').val() === '') {
      $('#mwst').prop('disabled', true).prop('checked', false);
      $('#ekNetto').val('').attr('readonly', false);

      $('#taxType').find('option').remove();
      $('#taxType').append(new Option('', ''));
      $('#taxType').append(new Option('inkl. 16% Ust.', 7));
      $('#taxType').append(new Option('inkl. 16% Ust. ( Export)', 8));
      $('#taxType').append(new Option('inkl. 19% Ust.', 1));
      $('#taxType').append(new Option('inkl. 19% Ust. ( Export)', 2));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG', 3));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG (Export)', 6));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §4 Nr.1a UStG (Export innerhalb der EU)', 4));
      $('#taxType').append(new Option('umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)', 5));
    } else {
      $('#mwst').prop('disabled', false);
      $('#ekNetto').attr('readonly', true);

      $('#taxType').find('option').remove();
      if (!$("#taxType option[value='3']").length > 0) {
        $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG', 3));
        $('#taxType').append(new Option('umsatzsteuerfrei nach §25a UStG (Export)', 6));
      }

      if ($('#mwst').is(":checked")) {
        $('#ekNetto')
          .val(($('#ekBrutto').val() / 1.19).toFixed(0))
          .attr('readonly', true);
      } else {
        $('#ekNetto').val('');
      }
    }

    calculateUst();
    calculateGewinn();
  });

  function culculateZysk() {
    if ($('#shippingCostType').val() === 'PLN' && $('#salePriceWithOutVATType').val() === 'PLN') {
      $('#zysk').val(($('#salePriceWithOutVAT').val() - $('#ourDiscountPrice').val() - ($('#shippingCost').val() / 1.23)).toFixed(0));

    } else if ($('#shippingCostType').val() === 'EUR' && $('#salePriceWithOutVATType').val() === 'PLN') {
      $('#zysk').val(($('#salePriceWithOutVAT').val() - (($('#shippingCost').val() / 1.23) * currency) - $('#ourDiscountPrice').val()).toFixed(0));

    } else if ($('#shippingCostType').val() === 'PLN' && $('#salePriceWithOutVATType').val() === 'EUR') {
      $('#zysk').val((($('#salePriceWithOutVAT').val() * currency) - $('#ourDiscountPrice').val() - ($('#shippingCost').val() / 1.23)).toFixed(0));

    } else if ($('#shippingCostType').val() === 'EUR' && $('#salePriceWithOutVATType').val() === 'EUR') {
      $('#zysk').val((($('#salePriceWithOutVAT').val() * currency) - $('#ourDiscountPrice').val() - (($('#shippingCost').val() / 1.23) * currency)).toFixed(0));
    }
  }

  store.invoiceNumber = $('#invoiceNumber').val() === '';
  function changeInvoiceNumber() {
    if (store.invoiceNumber && ($('#user option:selected').text() === 'Carpoint GmbH' || $('#user option:selected').text() === 'CARPOINT GmbH')) {
      if ($('#nrPro2').val() !== '') {
        $('#invoiceNumber').val($('#nrPro2').val());
        if ($('#paymentDate').val() === '') {
          $('#paymentDate').val(getCurrentDate());
        }
      } else if ($('#salesInvoiceNumber').val() !== '') {
        $('#invoiceNumber').val($('#salesInvoiceNumber').val());
        if ($('#paymentDate').val() === '') {
          $('#paymentDate').val(getCurrentDate());
        }
      } else if ($('#nrPro2').val() === '' && $('#salesInvoiceNumber').val() === '') {
        $('#invoiceNumber').val('');
        $('#paymentDate').val('');
      }
    }
  }

  function calculateRestsumme() {
    $('#restsumme').val($('#sellingPrice').val() - $('#deposit').val());
  }

  function calculateUst() {
    if ($('#mwst').is(":checked")) {
      $('#ust').val(($('#ekBrutto').val() - ($('#ekBrutto').val() / 1.19)).toFixed(0));
    } else {
      $('#ust').val('');
    }
  }

  function calculateGewinn() {
    if (
      $('#taxType option:selected').text() == 'inkl. 19% Ust.'
      || $('#taxType option:selected').text() == 'inkl. 19% Ust. ( Export)'
    ) {
      $('#gewinn').val((($('#sellingPrice').val() / 1.19) - $('#ekNetto').val() - $('#preisTr').val()).toFixed(0));
    } else if (
        $('#taxType option:selected').text() == 'inkl. 16% Ust.'
        || $('#taxType option:selected').text() == 'inkl. 16% Ust. ( Export)'
    ) {
      $('#gewinn').val((($('#sellingPrice').val() / 1.16) - $('#ekNetto').val() - $('#preisTr').val()).toFixed(0));
    } else if (
      $('#taxType option:selected').text() == 'umsatzsteuerfrei nach §4 Nr.1a UStG (Export innerhalb der EU)'
      || $('#taxType option:selected').text() == 'umsatzsteuerfrei nach §4 Nr.1b UStG (Export innerhalb der EU)'
    ) {
      $('#gewinn').val(($('#sellingPrice').val() - $('#ekNetto').val()).toFixed(0));
    } else if (
      $('#taxType option:selected').text() == 'umsatzsteuerfrei nach §25a UStG'
      || $('#taxType option:selected').text() == 'umsatzsteuerfrei nach §25a UStG (Export)'
    ) {
      $('#gewinn').val(($('#sellingPrice').val() - $('#ekBrutto').val()).toFixed(0));
    } else {
      $('#gewinn').val(($('#sellingPrice').val() / 1.19).toFixed(0));
    }
  }

  if ($('#ekBrutto').val() === '') {
    $('#mwst').prop('disabled', true);
    if ($('#ekNetto').val() !== '') {
      $('#ekBrutto').attr('readonly', true);
      $("#taxType option[value='3']").remove();
    }
  } else {
    $('#ekNetto').attr('readonly', true);

    if ($('#mwst').is(":checked")) {
      $("#taxType option[value='']").remove();
      $("#taxType option[value='3']").remove();
    } else {
      $("#taxType option[value='']").remove();
      $("#taxType option[value='1']").remove();
      $("#taxType option[value='2']").remove();
      $("#taxType option[value='4']").remove();
      $("#taxType option[value='5']").remove();
      $("#taxType option[value='7']").remove();
      $("#taxType option[value='8']").remove();
    }
  }

  $('#paid').on('click', () => {
    if ($('#paid').is(":checked") && $('#ankauf').val() === '') {
      $('#ankauf').val(getCurrentDate());
    } else {
      $('#ankauf').val('');
    }
    if ($('#paid').is(":checked") && !$('#paidSuccess').is(":checked")) {
      $('#paidSuccess').prop('checked', true);
      if (userRole !== 'ROLE_ADMIN_2') {
        $('#invoiceDate').val(getCurrentDate());
      }
    }
  });

  if (userRole === 'ROLE_ADMIN_1' || userRole === 'ROLE_ADMIN_2' || userRole === 'ROLE_ADMIN_14') {
    $('#carline').collapse('show');
  } else {
    $('#carSale').collapse('show');
  }

  const carpointClearFields = [
    'discharge', 'seller', 'placeOfIssue', 'sellingPrice', 'taxType', 'deposit', 'restsumme', 'paymentType','paymentCondition',
    'firstName', 'lastName', 'street', 'city', 'placeIndex', 'firmNumber', 'email', 'phoneNumber', 'mobileNumber', 'fax',
    'clientStatus', 'bodyType', 'carStatus', 'fuel', 'ptsNumber', 'date', 'ort', 'datum', 'additionalWork', 'notes'
  ];

  $('.clear-car-data').click(() => {
    carpointClearFields.forEach($value => {
      $('#'+$value).val('');
    });
  });

  $(document).keydown(e => {
    if(e.which === 13) {
      e.stopPropagation();
      e.preventDefault();
    }
  });
});