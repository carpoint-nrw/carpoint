/**
 * BaseRole class definition.
 *
 * @module public/js/entries/car/BaseRole
 */
export default class BaseRole {

  textInput(td, cellData, name, center = false) {
	let $data = cellData === null ? '' : cellData;
	$(td).empty().append(
	  `<input class="car-table-text-input-edit ${center === true ? 'car-table-text-center' : ''}" type="text" value="${$data}" data-field="${name}">`
	);
  }

  selectInput(td, cellData, rowData, name, disabled = false) {
	disabled = disabled ? 'disabled="disabled"' : '';
	let $data = cellData === null ? '' : cellData;
	let rowDataName = name + 'Data';
	let $select = $(`<select class="select-input-change" data-select-type="${name}" ${disabled}>
                <option value=""></option>
            </select>`);

	$.each(rowData[rowDataName], (index, value) => {
	  let $selected = false;
	  if ($data === value.title) {
		$selected = true;
	  }
	  let $option = new Option(value.title, value.id, $selected, $selected);
	  $select.append($option);
	});

	$(td).empty().append($select);
  }
}
