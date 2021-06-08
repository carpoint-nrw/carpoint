import Datatable from '../Datatable.js';
import RoleOne from '../car/RoleOne.js';
import RoleTwo from '../car/RoleTwo.js';
import RoleThree from '../car/RoleThree.js';
import RoleFour from '../car/RoleFour.js';
import RoleFive from '../car/RoleFive.js';
import RoleSix from '../car/RoleSix.js';
import RoleSeven from '../car/RoleSeven.js';
import RoleEight from '../car/RoleEight.js';
import RoleNine from '../car/RoleNine.js';
import RoleTen from '../car/RoleTen.js';
import RoleEleven from '../car/RoleEleven.js';
import RoleTwelve from '../car/RoleTwelve.js';
import RoleThirteen from '../car/RoleThirteen.js';
import RoleFourTeen from '../car/RoleFourTeen.js';

/**
 * CarTable class definition.
 *
 * @module public/js/entries/car/CarTable
 */
export default class CarTable {

  constructor() {
	switch(role) {
	  case 'ROLE_ADMIN_2':
		this.roleEntity = new RoleTwo();
		break;
	  case 'ROLE_ADMIN_3':
		this.roleEntity = new RoleThree();
		break;
	  case 'ROLE_ADMIN_4':
		this.roleEntity = new RoleFour();
		break;
	  case 'ROLE_ADMIN_5':
		this.roleEntity = new RoleFive();
		break;
	  case 'ROLE_ADMIN_6':
		this.roleEntity = new RoleSix();
		break;
	  case 'ROLE_ADMIN_7':
		this.roleEntity = new RoleSeven();
		break;
	  case 'ROLE_ADMIN_8':
		this.roleEntity = new RoleEight();
		break;
	  case 'ROLE_ADMIN_9':
		this.roleEntity = new RoleNine();
		break;
	  case 'ROLE_ADMIN_10':
		this.roleEntity = new RoleTen();
		break;
	  case 'ROLE_ADMIN_11':
		this.roleEntity = new RoleEleven();
		break;
	  case 'ROLE_ADMIN_12':
		this.roleEntity = new RoleTwelve();
		break;
	  case 'ROLE_ADMIN_13':
		this.roleEntity = new RoleThirteen();
		break;
	case 'ROLE_ADMIN_14':
		this.roleEntity = new RoleFourTeen();
		break;
	  default:
		this.roleEntity = new RoleOne();
	}
  }

