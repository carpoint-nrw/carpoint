/**
 * RoleFour class definition.
 *
 * @module public/js/entries/car/RoleOne
 */
export default class RoleFour {

  /**
   * @returns {*[]}
   */
  carTableColumns() {
    return [
      {'name': 'id', 'data': 'id'},
      {'name': 'vendor', 'data': 'vendor'},
      {'name': 'customer', 'data': 'customer'},
      {'name': 'user', 'data': 'user'},
      {'name': 'vinNumber', 'data': 'vinNumber'},
      {'name': 'brand', 'data': 'brand'},
      {'name': 'model', 'data': 'model'},
      {'name': 'versionPolish', 'data': 'versionPolish'},
      {'name': 'versionGerman', 'data': 'versionGerman'},
      {'name': 'completed', 'data': 'completed'},
      {'name': 'ourDiscountPrice', 'data': 'ourDiscountPrice'},
      {'name': 'initialPriceWithOutVat', 'data': 'initialPriceWithOutVat'},
      {'name': 'initialVatPrice', 'data': 'initialVatPrice'},
      {'name': 'discount', 'data': 'discount'},
      {'name': 'carRegistration', 'data': 'carRegistration'},
      {'name': 'carMileage', 'data': 'carMileage'},
      {'name': 'invoiceNumber', 'data': 'invoiceNumber'},
      {'name': 'paid', 'data': 'paid'},
      {'name': 'shippingCost', 'data': 'shippingCost'},
      {'name': 'transportInvoiceNumber', 'data': 'transportInvoiceNumber'},
      {'name': 'pay', 'data': 'pay'},
      {'name': 'orderNumber', 'data': 'orderNumber'},
      {'name': 'salePriceWithOutVAT', 'data': 'salePriceWithOutVAT'},
      {'name': 'salePriceWithVAT', 'data': 'salePriceWithVAT'},
      {'name': 'salesInvoiceNumber', 'data': 'salesInvoiceNumber'},
      {'name': 'paidSuccess', 'data': 'paidSuccess'},
      {'name': 'invoiceDate', 'data': 'invoiceDate'},
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
    return 5;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
    return 0;
  }

  /**
   * @returns {number}
   */
  getCompletedColumn() {
    return 9;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
    return $showType ? 19 : 15;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
    return $showType ? 16 : 12;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
    return $showType ? [3, 4, 5] : [3, 4];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [30], "className": "text-center"}, // Ak. erdg.

      {targets: [16], "className": "text-center"}, // Rchng.Nr.

      {targets: [17], "className": "text-center"}, // bezahlt
      {targets: [25], "className": "text-center"}, // bezahlt

      {targets: [1], "className": "text-center"}, // LR
      {targets: [2], "className": "text-center"}, // BS
      {targets: [18], "className": "text-center"}, // Transport Preis
      {targets: [19], "className": "text-center"}, // Rchng t
      {targets: [20], "className": "text-center"}, // Pay
      {targets: [24], "className": "text-center"}, // Rhng nr
    ];
  }

  /**
   * @returns {*[]}
   */
  polishColumnWidth() {
    return [
      {targets: [0], visible: false, searchable: false},
      {targets: [16], "className": "text-center"}, // fv zakupu
      {targets: [30], "className": "text-center"}, // ak.końc.

      {targets: [17], "className": "text-center"}, // zaplsacone
      {targets: [25], "className": "text-center"}, // zaplacona

      {targets: [1], "className": "text-center"}, // LR
      {targets: [2], "className": "text-center"}, // BS
      {targets: [18], "className": "text-center"}, // Transport Preis
      {targets: [20], "className": "text-center"}, // Pay
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
    if (!$type) {
      return [
        {index: 12, edit: false, name: 'paid'},
        {index: 15, edit: false, name: 'pay'},
        {index: 18, edit: false, name: 'paidSuccess'},
        {index: 23, edit: false, name: 'taxReturned'},
      ];
    } else {
      return [
        {index: 16, edit: false, name: 'paid'},
        {index: 19, edit: false, name: 'pay'},
        {index: 24, edit: false, name: 'paidSuccess'},
        {index: 29, edit: false, name: 'taxReturned'},
      ];
    }
  }
}
