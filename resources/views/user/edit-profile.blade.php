@extends('index')
@section('title',  'Edit Profile')
@section('content')
<link rel="stylesheet" href={{ asset("fonts/material-icon/css/material-design-iconic-font.css") }}>
<link rel="stylesheet" href={{ asset("css/style_edit.css") }}>

{{-- <div class="wrapper" style="margin-top: 40px"> --}}
    {{-- <div style="width: 60px;margin-left: 200px;margin-bottom: -90px;">
            <a href="{{ URL::previous() }}" style="text-decoration: none; color: black;
                background: #d3f369; border-radius: 50%; display: flex; 
                justify-content: center;align-items: center; outline: none;">
                <i class='bx bx-arrow-back' style="font-size: 22px; padding: 18px 0"></i>
            </a>
    </div> --}}

    <div class="container" style="width: 700px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="my-5">
                    <h3 class="form-title"><strong>Edit Profile</strong></h3>
                    <form method="POST" id="login-form" action="{{ route('update-profile') }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account"></i></label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                            required autocomplete="name"/>
                            @error('name')
                            <div style="color: #dc3545">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-email"></i></label>
                            <input type="text" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                            required autocomplete="email"/>
                            @error('email')
                            <div style="color: #dc3545">{{ $message }}</div>
                            @enderror
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
                    <div class="card-header">{{ __('Edit Profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('update-profile') }}">
                            @csrf
                            @method('put')
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name', Auth::user()->name) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
                                    value="{{ old('email', Auth::user()->email) }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
        'Profile has been updated',
        'success'
        )
    @endif
</script>
@endsection