  /**
   * @param store
   * @param type
   *
   * @returns {jQuery}
   */
  initCarTable(store, type) {
	return $('#datatable-car').DataTable({
	  language: new Datatable().translateDefaultValues(),
	  processing: true,
	  serverSide: true,
	  pageLength: 30,
	  scrollX: true,
	  dom: 'fiptr',
	  scrollY: window.innerHeight - 203 + 'px',
	  columnDefs: userLocale === 'pl' ? this.roleEntity.polishColumnWidth() : this.roleEntity.germanColumnWidth(),
	  order: type === 'archive' ? [[0, 'desc']] : [[this.roleEntity.getCompletedColumn(), 'asc']],
	  fixedColumns:   {
		leftColumns: this.roleEntity.getFixedColumn(),
	  },
	  ajax: {
		url: ajaxData,
		type: 'POST',
		data: (d) => {
		  d.carId = store.carId;
		  d.carCondition = store.carCondition;
		  d.changeValue = store.changeValue;
		  d.changeField = store.changeField;
		  d.filters = store.filters;
		  d.columnSearch = store.columnSearch;
		  d.paramLength = store.paramLength;
		  d.addedType = store.addedType;
		  d.carIds = store.carIds;
		}
	  },
	  columns: this.roleEntity.carTableColumns(),
	  drawCallback: () => {
	    let $filters = $('.dataTables_scrollHeadInner .open .dropdown-menu');
	    if ($filters.length > 0) {
		  $.each($filters, (index, value) => {
		    let $coordinates = $(value).parent().offset();
			$(value).offset({top: $coordinates.top + 30, left: $coordinates.left})
		  });
		}

	    let $datatableScrollBody = $('.DTFC_LeftBodyLiner');
	    let $datatableScrollYPosition = $datatableScrollBody.scrollTop();
	    $datatableScrollBody.scrollTop($datatableScrollYPosition+1);
	    $datatableScrollBody.scrollTop($datatableScrollYPosition-1);
	  },
	  createdRow: (row, aData, index) => {
	    if (type === 'archive') {
	      if (aData.addedToArchiveDe !== null && aData.addedToArchivePl === null) {
			$(row).addClass(`archive-added-only-german`);
		  } else if (aData.addedToArchiveDe === null && aData.addedToArchivePl !== null) {
			$(row).addClass(`archive-added-only-polish`);
		  }
		}

		if (role !== 'ROLE_ADMIN_4') {
		  if ($.trim(aData.radioCode) === '' && aData.targetUnload === 'x') {
			$(row).find(`td:eq(${this.roleEntity.getRadioCodePosition()})`).addClass('car-table-radio-code-color');
		  }
		}
		if (aData.payColor === true) {
		  let $columnId = this.roleEntity.getPayColumn(store.showAndHideColumn);
		  if ($columnId !== null) {
			$(row).find(`td:eq(${$columnId})`).addClass('car-table-pay-color');
		  }
		}
		if (aData.paidColor === true) {
		  $(row).find(`td:eq(${this.roleEntity.getPaidColumn(store.showAndHideColumn)})`).addClass('car-table-pay-color');
		}
		if (aData.carCreatedAt === true) {
		  this.roleEntity.getCarCreatedAtColumns(store.showAndHideColumn).forEach((value) => {
			$(row).find(`td:eq(${value})`).addClass('car-created-at-color');
		  });
		}

		if (
			aData.documents !== null
			&& ($.inArray($.trim(aData.documents).toLowerCase(), ['b', 'b nur coc', 'cl']) !== -1
			|| aData.documents.toLowerCase().indexOf('wk') === 0)
		) {
			$(row).find(`td:eq(${this.roleEntity.getDocuColumn(store.showAndHideColumn)})`).addClass('car-table-docu-color-yellow');
		} else if (
			aData.targetUnload === 'x'
			&& (aData.documents === null
			|| ($.inArray($.trim(aData.documents).toLowerCase(), ['nk', 'x', 'b abgelöst']) === -1
			&& aData.documents.toLowerCase().indexOf('wyslane') < 0))
		) {
			$(row).find(`td:eq(${this.roleEntity.getDocuColumn(store.showAndHideColumn)})`).addClass('car-table-docu-color');
		}

		if (aData.carColor === true) {
		  $(row).addClass(`car-table-row-add-to-archive`);
		}

		if (aData.terminColor === true) {
		  $(row).find(`td:eq(${this.roleEntity.getTerminColumn(store.showAndHideColumn)})`).addClass('car-table-termin-color');
		}

		$(row)
		  .addClass(`car-table-row-${index}`)
		  .attr('data-id', index);
		if (aData.editDate !== null) {
		  $(row).addClass(`car-table-row-edit`);
		}

		let $checkboxes = this.roleEntity.getCheckboxes(store.showAndHideColumn);
		$checkboxes.forEach((value) => {
		  let $name = value.name;
		  let $checked = aData[$name] === true ? 'checked' : '';
		  let $disabled = value.edit ? '' : 'disabled';

		  $(row).find(`td:eq(${value.index})`)
			.text('')
			.append(`
			  <input class="car-table-checkbox-edit" type="checkbox" data-field="${value.name}" ${$disabled} ${$checked}>
			`
			);
		});

		if (role !== 'ROLE_ADMIN_4') {
		  $(row).find(`td:eq(${this.roleEntity.getCarConditionPosition()})`)
			.text('')
			.append(() => {
			  if (aData.carCondition === 'sold') {
			  	if (role === 'ROLE_ADMIN_14') {
					return this.getCarContidionSelect(aData.booking, 'disabled="disabled"','', '', 'selected="selected"', aData.id);
				}
				return this.getCarContidionSelect(aData.booking, '','', '', 'selected="selected"', aData.id);
			  } else if (aData.carCondition === 'reservation') {
				let $disabled;
				if (userLocale === 'de') {
				  $disabled = '';
				} else {
				  $disabled = Number(userId) === aData.salesmanId ? '' : 'disabled="disabled"';
				}
				return this.getCarContidionSelect(true, $disabled,'', 'selected="selected"', '', aData.id);
			  } else {
				return this.getCarContidionSelect(aData.booking, '','selected="selected"', '', '', aData.id);
			  }
			});
		}
	  },
	});
  }
  
  getShowAndHideColumns() {
    return this.roleEntity.showAndHideColumns();
  }

  getCarContidionSelect($booking, $disabled, $empty, $reservation, $sold, $id) {
	let $soldName = '';
	let $reservationName = '';
    if (userLocale === 'de') {
	  $soldName = 'VK';
	  $reservationName = 'R';
	} else {
	  $soldName = 'SP';
	  $reservationName = 'R';
	}

    let $class = '';
    if ($reservation !== '') {
      $class = 'car-yellow';
	} else if ($sold !== '') {
	  $class = 'car-red';
	}


    if ($booking === false) {
	  return `<select ${$disabled} class="car-table-condition-select condition-select-${$id} ${$class}">
			  <option ${$empty} value=""></option>
			  <option ${$sold} value="Sold">${$soldName}</option>
			</select>`;
	}
    return `<select ${$disabled} class="car-table-condition-select condition-select-${$id} ${$class}">
			  <option ${$empty}></option>
			  <option ${$reservation} value="Reservation">${$reservationName}</option>
			  <option ${$sold} value="Sold">${$soldName}</option>
			</select>`;
  }
}
