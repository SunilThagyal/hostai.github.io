@extends('layouts.admin')

@section('title', 'Sites')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert />
                            <div class="card-header">
                                <h4>Sites</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route('admin.add.site') }}">Add Site</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($sites as $site)
                                        <tr>
                                            <td>{{ $site->name }}</td>
                                            <td>
                                                <label>
                                                    <input type="checkbox" class="custom-switch-input" @if ($site->status == 'Active') checked="checked" @endif onchange="toggleStatus(this, 'Site', '{{ $site->slug }}');" >
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.edit.site', [$site->slug]) }}" class="btn btn-secondary">Edit</a>
                                                <a href="{{ route('admin.delete.site', [$site->slug]) }}" class="btn btn-danger @if($site->userSites->isEmpty()) delete @else disablebtn @endif">Delete</a>
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

        //
        jQuery(".disablebtn").click(function(e) {

            e.preventDefault();
            jQuery('body').addClass('modal-open');
            let url = jQuery(this).attr('href');
            swal({
                title: 'Unable to delete',
                text: 'currently site is in use ',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
                buttons: "ok"
            })
        });

        //
    });
</script>
@endpush