import BaseRole from '../car/BaseRole.js';

/**
 * RoleEleven class definition.
 *
 * @module public/js/entries/car/RoleEleven
 */
export default class RoleEleven {

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
	  {'name': 'versionGerman', 'data': 'versionGerman'},
	  {'name': 'colorGerman', 'data': 'colorGerman'},
	  {'name': 'germanComplectation', 'data': 'germanComplectation'},
	  {'name': 'complectationGerman', 'data': 'complectationGerman'},
	  {'name': 'completed', 'data': 'completed'},
	  {'name': 'initialPriceWithOutVat', 'data': 'initialPriceWithOutVat'},
	  {'name': 'initialVatPrice', 'data': 'initialVatPrice'},
	  {'name': 'discount', 'data': 'discount'},
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
	  {'name': 'location', 'data': 'location'},
	  {'name': 'preisTr', 'data': 'preisTr'},
	  {'name': 'pay5', 'data': 'pay5'},
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
	  {'name': 'gewinn', 'data': 'gewinn'},
      {'name': 'zahldatumPay', 'data': 'zahldatumPay'},
      {'name': 'zahldatum', 'data': 'zahldatum'},
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
	  'createdAt:name',
	  'uploader:name',
	  'brand:name',
	  'germanComplectation:name',
	  'initialPriceWithOutVat:name',
	  'initialVatPrice:name',
	  'discount:name',
	  'invoiceNumber:name',
	  'paymentDate:name',
	  'paid:name',
      'ankauf:name',
	  'nrPro2:name',
	  'dataPro2:name',
	  'salesInvoiceNumber:name',
	  'dataFv2:name',
	  'paidSuccess:name',
	  'invoiceDate:name',
      'zahldatum:name',
	  'placeOfIssue:name',
	];
  }

  /**
   * @returns {number}
   */
  getFixedColumn() {
	return 10;
  }

  /**
   * @returns {number}
   */
  getRadioCodePosition() {
	return 5;
  }

  /**
   * @returns {number}
   */
  getCarConditionPosition() {
	return 6;
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
	return $showType ? null : null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
	return $showType ? 29 : null;
  }

  /**
   * @returns {number}
   */
  getTerminColumn($showType) {
	return $showType ? 17 : 13;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
	return $showType ? 31 : 20;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
	return $showType ? [8, 9, 10, 11] : [8, 9];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
	let self = this;
	return [
	  {targets: [0], visible: false, searchable: false},
	  {targets: [1], "className": "text-center"}, // LR
	  {targets: [2], "className": "text-center"}, // BS
	  {targets: [3],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'fhnr');
		}
	  },
	  {targets: [4],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'discharge');
		}
	  },
	  {targets: [5],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'client');
		}
	  },
	  {targets: [6],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'radioCode');
		}
	  },
	  {targets: [8],
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'user', true);
		}
	  },
      {targets: [28], "className": "text-center",
          createdCell: function (td, cellData) {
              self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
          }
      }, // Rchng.Nr.
	  {targets: [30], "className": "text-center"}, // Paid
	  {targets: [32], "className": "text-center",
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'documents', true);
		}
	  }, // Papiere
	  {targets: [35],
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
		}
	  }, // targetUnload
	  {targets: [36], "className": "text-center",
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'location');
		}
	  }, // Standort
	  {targets: [38], "className": "text-center"}, // pay5
	  {targets: [43], "className": "text-center"}, // paidSuccess
      {targets: [50], "className": "text-center"}, // zahldatumPay
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
      {targets: [2], "className": "text-center"}, // BS
      {targets: [3],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'fhnr');
        }
      },
      {targets: [4],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'discharge');
        }
      },
      {targets: [5],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'client');
        }
      },
      {targets: [6],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [8],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user', true);
        }
      },
      {targets: [28], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
        }
      }, // Rchng.Nr.
      {targets: [30], "className": "text-center"}, // Paid
      {targets: [32], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [35],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [36], "className": "text-center",
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'location');
        }
      }, // Standort
      {targets: [38], "className": "text-center"}, // pay5
      {targets: [43], "className": "text-center"}, // paidSuccess
      {targets: [50], "className": "text-center"}, // zahldatumPay
    ];
  }

  /**
   * @returns {*[]}
   */
  getCheckboxes($type) {
	if (!$type) {
	  return [
		{index: 26, edit: true, name: 'pay5'},
        {index: 32, edit: true, name: 'zahldatumPay'},
	  ];
	} else {
	  return [
		{index: 29, edit: true, name: 'paid'},
		{index: 37, edit: true, name: 'pay5'},
		{index: 42, edit: true, name: 'paidSuccess'},
        {index: 49, edit: true, name: 'zahldatumPay'},
	  ];
	}
  }
}
