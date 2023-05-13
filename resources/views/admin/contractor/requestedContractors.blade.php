@extends('layouts.admin')
@section('title', 'Subcontractors')

@section('content')

<div class="main-content">
      <section class="section">
        <div class="section-body">
          <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Subcontractors Pending for Approval</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-md">
                      <tr>
                        <th>Name</th>
                        <th>Construction Site</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      {{-- @dd($users[0]) --}}
                      @foreach($users as $user)
                      {{-- @dd($user) --}}
                      <tr>
                        <td>{{ $user->unapprovedContractors->first_name ? $user->unapprovedContractors->first_name : '' }}</td>
                        <td>
                          @foreach( $user->unapprovedContractors->userSites as $key => $site)
                           {{isset($site->site->name) ? $site->site->name : ''}},
                          @endforeach
                        </td>
                        <td>{{ $user->unapprovedContractors->location ? $user->unapprovedContractors->location : '' }}</td>
                        <td>
                        <label>
                            <span>{{$user->document_status ? $user->document_status : ''}}</span>
                        </label>
                        </td>
                        <td>

                          <a href="{{ route( $authUser->role.'.contractors.details',[$user->unapprovedContractors->slug]) }}" class="btn btn-primary">View</a>
                        </td>
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
              </div>
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
