@extends('layouts.admin')
@section('title', 'Architect')

@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="invoice">
          <div class="invoice-print">
            <div class="row">
              <div class="col-lg-12">
                <div class="invoice-title">
                  <h2> {{ $user->first_name }} </h2>
                  <div class="invoice-number"><img src="{{ (!is_null($user->profile_url)) ?  asset('storage/' . $user->profile_url)  : asset('images/profile.png') }}" width="50px" height="50px"></div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6">
                    <address>
                      <strong>Site:</strong><br>
                        @foreach( $user->userSites as $key => $site)
                          {{isset($site->site->name) ? $site->site->name : ''}},
                          @endforeach
                    </address>
                  </div>
                  <div class="col-md-6 text-md-right">
                    <address>
                      <strong>Location:</strong><br>
                  {{$user->location}}
                    </address>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <address>
                      <strong>Email:</strong><br>
                      {{$user->email}}
                    </address>
                  </div>
                  <div class="col-md-6 text-md-right">
                    <address>
                      <strong>Status:</strong><br>
                      {{$user->status}}
                    </address>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="text-md-right">
            <div class="float-lg-left mb-lg-0 mb-3">
              <a href="{{ route('admin.edit.architect', [$user->slug]) }}" class="btn btn-primary">Edit</a>
              <a href="{{ route('admin.delete.architect', [$user->slug]) }}" class="btn btn-danger delete"> Delete</a>
            </div>
            <a class="btn btn-primary"  href="{{ route('admin.architects') }}"> Back</a>
          </div>
        </div>
      </div>
    </section>
 </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery(".delete").click(function (e) {
                e.preventDefault();
                jQuery('body').addClass('modal-open');
                let url = jQuery(this).attr('href');
                swal({
                    title: 'Are you sure?',
                    text: 'You want to delete',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                    buttons: ["No", "Yes"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.replace(url)
                    } else {
                        jQuery('body').removeClass('modal-open');
                    }
                });
            });
        });
    </script>
@endpush
