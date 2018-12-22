{{-- @extends('layouts.app') --}}
@extends('template')
@section('content')
<div class="container">
        
            
                

                <div class="form-container">
                    <h4 class="cyan-text center-align">FunTech</h4>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        
                    <div class="input-field">
                        
                   
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                            <label for="email">E-Mail Address</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>

                    
                    <div class="input-field">

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           

                           
                                <input id="password" type="password" class="form-control" name="password" required>
                                 <label for="password">Password</label>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                        
                    </div>
                       
                       

                     {{--    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group center">
                            <div >
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                               {{--  <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a> --}}
                            </div>
                        </div>
                    </form>
                </div>
          
    
</div>
@endsection
