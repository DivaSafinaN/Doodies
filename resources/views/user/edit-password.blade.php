@extends('index')
@section('title',  'Edit Password')
@section('content')
<link rel="stylesheet" href={{ asset("fonts/material-icon/css/material-design-iconic-font.css") }}>
<link rel="stylesheet" href={{ asset("css/style_edit.css") }}>

{{-- <div class="wrapper" style="margin-top: 40px">
    <div style="width: 60px;margin-left: 200px;margin-bottom: -90px;">
        <a href="{{ URL::previous() }}" style="text-decoration: none; color: black;
            background: #d3f369; border-radius: 50%; display: flex; 
            justify-content: center;align-items: center; outline: none;">
            <i class='bx bx-arrow-back' style="font-size: 22px; padding: 18px 0"></i>
        </a>
    </div> --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-body my-5">
                    <h3 class="form-title"><strong>Change Password</strong></h3>
                    <form method="POST" id="login-form" action="{{ route('update-password') }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="current_password" id="current_password" placeholder="Current Password"
                            required autocomplete="current_password"/>
                            @error('current_password')
                            <div style="color: #dc3545">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-key"></i></label>
                            <input type="password" name="password" id="password" placeholder="New Password"
                            required autocomplete="password"/>
                            @error('password')
                            <div style="color: #dc3545">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm"><i class="zmdi zmdi-key"></i></label>
                            <input id="password-confirm" type="password" placeholder="Confirm Password"
                            name="password_confirmation" required autocomplete="new-password">
                        </div>
                        
                        <div class="mt-5">
                            <button type="submit" class="btn edit-user" style="background: #d3f369; 
                            box-shadow: 0px 0px 10px rgba(0,0,0,0.05);
                            height: 40px;
                            width: 100px;
                            border: #e5e5e5;">
                                {{ __('Save') }}
                            </button>
                    </div>
                    </form>
                </div>
                {{-- <div class="card">
                    <div class="card-header">{{ __('Edit Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('update-password') }}">
                            @csrf
                            @method('put')
                            <div class="row mb-3">
                                <label for="current_password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                    name="current_password" required autocomplete="current_password">

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection

@section('javascript')
<script>
    @if(session()->has('message'))
        Swal.fire(
        'Success!',
        'Password has been updated',
        'success'
        )
    @endif
</script>
@endsection