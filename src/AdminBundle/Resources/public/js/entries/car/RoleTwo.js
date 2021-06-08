import BaseRole from '../car/BaseRole.js';

/**
 * RoleTwo class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleTwo {

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
      {'name': 'seller', 'data': 'seller'},
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
      'complectationGerman:name',
      'ourDiscountPrice:name',
      'vat:name',
      'nrPro:name',
      'dataPro:name',
      'priceRoleFive:name',
      'priceRoleSix:name',
      'priceRoleSeven:name',
      'demo:name',
      'carRegistration:name',
      'carMileage:name',
      'orderNumber:name',
      'salePriceWithVAT:name',
      'taxReturned:name',
    ];
  }

  /**
   * @returns {number}
   */
  getFixedColumn() {
    return 8;
  }

  /**
   * @returns {number}
   */
  getRadioCodePosition() {
    return 3;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
    return 4;
  }

  /**
   * @returns {number}
   */
  getCompletedColumn() {
    return 20;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? 49 : 31;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 42 : 24;
  }

  /**
   * @returns {number}
   */
  getTerminColumn($showType) {
    return $showType ? 19 : 11;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 43 : 25;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
    return $showType ? [6, 7, 8, 9] : [6, 7];
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
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [33], "className": "text-center"}, // pay4
      {targets: [41], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [43], "className": "text-center"}, // paid
      {targets: [44], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [45], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [46], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [47],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [48], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [50], "className": "text-center"}, // Pay
      {targets: [52], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [60], "className": "text-center"}, // paidSuccess
      {targets: [62],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [64],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [65],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'segregator');
        }
      }, // segregator
      {targets: [66],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [67], "className": "text-center"}, // taxReturned
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
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [33], "className": "text-center"}, // pay4
      {targets: [41], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [43], "className": "text-center"}, // paid
      {targets: [44], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [45], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [46], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [47],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [48], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [50], "className": "text-center"}, // Pay
      {targets: [52], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [60], "className": "text-center"}, // paidSuccess
      {targets: [62],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [64],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [65],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'segregator');
        }
      }, // segregator
      {targets: [66],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [67], "className": "text-center"}, // taxReturned
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 20, edit: true, name: 'pay4'},
        {index: 24, edit: true, name: 'paid'},
        {index: 31, edit: true, name: 'pay'},
        {index: 39, edit: true, name: 'paidSuccess'},
      ];
    } else {
      return [
        {index: 32, edit: true, name: 'pay4'},
        {index: 42, edit: true, name: 'paid'},
        {index: 49, edit: true, name: 'pay'},
        {index: 59, edit: true, name: 'paidSuccess'},
        {index: 66, edit: true, name: 'taxReturned'},
      ];
    }
  }
}
