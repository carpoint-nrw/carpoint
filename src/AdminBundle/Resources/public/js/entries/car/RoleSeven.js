import BaseRole from '../car/BaseRole.js';

/**
 * RoleSeven class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleSeven {

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
      {'name': 'priceRoleSeven', 'data': 'priceRoleSeven'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'paid', 'data': 'paid'},
      {'name': 'documents', 'data': 'documents'},
      {'name': 'downloadDate', 'data': 'downloadDate'},
      {'name': 'targetUnload', 'data': 'targetUnload'},
      {'name': 'forwarder', 'data': 'forwarder'},
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
      'colorPolish:name',
      'polishComplectation:name',
      'germanComplectation:name',
      'complectationPolish:name',
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
    return $showType ? 30 : 21;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 24 : 15;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 25 : 16;
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
      {targets: [36], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [27], "className": "text-center"}, // Transport
      {targets: [29], "className": "text-center"}, // Transport Fa
      {targets: [30], "className": "text-center"}, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [32], "className": "text-center"}, // Standort
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

      {targets: [26], "className": "text-center"}, // Papiere

      {targets: [25], "className": "text-center"}, // bezahlt
      {targets: [36], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // LR
      {targets: [3], "className": "text-center"}, // BS
      {targets: [27], "className": "text-center"}, // Transport
      {targets: [29], "className": "text-center"}, // Transport Fa
      {targets: [30], "className": "text-center"}, // Transport Preis
      {targets: [31], "className": "text-center"}, // Pay
      {targets: [32], "className": "text-center"}, // Standort
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 15, edit: false, name: 'paid'},
        {index: 21, edit: false, name: 'pay'},
        {index: 24, edit: false, name: 'paidSuccess'},
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
