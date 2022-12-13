@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit profile</div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="post">
                        @method('patch')
                        @csrf

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label for="username" class="col-form-label">Username</label>

                                <div>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?: $user->username }}" required autofocus>

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="name" class="col-form-label">Name</label>

                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?: $user->name }}" required autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-3">
                                <label class="col-form-label">Profile visibility</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_public" value="1" id="is_public_0" @if($user->is_public) checked @endif>
                                    <label class="form-check-label" for="is_public_0">
                                        Public profile
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_public" value="0" id="is_public_1" @if(!$user->is_public) checked @endif>
                                    <label class="form-check-label" for="is_public_1">
                                        Private profile
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="text-muted">
                                Leave password fields empty if you don't want to change password
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="password" class="col-form-label">Password</label>

                                <div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="password_confirmation" class="col-form-label">Confirm Password</label>

                                <div>
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">

                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
