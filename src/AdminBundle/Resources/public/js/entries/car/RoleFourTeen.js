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
      {'name': 'priceRoleFive', 'data': 'priceRoleFive'},
      {'name': 'priceRoleSix', 'data': 'priceRoleSix'},
      {'name': 'priceRoleSeven', 'data': 'priceRoleSeven'},
      {'name': 'demo', 'data': 'demo'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'documents', 'data': 'documents'},
      {'name': 'downloadDate', 'data': 'downloadDate'},
      {'name': 'forwarder', 'data': 'forwarder'},
      {'name': 'targetUnload', 'data': 'targetUnload'},
      {'name': 'shippingCost', 'data': 'shippingCost'},
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
      {'name': 'carlineDate', 'data': 'carlineDate'},
      {'name': 'carlineNumber', 'data': 'carlineNumber'},
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
      'initialVatPrice:name',
      'vat:name',
      'shippingCost:name',
      'orderNumber:name',
      'salePriceWithVAT:name',
      'location:name',
      'invoiceDate:name',
    ];
  }

  /**
   * @returns {number}
   */
  getFixedColumn() {
    return 5;
  }

  /**
   * @returns {number}
   */
  getRadioCodePosition() {
    return 0;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
    return 1;
  }

  /**
   * @returns {number}
   */
  getCompletedColumn() {
    return 17;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? null : null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? null : null;
  }

  /**
   * @returns {number}
   */
  getTerminColumn($showType) {
    return $showType ? 16 : 8;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
    return $showType ? 31 : 19;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
    return $showType ? [3, 4, 5, 6] : [3, 4];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [35],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [36], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [45], "className": "text-center"}, // paidSuccess
      {targets: [47],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
    ];
  }

  /**
   * @returns {*[]}
   */
  polishColumnWidth() {
    let self = this;
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [35],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [36], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'shippingCost', true);
        }
      }, // Transport Preis
      {targets: [45], "className": "text-center"}, // paidSuccess
      {targets: [47],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'information');
        }
      },
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 28, edit: false, name: 'paidSuccess'},
      ];
    } else {
      return [
        {index: 44, edit: false, name: 'paidSuccess'},
      ];
    }
  }
}
