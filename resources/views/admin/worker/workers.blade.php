@extends('layouts.admin')

@section('title', 'Workers')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert />
                            <div class="card-header">
                                <h4>Workers</h4>
                                {{-- @dd($users) --}}
                                @if ( in_array( $authUser->role , ['subcontractor',config('constants.main-manager'),config('constants.project-manager')]) )
                                    <div class="card-header-form">
                                        <a class="btn btn-primary btn-lg float-end"
                                            href="{{ route($authUser->role . '.add.worker') }}">Add Worker</a>
                                        <a class="btn btn-primary btn-lg float-end"
                                            href="{{ route($authUser->role . '.csv.worker') }}">Upload CSV</a>
                                    </div>
                                @endif
                            </div>
                            {{-- @if($authUser->role == 'subcontractor')
                                @dd($workers)
                            @endif --}}
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Name</th>
                                            @if( in_array( $authUser->role , ['project-manager','admin',config('constants.main-manager')] ) )
                                                <th>Company name</th>
                                            @endif
                                            @if(  in_array( $authUser->role , ['project-manager',config('constants.main-manager')])  )
                                                <th>Review</th>
                                            @else
                                                <th>Status</th>
                                            @endif
                                            <th>Action</th>
                                        </tr>
                                        @if ( in_array( $authUser->role , ['project-manager','subcontractor',config('constants.main-manager')] ) )
                                            @foreach ($workers as $user)
												<tr>
													<td>{{ $user->user->first_name ? $user->user->first_name : '' }}</td>
                                                    <td>{{ $user->user->last_name ? $user->user->last_name : '' }}</td>
                                                    @if( in_array( $authUser->role , ['project-manager','admin',config('constants.main-manager')] ) )
                                                    <td>{{$user->workerContractor ? $user->workerContractor->contractor->company_name : ""}}</td>
                                                    @endif

                                                    @if( in_array( $authUser->role , ['project-manager',config('constants.main-manager')]) )
                                                        <td>
                                                            @if(is_null($user->is_approved))
                                                                <a style="color:white;" href="{{ route($authUser->role . '.accept.worker', [$user->user->slug]) }}"    id="acceptWorker" class="btn btn-success">Accept</a>
                                                                <a style="color:white;cursor:pointer" user-slug="{{$user->user->slug}}" data-toggle="modal" data-target=".bd-example-modal-lg" id="rejectWorker" class="btn btn-danger reject-worker">Reject</a>  
                                                            @elseif($user->is_approved == '1')
                                                                <span class="btn btn-success">Accepted</span>  
                                                            @else
                                                                <span class="btn btn-danger">Rejected</span>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td>
                                                            @if(is_null($user->is_approved))
                                                                <span class="btn btn-primary">Pending</span>  
                                                            @elseif($user->is_approved == '1')
                                                                <span class="btn btn-success">Accepted</span>  
                                                            @else
                                                                <span class="btn btn-danger">Rejected</span>
                                                            @endif
                                                        </td>
                                                    @endif
													<td>
														<a href="{{ route($authUser->role . '.show.worker', [$user->user->slug]) }}"
															class="btn btn-primary">View</a>
														<a href="{{ route($authUser->role . '.edit.worker', [$user->user->slug]) }}"
															class="btn btn-secondary">Edit</a>
														<a href="{{ route($authUser->role . '.delete.worker', [$user->user->slug]) }}"
															class="btn btn-danger delete">Delete</a>
													</td>
												</tr>
                                            @endforeach
                                        @endif

										@if ($authUser->role == 'admin')
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->user->first_name }}</td>
                                                    <td>{{ $user->user->last_name ? $user->user->last_name : '' }}</td>
                                                    <td>{{$user->workerContractor ? $user->workerContractor->first_name : ""}}</td>
                                                    
                                                    <td>
                                                        @if(is_null($user->is_approved))
                                                            <span class="btn btn-primary">Pending</span>  
                                                        @elseif($user->is_approved == '1')
                                                            <span class="btn btn-success">Accepted</span>  
                                                        @else
                                                            <span class="btn btn-danger">Rejected</span>
                                                        @endif
                                                    </td>
													<td>
                                                        <a href="{{ route($authUser->role . '.show.worker', [$user->user->slug]) }}"
                                                            class="btn btn-primary">View</a>
                                                        <a href="{{ route($authUser->role . '.delete.worker', [$user->user->slug]) }}"
                                                            class="btn btn-danger delete">Delete</a>
													</td>
                                                </tr>
                                            @endforeach
                                        @endif
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
@section('modal')
<div class="modal fade bd-example-modal-lg" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Remark</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <div id="rejectedLink">
                        <form id="rejectForm" method="post">
                            @csrf
                            <div class="card-body">
                                <label>Rejection Reason </label>
                                <input type="text" class="form-control @error('
                        comment ') is-invalid @enderror" placeholder="write remark...." name="remark" value="">
                        @error("comment")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button type="submit" class=" center btn btn-primary mt-2">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
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
            // Reject confirmation
            // jQuery("#rejectWorker").click(function(e) {
            //     e.preventDefault();
            //     jQuery('body').addClass('modal-open');
            //     let url = jQuery(this).attr('href');
            //     swal({
            //             title: 'Are you sure?',
            //             text: 'You want to reject',
            //             icon: 'warning',
            //             buttons: true,
            //             dangerMode: true,
            //             buttons: ["No", "Yes"],
            //         })
            //         .then((willDelete) => {
            //             if (willDelete) {
            //                 window.location.replace(url)
            //             } else {
            //                 jQuery('body').removeClass('modal-open');
            //             }
            //         });
            // });
            // modal for reject
            jQuery('.reject-worker').on('click', function(){
                let userSlug = jQuery(this).attr('user-slug');
                let route = APP_URL+'/'+authUserRole+'/workers/'+userSlug+'/reject';
                console.log(route);
                jQuery('#rejectForm').attr('action', route);
            })

            // end 
            // accept confirmation
            jQuery("#acceptWorker").click(function(e) {
                e.preventDefault();
                jQuery('body').addClass('modal-open');
                let url = jQuery(this).attr('href');
                swal({
                        title: 'Are you sure?',
                        text: 'You want to accept',
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
            
            // end 
        });
    </script>
@endpush
