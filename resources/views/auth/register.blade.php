@extends('elite')
@section('title')
    Регистрация|@parent
@stop
@section('content')
<h2 class="white">Регистрация на сайте</h2>
			<div class="panel-elite">
				<div class="panel-heading">Введите даные для регистрации</div>
				<div class="panel-body">
					@if (count($errors) > 0)
                        @include('errors.display')
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Ник</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Пароль</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Повторите пароль</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-warning">
									Зарегистрироваться
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

@endsection
