@extends('layouts.admin')

@section('title', 'Add Main Contractor')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-12">
                    <div class="card">
                        <x-alert />
                        <div class="card-header">
                            <h4>Add Main Contractor</h4>
                            <div class="card-header-form">
                                <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role.'.architects') }}">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="architect" action="{{route('admin.store.architect')}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Construction Site</label>
                                    <select name="construction_site[]" class="form-control @error('construction_site') is-invalid @enderror @error('construction_site.*') is-invalid @enderror selectric" multiple>
                                        <option disabled >Select Construction Site</option>
                                        @foreach( $sites as $site )
                                        <option value="{{ $site->id }}">{{$site->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('construction_site')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @error('construction_site.*')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" id="cpassword" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" value="{{ old('confirm_password') }}">
                                        @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    {{-- upload profile pic --}}
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" name="profile_pic" class="form-control">

                                    </div>

                                    {{-- --}}
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection
@push('scripts')
    @includeFirst(['validation.js_architect'])
@endpush
