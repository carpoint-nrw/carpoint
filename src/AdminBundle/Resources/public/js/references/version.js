$(() => {
	let $brand = $('#version_brand');
	let $model = $('#version_model');

	if (formType === 'new') {
		getModel();
	} else {
		let $selected = $model.val();
		getModel(false);
		$model.val($selected);
	}

	$brand.change(() => {
		getModel();
	});

	function getModel($async = true) {
		$model.empty();
		$.ajax({
			method: 'GET',
			url: ajaxGetModel,
			data: {'brand': $brand.val()},
			async: $async,
		})
			.done((data) => {
				data.forEach((value) => {
					let $option = new Option(value.title, value.id, false, false);
					$model.append($option);
				});
			})
			.fail(() => {
				console.log('fail');
			});
	}
});