import BaseRole from '../car/BaseRole.js';

/**
 * RoleNine class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleNine {

  constructor() {
    this.baseRole = new BaseRole();
  }

  /**
   * @returns {*[]}
   */
  carTableColumns() {
    return [
      {'name': 'id', 'data': 'id'},
      {'name': 'vendor', 'data': 'vendor'},
      {'name': 'place', 'data': 'place'},
      {'name': 'customer', 'data': 'customer'},
      {'name': 'fhnr', 'data': 'fhnr'},
      {'name': 'discharge', 'data': 'discharge'},
      {'name': 'client', 'data': 'client'},
      {'name': 'radioCode', 'data': 'radioCode'},
      {'name': 'carCondition', 'data': 'carCondition'},
      {'name': 'user', 'data': 'user'},
      {'name': 'vinNumber', 'data': 'vinNumber'},
      {'name': 'createdAt', 'data': 'createdAt'},
      {'name': 'uploader', 'data': 'uploader'},
      {'name': 'brand', 'data': 'brand'},
      {'name': 'model', 'data': 'model'},
      {'name': 'versionPolish', 'data': 'versionPolish'},
      {'name': 'versionGerman', 'data': 'versionGerman'},
      {'name': 'colorPolish', 'data': 'colorPolish'},
      {'name': 'colorGerman', 'data': 'colorGerman'},
      {'name': 'polishComplectation', 'data': 'polishComplectation'},
      {'name': 'germanComplectation', 'data': 'germanComplectation'},
      {'name': 'complectationPolish', 'data': 'complectationPolish'},
      {'name': 'complectationGerman', 'data': 'complectationGerman'},
      {'name': 'completed', 'data': 'completed'},
      {'name': 'ourDiscountPrice', 'data': 'ourDiscountPrice'},
      {'name': 'zakupBrut', 'data': 'zakupBrut'},
      {'name': 'initialPriceWithOutVat', 'data': 'initialPriceWithOutVat'},
      {'name': 'initialVatPrice', 'data': 'initialVatPrice'},
      {'name': 'showPrice', 'data': 'showPrice'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'vat', 'data': 'vat'},
      {'name': 'priceRoleFive', 'data': 'priceRoleFive'},
      {'name': 'priceRoleSix', 'data': 'priceRoleSix'},
      {'name': 'priceRoleSeven', 'data': 'priceRoleSeven'},
      {'name': 'demo', 'data': 'demo'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'ekNetto', 'data': 'ekNetto'},
      {'name': 'ekBrutto', 'data': 'ekBrutto'},
      {'name': 'ust', 'data': 'ust'},
      {'name': 'invoiceNumber', 'data': 'invoiceNumber'},
      {'name': 'paymentDate', 'data': 'paymentDate'},
      {'name': 'paid', 'data': 'paid'},
      {'name': 'documents', 'data': 'documents'},
      {'name': 'downloadDate', 'data': 'downloadDate'},
      {'name': 'forwarder', 'data': 'forwarder'},
      {'name': 'targetUnload', 'data': 'targetUnload'},
      {'name': 'shippingCost', 'data': 'shippingCost'},
      {'name': 'transportInvoiceNumber', 'data': 'transportInvoiceNumber'},
      {'name': 'pay', 'data': 'pay'},
      {'name': 'data2', 'data': 'data2'},
      {'name': 'location', 'data': 'location'},
      {'name': 'preisTr', 'data': 'preisTr'},
      {'name': 'pay5', 'data': 'pay5'},
      {'name': 'orderNumber', 'data': 'orderNumber'},
      {'name': 'salePriceWithVAT', 'data': 'salePriceWithVAT'},
      {'name': 'nrPro2', 'data': 'nrPro2'},
      {'name': 'dataPro2', 'data': 'dataPro2'},
      {'name': 'salesInvoiceNumber', 'data': 'salesInvoiceNumber'},
      {'name': 'dataFv2', 'data': 'dataFv2'},
      {'name': 'paidSuccess', 'data': 'paidSuccess'},
      {'name': 'invoiceDate', 'data': 'invoiceDate'},
      {'name': 'information', 'data': 'information'},
      {'name': 'sellingPrice', 'data': 'sellingPrice'},
      {'name': 'datum', 'data': 'datum'},
      {'name': 'seller', 'data': 'seller'},
      {'name': 'additionalWork', 'data': 'additionalWork'},
      {'name': 'notes', 'data': 'notes'},
      {'name': 'date', 'data': 'date'},
      {'name': 'placeOfIssue', 'data': 'placeOfIssue'},
      {'name': 'declaration', 'data': 'declaration'},
      {'name': 'importTax', 'data': 'importTax'},
      {'name': 'taxNumber', 'data': 'taxNumber'},
      {'name': 'taxReturned', 'data': 'taxReturned'},
    ];
  }

  /**
   * @returns {[]}
   */
  showAndHideColumns() {
    return [
      'createdAt:name',
      'uploader:name',
      'brand:name',
      'versionPolish:name',
      'colorPolish:name',
      'polishComplectation:name',
      'germanComplectation:name',
      'complectationPolish:name',
      'ourDiscountPrice:name',
      'zakupBrut:name',
      'initialPriceWithOutVat:name',
      'initialVatPrice:name',
      'salePriceWithOutVAT:name',
      'vat:name',
      'priceRoleFive:name',
      'priceRoleSix:name',
      'priceRoleSeven:name',
      'ekNetto:name',
      'ekBrutto:name',
      'ust:name',
      'invoiceNumber:name',
      'paymentDate:name',
      'paid:name',
      'forwarder:name',
      'shippingCost:name',
      'transportInvoiceNumber:name',
      'pay:name',
      'data2:name',
      'preisTr:name',
      'pay5:name',
      'orderNumber:name',
      'salePriceWithVAT:name',
      'nrPro2:name',
      'dataPro2:name',
      'salesInvoiceNumber:name',
      'dataFv2:name',
      'paidSuccess:name',
      'invoiceDate:name',
      'placeOfIssue:name',
      'declaration:name',
      'importTax:name',
      'taxNumber:name',
      'taxReturned:name',
    ];
  }

  /**
   * @returns {number}
   */
  getFixedColumn() {
    return 11;
  }

  /**
   * @returns {number}
   */
  getRadioCodePosition() {
    return 6;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
    return 7;
  }

  /**
   * @returns {number}
   */
  getCompletedColumn() {
    return 23;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? 48 : null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 41 : null;
  }

  /**
   * @returns {number}
   */
  getTerminColumn($showType) {
    return $showType ? 22 : 14;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 42 : 19;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
    return $showType ? [9, 10, 11, 12] : [9, 10];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [4],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'fhnr');
        }
      },
      {targets: [5],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'discharge');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'client');
        }
      },
      {targets: [7],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [9],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [40], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [42], "className": "text-center"}, // paid
      {targets: [43], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [44], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [46],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [49], "className": "text-center"}, // Pay
      {targets: [51], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [53], "className": "text-center"}, // pay5
      {targets: [60], "className": "text-center"}, // paidSuccess
      {targets: [62],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [70],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'declaration');
        }
      }, // CRM
      {targets: [71],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [72],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [73], "className": "text-center"}, // taxReturned
    ];
  }

  /**
   * @returns {*[]}
   */
  polishColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [4],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'fhnr');
        }
      },
      {targets: [5],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'discharge');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'client');
        }
      },
      {targets: [7],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [9],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [40], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [42], "className": "text-center"}, // paid
      {targets: [43], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [44], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [46],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [49], "className": "text-center"}, // Pay
      {targets: [51], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [53], "className": "text-center"}, // pay5
      {targets: [60], "className": "text-center"}, // paidSuccess
      {targets: [62],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [70],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'declaration');
        }
      }, // CRM
      {targets: [71],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [72],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [73], "className": "text-center"}, // taxReturned
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [];
    } else {
      return [
        {index: 41, edit: true, name: 'paid'},
        {index: 48, edit: true, name: 'pay'},
        {index: 52, edit: true, name: 'pay5'},
        {index: 59, edit: true, name: 'paidSuccess'},
        {index: 72, edit: true, name: 'taxReturned'},
      ];
    }
  }
}
