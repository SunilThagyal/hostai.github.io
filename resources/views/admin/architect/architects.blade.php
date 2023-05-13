@extends('layouts.admin')
@section('title', 'Main Contractors')

@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert />
                            <div class="card-header">
                                <h4>Main Contractors</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route('admin.add.architect') }}">Add
                                        Main Contractor</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Name</th>
                                            <th>Subcontractors</th>
                                            <th>Construction Site</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->first_name ? $user->first_name : '' }}</td>
                                                <td>{{ $user->architectContractors->count() ? $user->architectContractors->count() : '' }}</td>
                                                <td>
                                                    @if (!is_null($user->userSites))
                                                        @foreach ($user->userSites as $key => $site)
                                                            @if (isset($site->site->name) && !$loop->first && !is_null($site->site->name))
                                                                ,
                                                            @endif
                                                            @if (isset($site->site->name))
                                                                <span
                                                                    @if (!isset($site->site->name)) style="color:red" @endif>
                                                                    {{ isset($site->site->name) ? $site->site->name : '' }}</span>
                                                            @else
                                                                <span style="color:red">
                                                                    @if (!$loop->first)
                                                                        ,
                                                                    @endif site not available
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $user->location ? $user->location : '' }}</td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="custom-switch-input"
                                                            @if ($user->status == 'Active') checked="checked" @endif
                                                            onchange="toggleStatus(this, 'User', '{{ $user->slug }}');">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.show.architect', [$user->slug]) }}"
                                                        class="btn btn-primary">View</a>
                                                    <a href="{{ route('admin.edit.architect', [$user->slug]) }}"
                                                        class="btn btn-secondary">Edit</a>
                                                    <a href="{{ route('admin.delete.architect', [$user->slug]) }}"
                                                        class="btn btn-danger delete">Delete</a>
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
