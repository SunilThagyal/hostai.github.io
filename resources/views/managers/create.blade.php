@extends('layouts.admin')
@section('title', 'Add '.get_manager_type())

@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert />
                            <div class="card-header">
                                <h4>Add Manager</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.managers.index' , ['type'=>Request::route('type')]) }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="manager" action="{{ route($authUser->role . '.managers.store', ['type'=>Request::route('type')] ) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name<code>*</code></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Email <code>*</code> </label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password <code>*</code> </label>
                                        <input type="password" name="password" id="cpassword" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password <code>*</code> </label>
                                        <input type="password" name="confirm_password" class="form-control" value="{{ old('confirm_password') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" name="profile_pic" class="form-control @error('profile_pic') is-invalid @enderror">
                                        @error('profile_pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    @includeFirst(['validation.js_manager'])
@endpush
