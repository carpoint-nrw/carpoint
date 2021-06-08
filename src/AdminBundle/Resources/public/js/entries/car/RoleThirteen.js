import BaseRole from '../car/BaseRole.js';

/**
 * RoleOne class definition.
 *
 * @module public/js/entries/car/RoleThirteen
 */
export default class RoleThirteen {

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
	  {'name': 'location', 'data': 'location'},
	  {'name': 'orderNumber', 'data': 'orderNumber'},
	  {'name': 'information', 'data': 'information'},
	  {'name': 'sellingPrice', 'data': 'sellingPrice'},
	  {'name': 'datum', 'data': 'datum'},
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
	  'createdAt:name',
	  'uploader:name',
	  'brand:name',
	  'versionPolish:name',
	  'colorPolish:name',
	  'polishComplectation:name',
	  'germanComplectation:name',
	  'complectationPolish:name',
	  'ekBrutto:name',
	  'initialPriceWithOutVat:name',
	  'initialVatPrice:name',
	  'priceRoleFive:name',
	  'priceRoleSix:name',
	  'priceRoleSeven:name',
	  'paid:name',
	  'orderNumber:name',
	  'sellingPrice:name',
	  'placeOfIssue:name',
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
	return $showType ? null : null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
	return $showType ? 40 : null;
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
	return $showType ? 41 : 26;
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
		  self.baseRole.selectInput(td, cellData, rowData, 'user', true);
		}
	  },
	  {targets: [39], "className": "text-center",
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
		}
	  }, // Rchng.Nr.
	  {targets: [41], "className": "text-center"}, // paid
	  {targets: [42], "className": "text-center",
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'documents', true);
		}
	  }, // Papiere
	  {targets: [43], "className": "text-center"}, // Transport - downloadDate
	  {targets: [45],
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
		}
	  }, // targetUnload
	  {targets: [46], "className": "text-center",
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'location');
		}
	  }, // Standort
	  {targets: [48],
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
            self.baseRole.selectInput(td, cellData, rowData, 'user', true);
          }
        },
        {targets: [39], "className": "text-center",
          createdCell: function (td, cellData) {
            self.baseRole.textInput(td, cellData, 'invoiceNumber', true);
          }
        }, // Rchng.Nr.
        {targets: [41], "className": "text-center"}, // paid
        {targets: [42], "className": "text-center",
          createdCell: function (td, cellData) {
            self.baseRole.textInput(td, cellData, 'documents', true);
          }
        }, // Papiere
        {targets: [43], "className": "text-center"}, // Transport - downloadDate
        {targets: [45],
          createdCell: function (td, cellData, rowData) {
            self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
          }
        }, // targetUnload
        {targets: [46], "className": "text-center",
          createdCell: function (td, cellData, rowData) {
            self.baseRole.selectInput(td, cellData, rowData, 'location');
          }
        }, // Standort
        {targets: [48],
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
	  return [];
	} else {
	  return [
		{index: 40, edit: true, name: 'paid'},
	  ];
	}
  }
}
