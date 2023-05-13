@extends('layouts.manager')
@section('title', 'Update Pofile')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Update Profile</h4>
                            </div>
                            <div class="card-body">
                                <form id="profile" action="{{ route('manager.profile.update', [$authUser->slug]) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $authUser->fullName) }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $authUser->email) }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Profile Picture</label>
                                            <input type="file" name="profile_pic"  class="form-control  @error('profile_pic') is-invalid @enderror">
                                            @error('profile_pic')
                                                <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @if (!is_null($authUser->profile_url))
                                                <a href="{{ asset('storage/' . $authUser->profile_url) }}">View</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Update</button>
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
    <script>
        jQuery(document).ready(function() {
            const rules = {
                name: {
                    required: true,
                    minlength: nameMinLength,
                    maxlength: nameMaxLength,
                    regex: nameRegex,
                },

                email: {
                    required: true,
                    email:true,
                    regex: emailRegex,
                },
                profile_pic: {
                    filesize: profilePicSize,
                    extension: profilePicMimes,
                },
            }
            const messages = {
                name: {
                    required:  `{{ __('customvalidation.profile.name.required') }}`,
                    minlength: `{{ __('customvalidation.profile.name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                    maxlength: `{{ __('customvalidation.profile.name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                    regex:     `{{ __('customvalidation.profile.name.regex', ['regex' => '${nameRegex}']) }}`,
                },
                email: {
                    required: `{{__('customvalidation.profile.email.required') }}`,
                    email: `{{__('customvalidation.profile.email.email') }}`,
                    regex: `{{ __('customvalidation.profile.email.regex', ['regex' => '${emailRegex}']) }}`,
                },
                profile_pic: {
                    filesize: `{{ __('customvalidation.profile.profile_pic.size', ['min' =>'${profilePicSize}'])}}`,
                    extension: `{{ __('customvalidation.profile.profile_pic.mimes', ['mime' => '${profilePicMimes}']) }}`,
                },
            };

            handleValidation('profile', rules, messages);
        });
    </script>
@endpush
