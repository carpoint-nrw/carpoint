import BaseRole from '../car/BaseRole.js';

/**
 * RoleTwelve class definition.
 *
 * @module public/js/entries/car/RoleTwelve
 */
export default class RoleTwelve {

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
	  {'name': 'demo', 'data': 'demo'},
	  {'name': 'carRegistration', 'data': 'carRegistration'},
	  {'name': 'carMileage', 'data': 'carMileage'},
	  {'name': 'ekNetto', 'data': 'ekNetto'},
	  {'name': 'ekBrutto', 'data': 'ekBrutto'},
	  {'name': 'ust', 'data': 'ust'},
	  {'name': 'invoiceNumber', 'data': 'invoiceNumber'},
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
	  'germanComplectation:name',
	  'initialPriceWithOutVat:name',
	  'initialVatPrice:name',
	  'invoiceNumber:name',
	  'paid:name',
	  'forwarder:name',
	  'orderNumber:name',
	  'sellingPrice:name',
	  'placeOfIssue:name',
	];
  }

  /**
   * @returns {number}
   */
  getFixedColumn() {
	return 9;
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
	return 17;
  }

  /**
   * @returns {number}
   */
  getPayColumn($showType) {
	return null;
  }

  /**
   * @returns {number}
   */
  getPaidColumn($showType) {
	return $showType ? 26 : null;
  }

  /**
   * @returns {number}
   */
  getTerminColumn($showType) {
	return $showType ? 16 : 12;
  }

  /**
   * @returns {number}
   */
  getDocuColumn($showType) {
	return $showType ? 27 : 19;
  }

  /**
   * @returns {array}
   */
  getCarCreatedAtColumns($showType) {
	return $showType ? [7, 8, 9, 10] : [7, 8];
  }

  /**
   * @returns {*[]}
   */
  germanColumnWidth() {
	let self = this;
	return [
	  {targets: [0], visible: false, searchable: false},
	  {targets: [1], "className": "text-center"}, // LR
	  {targets: [2],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'fhnr');
		}
	  },
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
	  {targets: [5],
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'radioCode');
		}
	  },
	  {targets: [7],
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'user', true);
		}
	  },
	  {targets: [27], "className": "text-center"}, // Paid
	  {targets: [28], "className": "text-center",
		createdCell: function (td, cellData) {
		  self.baseRole.textInput(td, cellData, 'documents', true);
		}
	  }, // Papiere
	  {targets: [31],
		createdCell: function (td, cellData, rowData) {
		  self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
		}
	  }, // targetUnload
	  {targets: [32], "className": "text-center",
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
      {targets: [1], "className": "text-center"}, // LR
      {targets: [2],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'fhnr');
        }
      },
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
      {targets: [5],
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'radioCode');
        }
      },
      {targets: [7],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'user', true);
        }
      },
      {targets: [27], "className": "text-center"}, // Paid
      {targets: [28], "className": "text-center",
        createdCell: function (td, cellData) {
          self.baseRole.textInput(td, cellData, 'documents', true);
        }
      }, // Papiere
      {targets: [31],
        createdCell: function (td, cellData, rowData) {
          self.baseRole.selectInput(td, cellData, rowData, 'targetUnload');
        }
      }, // targetUnload
      {targets: [32], "className": "text-center",
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
	  return [];
	} else {
	  return [{index: 26, edit: false, name: 'paid'}];
	}
  }
}
