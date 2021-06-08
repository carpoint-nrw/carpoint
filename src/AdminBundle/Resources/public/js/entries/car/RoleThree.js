import BaseRole from '../car/BaseRole.js';

/**
 * RoleThree class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleThree {

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
      {'name': 'brand', 'data': 'brand'},
      {'name': 'model', 'data': 'model'},
      {'name': 'versionPolish', 'data': 'versionPolish'},
      {'name': 'versionGerman', 'data': 'versionGerman'},
      {'name': 'colorPolish', 'data': 'colorPolish'},
      {'name': 'polishComplectation', 'data': 'polishComplectation'},
      {'name': 'complectationPolish', 'data': 'complectationPolish'},
      {'name': 'completed', 'data': 'completed'},
      {'name': 'ourDiscountPrice', 'data': 'ourDiscountPrice'},
      {'name': 'initialPriceWithOutVat', 'data': 'initialPriceWithOutVat'},
      {'name': 'initialVatPrice', 'data': 'initialVatPrice'},
      {'name': 'discount', 'data': 'discount'},
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
      {'name': 'orderNumber', 'data': 'orderNumber'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'salePriceWithVAT', 'data': 'salePriceWithVAT'},
      {'name': 'salesInvoiceNumber', 'data': 'salesInvoiceNumber'},
      {'name': 'paidSuccess', 'data': 'paidSuccess'},
      {'name': 'invoiceDate', 'data': 'invoiceDate'},
      {'name': 'information', 'data': 'information'},
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
      'brand:name',
      'polishComplectation:name',
      'discount:name',
      'orderNumber:name',
      'salesInvoiceNumber:name',
      'invoiceDate:name',
      'declaration:name',
      'importTax:name',
      'taxNumber:name',
      'taxReturned:name',
      'paidSuccess:name',
      'initialPriceWithOutVat:name',
      'initialVatPrice:name',
      'carMileage:name',
      'salePriceWithOutVAT:name',
      'salePriceWithVAT:name',
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
    return 15;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? 30 : 24;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 23 : 17;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 24 : 18;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
    return $showType ? [6, 7, 8] : [6, 7];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [38],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [41],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // Akcysa Nr.
      {targets: [42], "className": "text-center"}, // Ak. erdg.

      {targets: [22], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [25], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere

      {targets: [24], "className": "text-center"}, // bezahlt
      {targets: [36], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [26], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [27], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [29], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [39],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'declaration');
        }
      }, // CRM
      {targets: [40],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [28],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
    ];
  }

  /**
   * @returns {*[]}
   */
  polishColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [38],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user');
        }
      },
      {targets: [22], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // fv zakupu
      {targets: [25], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // dokumenty
      {targets: [41],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'taxNumber');
        }
      }, // nr. akcyzy
      {targets: [42], "className": "text-center"}, // ak.końc.

      {targets: [24], "className": "text-center"}, // zaplsacone
      {targets: [36], "className": "text-center"}, // zaplacona

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [26], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'downloadDate', true);
        }
      }, // Transport
      {targets: [27], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [29], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [39],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'declaration');
        }
      }, // CRM
      {targets: [40],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'importTax');
        }
      }, // CRM
      {targets: [28],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 17, edit: true, name: 'paid'},
        {index: 24, edit: true, name: 'pay'},
      ];
    } else {
      return [
        {index: 23, edit: true, name: 'paid'},
        {index: 30, edit: true, name: 'pay'},
        {index: 35, edit: true, name: 'paidSuccess'},
        {index: 41, edit: true, name: 'taxReturned'},
      ];
    }
  }
}
