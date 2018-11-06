<!doctype html>
<html lang="en" style="height: 100%">
	<head>
		<!-- Required meta tags -->
		<meta name="csrf-token" content="{{ Session::token() }}">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		{{-- seletize CSS --}}
		<link rel="stylesheet" href="/lib/css/selectize.default.css">
		<link rel="stylesheet" href="/css/app.css">
		<title>Migração de bases</title>
	</head>
	<body style="height:100%">
		<div class="d-flex align-items-center justify-content-center " style="height:100%">

			<div class="teste">
				<div class="text-center">
					<h1>Bem-vindo!</h1>
					<p class="text-justify">
						Nesta ferramenta você poderá copiar a base de dados do Cidade Saudável para o servidor local.

						Escolha as cidades e a data de backup para migrar para o servidor http:// 10.0.0.12 .
					</p>
					<div class="alert alert-warning text-left" role="alert">
						Ex:<br>
						Cidade escolhida : esus-sume-pb <br>
						Data : 30/10/2018.
					</div>
				</div>

				<form method="POST" id="migration-form">
					
					<div class="form-group">
						<label for="date-select">Data</label>
						<div class="input-group">
							<select class="custom-select" id="date-select" aria-label="Example select with button addon" name="bases" required>
								<option selected disabled>Escolha a data do backup</option>
								@foreach ($dates as $key => $date)
									<option value="{{ $bases[$key] }}:{{ $date }}">{{ date('d/m/Y',strtotime($date)) }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<label for="cities-select">Cidades</label>
					<div class="form-group">
						<select name="cities[]" id="cities-select" multiple required aria-placeholder="">
							
						</select>
					</div>
					<div class="form-group d-flex justify-content-center" id="loading">
						<button type="submit" class="btn btn-primary btn-lg btn-block">Copiar</button>
					</div>
					<div class="text-center" id="response"></div>
				</form>

			</div>
			
			
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
		{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> --}}
		{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> --}}

		<script src="/lib/js/jquery.min.js"></script>
		<script src="/lib/js/selectize.min.js"></script>
		<script src="/lib/js/axios.min.js"></script>
		<script src="/js/controller.js"></script>
		{{-- <script src="/js/all.js"></script> --}}
	</body>
</html>