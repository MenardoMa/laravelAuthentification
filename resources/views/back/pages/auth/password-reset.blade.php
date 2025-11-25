@extends('back.layout.auth-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')

@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
        </div>
        <h6 class="mb-20">Enter your new password, confirm and submit</h6>
        <form action="{{ route('admin.password_reset_handler', $token) }}" method="POST">
            <x-form-alerts></x-form-alerts>
            @csrf
            <div class="input-group custom mb-1">
                <input type="password" class="form-control form-control-lg @error('new_password') is-invalid @enderror"
                    placeholder="New Password" name="new_password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="input-group custom mb-1">
                <input type="password"
                    class="form-control form-control-lg @error('new_password_config') is-invalid @enderror"
                    placeholder="Confirm New Password" name="new_password_config">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password_config')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection