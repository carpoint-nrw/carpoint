import BaseRole from '../car/BaseRole.js';

/**
 * RoleFive class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleFive {

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
      {'name': 'colorGerman', 'data': 'colorGerman'},
      {'name': 'polishComplectation', 'data': 'polishComplectation'},
      {'name': 'germanComplectation', 'data': 'germanComplectation'},
      {'name': 'complectationPolish', 'data': 'complectationPolish'},
      {'name': 'complectationGerman', 'data': 'complectationGerman'},
      {'name': 'completed', 'data': 'completed'},
      {'name': 'initialPriceWithOutVat', 'data': 'initialPriceWithOutVat'},
      {'name': 'initialVatPrice', 'data': 'initialVatPrice'},
      {'name': 'minimumSellingPrice', 'data': 'minimumSellingPrice'},
      {'name': 'priceRoleFive', 'data': 'priceRoleFive'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'paid', 'data': 'paid'},
      {'name': 'documents', 'data': 'documents'},
      {'name': 'downloadDate', 'data': 'downloadDate'},
      {'name': 'forwarder', 'data': 'forwarder'},
      {'name': 'targetUnload', 'data': 'targetUnload'},
      {'name': 'shippingCost', 'data': 'shippingCost'},
      {'name': 'pay', 'data': 'pay'},
      {'name': 'location', 'data': 'location'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'salePriceWithVAT', 'data': 'salePriceWithVAT'},
      {'name': 'salesInvoiceNumber', 'data': 'salesInvoiceNumber'},
      {'name': 'paidSuccess', 'data': 'paidSuccess'},
      {'name': 'invoiceDate', 'data': 'invoiceDate'},
      {'name': 'information', 'data': 'information'},
      {'name': 'declaration', 'data': 'declaration'},
    ];
  }

  /**
   * @returns {[]}
   */
  showAndHideColumns() {
    return [
      'brand:name',
      'polishComplectation:name',
      'germanComplectation:name',
      'initialPriceWithOutVat:name',
      'initialVatPrice:name',
      'minimumSellingPrice:name',
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
    return 18;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? 30 : 23;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 24 : 17;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 25 : 18;
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

      {targets: [26], "className": "text-center"}, // Papiere

      {targets: [25], "className": "text-center"}, // bezahlt
      {targets: [35], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [27], "className": "text-center"}, // Transport
      {targets: [28], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // Transport Fa
      {targets: [30], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [32], "className": "text-center"}, // Standort
      {targets: [29],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [36], "className": "text-center"}, // zaplacona
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
      {targets: [26], "className": "text-center"}, // dokumenty
      {targets: [28], width: '85px', "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'forwarder');
        }
      }, // firma transp.
      {targets: [30],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // cena transp.

      {targets: [25], "className": "text-center"}, // zaplsacone
      {targets: [36], "className": "text-center"}, // zaplacona

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [27], "className": "text-center"}, // Transport
      {targets: [29], "className": "text-center"}, // Transport Fa
      {targets: [30], "className": "text-center"}, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [32], "className": "text-center"}, // Standort
      {targets: [29],
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
        {index: 17, edit: false, name: 'paid'},
        {index: 23, edit: false, name: 'pay'},
        {index: 26, edit: false, name: 'paidSuccess'},
      ];
    } else {
      return [
        {index: 24, edit: false, name: 'paid'},
        {index: 30, edit: false, name: 'pay'},
        {index: 35, edit: false, name: 'paidSuccess'},
      ];
    }
  }
}
