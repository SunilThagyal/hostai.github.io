@extends('layouts.admin')

@section('title', get_manager_type() . 's')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>{{get_manager_type(  )}}</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.managers.create',['type'=>Request::route('type')]) }}">Add {{get_manager_type(  )}}</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($managers as $user)
                                            <tr>
                                                <td>{{ $user->user->first_name ?? '' }}</td>
                                                <td>{{ $user->user->email }}</td>
                                                {{-- <td>
                                                    <label>
                                                        <input type="checkbox" class="custom-switch-input"
                                                            @if ($user->user->status == 'Active') checked="checked" @endif
                                                            onchange="toggleStatus(this, 'User', '{{ $user->user->slug }}');">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route($authUser->role . '.managers.view', ['type'=>Request::route('type'),'manager'=>$user->user->slug]) }}" class="btn btn-primary">View</a>
                                                    <a href="{{ route($authUser->role . '.managers.edit', ['type'=>Request::route('type'),'manager'=>$user->user->slug]) }}" class="btn btn-secondary">Edit</a>
                                                    <a href="{{ route($authUser->role . '.managers.destroy', ['type'=>Request::route('type'),'manager'=>$user->user->slug]) }}" class="btn btn-danger delete">Delete</a>
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
            jQuery(".delete").click(function(e) {
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
