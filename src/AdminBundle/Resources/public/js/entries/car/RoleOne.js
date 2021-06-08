import BaseRole from '../car/BaseRole.js';

/**
 * RoleOne class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleOne {

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
      {'name': 'discount', 'data': 'discount'},
      {'name': 'showPrice', 'data': 'showPrice'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'vat', 'data': 'vat'},
      {'name': 'nrPro', 'data': 'nrPro'},
      {'name': 'dataPro', 'data': 'dataPro'},
      {'name': 'nrFv', 'data': 'nrFv'},
      {'name': 'dataFv', 'data': 'dataFv'},
      {'name': 'pay4', 'data': 'pay4'},
      {'name': 'data1', 'data': 'data1'},
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
      {'name': 'ankauf', 'data': 'ankauf'},
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
      {'name': 'zysk', 'data': 'zysk'},
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
      {'name': 'carlineDate', 'data': 'carlineDate'},
      {'name': 'carlineNumber', 'data': 'carlineNumber'},
      {'name': 'gewinn', 'data': 'gewinn'},
      {'name': 'zahldatumPay', 'data': 'zahldatumPay'},
      {'name': 'zahldatum', 'data': 'zahldatum'},
      {'name': 'additionalWork', 'data': 'additionalWork'},
      {'name': 'notes', 'data': 'notes'},
      {'name': 'date', 'data': 'date'},
      {'name': 'placeOfIssue', 'data': 'placeOfIssue'},
      {'name': 'importTax', 'data': 'importTax'},
      {'name': 'segregator', 'data': 'segregator'},
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
      'versionGerman:name',
      'colorGerman:name',
      'polishComplectation:name',
      'germanComplectation:name',
      'complectationPolish:name',
      'zakupBrut:name',
      'initialPriceWithOutVat:name',
      'initialVatPrice:name',
      'salePriceWithOutVAT:name',
      'vat:name',
      'nrPro:name',
      'dataPro:name',
      'nrFv:name',
      'dataFv:name',
      'pay4:name',
      'ankauf:name',
      'data1:name',
      'priceRoleFive:name',
      'priceRoleSix:name',
      'priceRoleSeven:name',
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
      'ekBrutto:name',
      'ust:name',
      'carlineNumber:name',
      'zahldatum:name',
      'placeOfIssue:name',
      'importTax:name',
      'segregator:name',
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
    return $showType ? 55 : null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 48 : 24;
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
    return $showType ? 50 : 25;
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
      {targets: [36], "className": "text-center"}, // pay4
      {targets: [47], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [49], "className": "text-center"}, // paid
      {targets: [51], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [52], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [53], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [54],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [55], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [57], "className": "text-center"}, // Pay
      {targets: [59], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [61], "className": "text-center"}, // pay5
      {targets: [69], "className": "text-center"}, // paidSuccess
      {targets: [71],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [78], "className": "text-center"}, // zahldatumPay
      {targets: [84],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [86],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [87], "className": "text-center"}, // taxReturned
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
      {targets: [36], "className": "text-center"}, // pay4
      {targets: [47], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [49], "className": "text-center"}, // paid
      {targets: [51], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [52], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [53], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [54],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [55], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [57], "className": "text-center"}, // Pay
      {targets: [59], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [61], "className": "text-center"}, // pay5
      {targets: [69], "className": "text-center"}, // paidSuccess
      {targets: [71],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [78], "className": "text-center"}, // zahldatumPay
      {targets: [84],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [86],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [87], "className": "text-center"}, // taxReturned
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 24, edit: true, name: 'paid'},
        {index: 37, edit: true, name: 'zahldatumPay'},
      ];
    } else {
      return [
        {index: 35, edit: true, name: 'pay4'},
        {index: 48, edit: true, name: 'paid'},
        {index: 56, edit: true, name: 'pay'},
        {index: 60, edit: true, name: 'pay5'},
        {index: 68, edit: true, name: 'paidSuccess'},
        {index: 77, edit: true, name: 'zahldatumPay'},
        {index: 86, edit: true, name: 'taxReturned'},
      ];
    }
  }
}
