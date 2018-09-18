@extends('layouts.app')

@section('title')
Login
@endsection

@section('login')
<style>
	
</style>

<div class="container">
	<div class="centered">
		<div class="row">
			
				<img src="{{ asset('img/LOGO_miae.png') }}" alt="logo" class="img-responsive">
		
		</div>
	</div>
	
    <div class="row">
    	<div class="container">
    		<div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-6 col-md-offset-3">
                        <input id="email" type="email" class="form-control border-input" name="email" value="{{ old('email') }}" required placeholder="Email Address">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong style="color:red">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-6 col-md-offset-3">
                        <input id="password" type="password" class="form-control border-input" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} > &nbsp; Remember Me
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button type="submit" class="btn btn-primary btn-fill">
                            Login
                        </button>
                        <a class="btn btn-info" href="{{ route('register') }}">
                            &nbsp; Register
                        </a>
                        <a class="" href="{{ route('password.request') }}">
                            &nbsp; Forgot Your Password?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    	</div>
        
    </div>
</div>
@endsection
