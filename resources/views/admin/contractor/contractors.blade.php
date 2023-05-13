@extends('layouts.admin')

@section('title', 'Subcontractors')

@section('content')

{{-- @dd($contractors); --}}
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>Subcontractors</h4>
                                <div class="card-header-form">
                                    {{-- <a href="{{ route($authUser->role . '.unapprove.contractors') }}">
                                        <button type="button" class="btn btn-primary">Unapproved Contractors <span
                                                class="badge badge-transparent">{{ isset($pending_contractors) ? $pending_contractors : '0' }}</span></button>
                                    </a> --}}
                                </div>
                                <!-- <div class="card-header-form">
                                    <a href="{{ route($authUser->role . '.approve.contractors') }}">
                                        <button type="button" class="btn btn-primary">New Contractors <span
                                                class="badge badge-transparent">{{ isset($unapproved_contractors) ? $unapproved_contractors : '0' }}</span></button>
                                    </a>
                                </div> -->
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end"
                                        href="{{ route($authUser->role . '.add.contractor') }}">Add Subcontractors</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Company name</th>
                                            <th>Contact name</th>
                                            <th>Type</th>
                                            <th>Workers</th>
                                            {{-- <th>Construction Site</th>
                                            <th>Location</th> --}}
                                            <th>Main Contractor </th>
                                            <th>Documnet status</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($contractors as $user)
                                        {{-- @dump($user) --}}
                                            <tr>
                                                <td>{{ !is_null($user->company_name) ? $user->company_name : '' }}</td>
                                                <td>{{ $user->user->first_name ? $user->user->first_name : '' }}</td>
                                                <td>{{is_null($user->contractor_id) ? 'Subcontractor' : 'Sub-subcontractor'}}</td>
                                                <td>{{ $user->user->contractorWorkers->count() ? $user->user->contractorWorkers->count() : '' }}
                                                </td>
                                                <td>{{$user->architect ? $user->architect->first_name : ""}}</td>
                                                <td>{{ucfirst($user->document_status)}}</td>
                                                {{-- <td>
                                                    @foreach ($user->user->userSites as $key => $site)
                                                        @if (!$loop->first)
                                                            ,
                                                        @endif
                                                        {{ isset($site->site->name) ? $site->site->name : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $user->user->location ? $user->user->location : '' }}</td> --}}
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="custom-switch-input"
                                                            @if ($user->user->status == 'Active') checked="checked" @endif
                                                            onchange="toggleStatus(this, 'User', '{{ $user->user->slug }}');">
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="{{ route($authUser->role . '.show.contractor', [$user->user->slug]) }}"
                                                        class="btn btn-primary">View</a>
                                                    <a href="{{ route($authUser->role . '.edit.contractor', [$user->user->slug]) }}"
                                                        class="btn btn-secondary">Edit</a>
                                                    <a href="{{ route($authUser->role . '.delete.contractor', [$user->user->slug]) }}"
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
