@extends('layouts.admin')
@section('title', 'Worker')
@section('content')
{{-- @dd($user) --}}
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card-header-form">
                <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.unapprove.contractors') }}">Back</a>
            </div>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img style="object-fit: cover; width:100px;height:100px" alt="image" src="{{ !is_null($user->profile_url) ? asset('storage/' . $user->profile_url) : asset('images/profile.png') }}" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ !is_null($user->contractor->company_name) ? $user->contractor->company_name : '' }}</a>
                                </div>
                                <div class="author-box-job">{{ $user->role }}</div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Personal Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">

                                <p class="clearfix">
                                    <span class="float-left">
                                        Email
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $user->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Location
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $user->location }}
                                    </span>
                                </p>

                                <p class="clearfix">
                                    <span class="float-left">
                                        Site
                                    </span>
                                    <span class="float-right text-muted">
                                        @foreach ($user->userSites as $key => $site)
                                        {{ isset($site->site->name) ? $site->site->name : '' }}
                                        @endforeach
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab" aria-selected="true">Documents</a>
                                </li>
                            </ul>

                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>S.no</th>
                                                    <th>Name</th>
                                                    <th>Document</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!is_null($user_documents))
                                                @foreach ($user_documents as $document)
                                                <tr>
                                                    <td> {{ $loop->iteration }} </td>
                                                    <td> {{ $document->document_name }} :</td>
                                                    <td>
                                                        <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{$document->uploaded_file_url}}',{{$document->id}},{{$authUser->id}})">{{ Str::limit($document->uploaded_file_name, 20) }}</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <a class="btn btn-warning"> Document Not Uploaded</a>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                <h5 class="modal-title" id="myLargeModalLabel">Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <div id="documentView">
                    <iframe id="recivedData" width="100%" height="500px" style="border:none"></iframe>
                </div>
                <div id="rejectedLink"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

    $(document).ready(function(){
        jQuery(".modal").on('hide.bs.modal', function() {

            jQuery("#documentView").removeClass('d-none');
        })
    });

    function sendData(data, id, uid, approved_by) {
        document.getElementById("recivedData").src = APP_URL + '/storage/' + data;
        let url = "{{ route($authUser->role .'.approve.document', ':id')}}";
        url = url.replace(':id', id);
        document.getElementById("rejectedLink").innerHTML = '<a id="approveDocument" href="' + url + '" class="btn btn-primary" style="margin-right:10px">Approve</a><a style="color:white" onclick=openComment(' + id + ')  class="btn btn-danger delete" id="reject">Reject</a>';
    };


    function openComment(id) {
        jQuery("#documentView").addClass('d-none');
        let url = "{{ route($authUser->role .'.reject.document', ':id') }}";
        url = url.replace(':id', id);
        document.getElementById("rejectedLink").innerHTML = '<div class="card" id="sample-login"><form id="rejectDocument" method="post" action="' + url + '">@csrf<div class="card-body"><lable>Rejection Reason </lable><input type="text" class="form-control @error('
        comment ') is-invalid @enderror" placeholder="Please enter rejection reason" name="comment" value="">@error("comment")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</stong></span>@enderror<button type="submit" class=" center btn btn-primary">Submit</button></div></form></div>';
    };
</script>

@includeFirst(['validation.js_reject_document'])

@endpush
