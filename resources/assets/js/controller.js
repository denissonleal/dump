// // $('#select-beast').selectize();

$(function () {
	// console.log("opa", $('#cities-select'));
	
	var select = $('#cities-select').selectize({
		create:true,
		placeholder:'Escolha as cidades a serem adicionadas',
		
	})[0].selectize;
	// console.log(select);
	// select.addOption({value:'t', text:'testando'});
	$("#migration-form").submit(function (event) {
		event.preventDefault();
		$("#loading").html(`
			<div class="square"></div>
		`);
		// console.log($("select[name$='cities[]']").val());
		$.post('/upload/script',
		{
			'_token': $('meta[name=csrf-token]').attr('content'),
			cities: $("select[name$='cities[]']").val(),
			bases: $("select[name$='bases']").val()
		})
		.done(
			function (response) {
				console.log(response);
				if (response ==  'true'){
					$('#migration-form').trigger('reset');
					$("#cities-select")[0].selectize.clear();
					$("#loading").html(`
						<button type="submit" class="btn btn-primary btn-lg btn-block">Copiar</button>
					`);
					$('#response').html(`
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<strong>Operação finalizada!</strong> Verifique o servidor local.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					`);
				}
			}
		);
		
	});

	$("#date-select").change(function (event) {
		event.preventDefault();
		date = $(this).val();
		console.log(date);
		$.post('/upload/bases',
		{
			date : date,
		})
		.done(
			function (response) {
				for (var i in response.cities) {
					select.addOption({ value: response.cities[i], text: response.cities[i] });
				}
			}
		);
	});
});