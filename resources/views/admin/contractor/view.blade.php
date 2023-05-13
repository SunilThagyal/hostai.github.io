@extends('layouts.admin')

@section('title', 'Contractor')

@section('content')
@section('modal')
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="documentView">
                <iframe id="recivedData" width="100%" height="500px" style="border:none"></iframe>
                </div>
                <div id="rejectedLink"></div>
            </div>
        </div>
    </div>
</div>
@endsection
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img alt="image" style="object-fit: cover; width:100px;height:100px" src="{{ !is_null($user->profile_url) ? asset('storage/' . $user->profile_url) : asset('images/profile.png') }}" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{!is_null($user->contractor->company_name) ? $user->contractor->company_name : '' }}</a>
                                </div>
                                <div class="author-box-job">{{isset($user->role) ? $user->role : '' }}</div>
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
                                        Contact name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->first_name) ? $user->first_name : '' }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Email
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->email) ? $user->email : '' }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Location
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->location) ? $user->location : '' }}
                                    </span>
                                </p>

                                <p class="clearfix">
                                    <span class="float-left">
                                        Main Contractor
                                    </span>
                                    <span class="float-right text-muted">
                                        {{($user->contractor->architect->first_name) ? $user->contractor->architect->first_name : '' }}
                                    </span>
                                </p>

                                <p class="clearfix">
                                    <span class="float-left">
                                        Subcontractor of
                                    </span>
                                    <span class="float-right text-muted">
                                        {{!is_null($user->contractor->contractorOf) ? ($user->contractor->contractorOf->first_name) : '_' }}
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

                                @if(!$main_contractors->isEmpty())
                                <li class="nav-item">
                                    <a class="nav-link " id="administrativeDocuments-tab3" data-toggle="tab" href="#aboutAdminstrative"
                                        role="tab" aria-selected="true">Sub-subcontractors</a>
                                </li>
                                @endif

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Document</th>
                                                    <th>Review</th>
                                                    {{-- @dd($documents); --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!is_null($documents))
                                                    @foreach ($documents as $docs)
                                                        <tr>
                                                            <td> {{ $loop->iteration }} </td>
                                                            <td> {{ $docs->document_name}} :</td>
                                                            <td>
                                                                <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $docs->uploaded_file_url}}')" target="_blank" href="#">{{ $docs->uploaded_file_name }}</a>
                                                            </td>
                                                            <td>

                                                                {{-- @dd($authUser->id); --}}
                                                                @if($docs->status == "PENDING")
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="reviewData('{{$docs->uploaded_file_url}}',{{$docs->id}},{{$authUser->id}})">Review</button>
                                                                @elseif ($docs->status =='APPROVED')
                                                                <div class="badge badge-pill badge-success mb-1 float-center">Approved</div>
                                                                @elseif($docs->status =='REJECTED')
                                                                <div class="badge badge-pill badge-danger mb-1 float-center">Rejected</div>
                                                                @endif

                                                                {{-- <a href="{{ route($authUser->role . '.reject.document', [$docs->id]) }}"
                                                                    class="btn btn-danger">Reject</a> --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                    <td>{{'document not uploaded'}}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{--  --}}

                                <div class="tab-pane fade show " id="aboutAdminstrative" role="tabpanel" aria-labelledby="administrativeDocuments-tab3">
                                    {{--  --}}
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($main_contractors as $contractor )
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$contractor->user->first_name}} ({{($contractor->is_approved == 1 ) ? 'approved'  : 'unapproved'}})</td>
                                                </tr>

                                                @empty
                                                <tr>

                                                    <td>{{'No Sub-Subcontractors under this Subcontractor'}}</td>
                                                </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>


                                {{--  --}}
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
 <script>
    $(document).ready(function(){
        jQuery(".modal").on('hide.bs.modal', function() {

            jQuery("#documentView").removeClass('d-none');
        })
    });

    function sendData(url) {
        document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
        jQuery("#rejectedLink").addClass('d-none');
    };
    function reviewData(data, id, uid, approved_by) {
        jQuery("#rejectedLink").removeClass('d-none');
        document.getElementById("recivedData").src = APP_URL + '/storage/' + data;
        let url = "{{ route($authUser->role .'.approve.document', ':id')}}";
        url = url.replace(':id', id);
        document.getElementById("rejectedLink").innerHTML = '<a id="approveDocument" href="' + url + '" class="btn btn-primary" style="margin-right:10px">Approve</a><a style="color:white" onclick=openComment(' + id + ')  class="btn btn-danger delete" id="reject">Reject</a>';
    };

    function openComment(id) {
  jQuery("#documentView").addClass('d-none');
  let url = "{{ route($authUser->role .'.reject.document', ':id') }}";
  url = url.replace(':id', id);
  document.getElementById("rejectedLink").innerHTML = '<div class="card" id="sample-login"><form id="rejectDocument" method="post" action="' + url + '">@csrf<div class="card-body"><lable>Rejection Reason </lable><input type="text" class="form-control" name="comment" placeholder="Please enter rejection reason" minlength="5" maxlength="30" pattern="^[a-zA-Z0-9,.!?\\s]+$" required><div class="invalid-feedback"></div><button type="submit" class="center btn btn-primary">Submit</button></div></form></div>';

  // Add form validation
  const form = document.getElementById("rejectDocument");
  $(form).validate({
    rules: {
      comment: {
        required: true,
        minlength: 5,
        maxlength: 50,
        pattern: /^[a-zA-Z0-9\s.,!?#@$%^&*()-_+=\/|]{5,50}$/,
      }
    },
    messages: {
      comment: {
        required: "Please enter a rejection reason.",
        minlength: "Rejection reason should be at least 5 characters long.",
        maxlength: "Rejection reason should be no more than 30 characters long.",
        pattern: "Rejection reason should only contain letters, numbers, spaces, and punctuation."
      }
    },
    errorElement: "div",
    errorClass: "invalid-feedback",
    highlight: function(element) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function(element) {
      $(element).removeClass("is-invalid");
    }
  });
}


</script>

@includeFirst(['validation.js_reject_document'])


@endpush
