$(() => {
	let $brand = $('#brand');
	let $model = $('#model');
	let $version = $('#version');

	if (formType === 'new') {
		getModel(true);
		getVersion();
	} else {
		let $selectedModel = $model.val();
		let $selectedVersion = $version.val();
		getModel(false, false);
		getVersion(false, $selectedModel);
		$model.val($selectedModel);
		$version.val($selectedVersion);
	}

	$model.change(() => {
		getVersion();
	});
	$brand.change(() => {
		getModel(true);
		getVersion();
	});

	function getModel($all = false, $async = true) {
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
				if ($all) {
					getVersion();
				}
			})
			.fail(() => {
				console.log('fail');
			});
	}

	function getVersion($async = true, $currentModel = null) {
		$version.empty();
		$.ajax({
			method: 'GET',
			url: ajaxGetVersion,
			data: {'model': $currentModel === null ? $model.val() : $currentModel},
			async: $async,
		})
			.done((data) => {
				data.forEach((value) => {
					let $option = new Option(value.german, value.id, false, false);
					$version.append($option);
				});
			})
			.fail(() => {
				console.log('fail');
			});
	}
});