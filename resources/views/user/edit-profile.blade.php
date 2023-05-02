@extends('index')
@section('title',  'Edit Profile')
@section('content')
<link rel="stylesheet" href={{ asset("fonts/material-icon/css/material-design-iconic-font.css") }}>
<link rel="stylesheet" href={{ asset("css/style_edit.css") }}>
@if(session()->has('message'))
<div class="d-flex justify-content-center">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
</div>
@endif
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
                            <button type="submit" class="btn edit-user" style="background: hsl(73, 99%, 73%); 
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
@endsection