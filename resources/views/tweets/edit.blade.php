@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit tweet</div>

                <div class="card-body">
                    <form action="{{ route('tweets.update', $tweet->id) }}" method="post">
                        @method('patch')
                        @csrf

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label for="content" class="col-form-label">Content</label>

                                <div>
                                    <input id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ old('content') ?: $tweet->plainText }}" required>

                                    @error('content')
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
