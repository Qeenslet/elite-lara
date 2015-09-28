@extends('elite')
@section('title')
    Sign in|@parent
@stop
@section('content')

			<div class="panel-elite">
				<div class="panel-heading">Sign in</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						@include('errors.display')
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Your email</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                                <div class="elite-checkbox">
                                    <input type="checkbox" name="remember" id="remMe">
                                    <label for="remMe">remember me</label>
                                </div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Sign in</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot your password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>

@endsection
