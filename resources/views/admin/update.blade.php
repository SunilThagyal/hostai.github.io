@extends('layouts.admin')
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
                <form id="profile" action="{{ route(auth()->user()->role.'.update.admin',[$user->slug]) }}" enctype="multipart/form-data" method="post">
                    @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->first_name }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_pic"  class="form-control  @error('profile_pic') is-invalid   @enderror">
                            @error('profile_pic')
                            <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if ($authUser->role == 'subcontractor')
                        <div id="addMoreCertifacte" class="form-group">
                          <label>Certificate</label>
                          <input type="file" name="certificate[0]" value="{{ old('certificate' )}}" class="form-control  @error('certificate') is-invalid   @enderror">
                          @error('certificate')
                          <span class="invalid-feedback">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                          <button class="btn btn-primary" type="button" id="addMore" class="add-more">Add More </button>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </section>
</div>

@endsection
@push('scripts')
@includeFirst(['validation.js_profile'])

<script>
      var i = 0;

       jQuery("#addMore").click(function(){
           ++i;
           jQuery("#addMoreCertifacte").append('<input type="file" name="certificate['+i+']"  class="form-control "><button type="button" class="btn btn-danger remove">Remove</button>');
       });
       jQuery(document).on('click', '.remove', function(){
       jQuery(this).prev().remove()
       jQuery(this).remove()
   });
</script>
@endpush
