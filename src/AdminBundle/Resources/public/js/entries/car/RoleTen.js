import BaseRole from '../car/BaseRole.js';

/**
 * RoleTen class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleTen {

  constructor() {
    this.baseRole = new BaseRole();
  }

  /**
   * @returns {*[]}
   */
  carTableColumns() {
    return [
      {'name': 'id', 'data': 'id'},
      {'name': 'customer', 'data': 'customer'},
      {'name': 'fhnr', 'data': 'fhnr'},
      {'name': 'discharge', 'data': 'discharge'},
      {'name': 'client', 'data': 'client'},
      {'name': 'radioCode', 'data': 'radioCode'},
      {'name': 'carCondition', 'data': 'carCondition'},
      {'name': 'vinNumber', 'data': 'vinNumber'},
      {'name': 'brand', 'data': 'brand'},
      {'name': 'model', 'data': 'model'},
      {'name': 'versionPolish', 'data': 'versionPolish'},
      {'name': 'versionGerman', 'data': 'versionGerman'},
      {'name': 'colorGerman', 'data': 'colorGerman'},
      {'name': 'germanComplectation', 'data': 'germanComplectation'},
      {'name': 'complectationGerman', 'data': 'complectationGerman'},
      {'name': 'completed', 'data': 'completed'},
      {'name': 'ourDiscountPrice', 'data': 'ourDiscountPrice'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'paid', 'data': 'paid'},
      {'name': 'documents', 'data': 'documents'},
      {'name': 'downloadDate', 'data': 'downloadDate'},
      {'name': 'shippingCost', 'data': 'shippingCost'},
      {'name': 'transportInvoiceNumber', 'data': 'transportInvoiceNumber'},
      {'name': 'pay', 'data': 'pay'},
      {'name': 'location', 'data': 'location'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'salePriceWithVAT', 'data': 'salePriceWithVAT'},
      {'name': 'information', 'data': 'information'},
      {'name': 'sellingPrice', 'data': 'sellingPrice'},
      {'name': 'seller', 'data': 'seller'},
      {'name': 'additionalWork', 'data': 'additionalWork'},
      {'name': 'notes', 'data': 'notes'},
      {'name': 'date', 'data': 'date'},
      {'name': 'placeOfIssue', 'data': 'placeOfIssue'},
    ];
  }

  /**
   * @returns {[]}
   */
  showAndHideColumns() {
    return [
      'brand:name',
      'germanComplectation:name',
      'sellingPrice:name',
      'seller:name',
      'additionalWork:name',
      'notes:name',
      'date:name',
      'placeOfIssue:name',
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
    return 4;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
    return 5;
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
    return $showType ? 23 : 20;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 18 : 15;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 19 : 16;
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
      {targets: [3],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'discharge');
        }
      },
      {targets: [4],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'client');
        }
      },
      {targets: [28],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },

      {targets: [20], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere

      {targets: [19], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // BS
      {targets: [21], "className": "text-center"}, // Transport
      {targets: [22], "className": "text-center"}, // Transport Preis
      {targets: [24], "className": "text-center"}, // Pay
      {targets: [25], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
    ];
  }

  /**
   * @returns {*[]}
   */
  polishColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [3],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'discharge');
        }
      },
      {targets: [4],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'client');
        }
      },
      {targets: [28],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
      {targets: [20], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // dokumenty

      {targets: [19], "className": "text-center"}, // zaplsacone

      {targets: [1], "className": "text-center"}, // BS
      {targets: [21], "className": "text-center"}, // Transport
      {targets: [22], "className": "text-center"}, // Transport Preis
      {targets: [24], "className": "text-center"}, // Pay
      {targets: [25], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 15, edit: true, name: 'paid'},
        {index: 20, edit: true, name: 'pay'},
      ];
    } else {
      return [
        {index: 18, edit: true, name: 'paid'},
        {index: 23, edit: true, name: 'pay'},
      ];
    }
  }
}
