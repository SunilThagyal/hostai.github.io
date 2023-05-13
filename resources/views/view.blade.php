@extends('layouts.admin')

@section('title', 'Worker')

@section('content')

@section('modal')
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="documentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="recivedData" width="100%" height="500px" style="border:none"></iframe>
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
                                <img style="object-fit: cover; width:100px;height:100px" alt="image" src="{{ !is_null($user->profile_url) ? asset('storage/' . $user->profile_url) : asset('images/profile.png') }}" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="javascript:void(0);">{{isset($user->first_name) ? $user->first_name : '' }}</a>
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
                                        Name
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->first_name) ? $user->first_name : '' }}
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
                                {{-- project manager  --}}
                                <p class="clearfix">
                                    <span class="float-left">
                                        Main Contractor
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->Worker->architect->first_name) ? $user->Worker->architect->first_name : '' }}
                                    </span>
                                </p>
                                {{-- contractor --}}
                                <p class="clearfix">
                                    <span class="float-left">
                                        Sub Contractor
                                    </span>
                                    <span class="float-right text-muted">
                                        {{isset($user->Worker->workerContractor->first_name) ? $user->Worker->workerContractor->first_name : '' }}
                                    </span>
                                </p>
                                {{-- --}}
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
                                <p class="clearfix">
                                    <span class="float-left">
                                        Employement Type
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ isset($user->Worker->employment_type) ? $user->Worker->employment_type : ''  }}

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
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Document</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!is_null($user->userDocuments))
                                                    @foreach ($user->userDocuments as $document)
                                                        <tr>
                                                            <td> {{ $loop->iteration }} </td>
                                                            <td> <a style="text-decoration:none" data-toggle="modal" data-target="#documentModal" onclick="sendData('{{ $document->uploaded_file_url}}')" target="_blank" href="javascript:void(0);"> {{ $document->document_name }} </a> </td>
                                                            <td>
                                                                <a style="text-decoration:none" data-toggle="modal" data-target="#documentModal" onclick="sendData('{{ $document->uploaded_file_url}}')" target="_blank" href="javascript:void(0);"> {{ $document->uploaded_file_name }}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <a class="btn btn-warning">Document Not Uploaded</a>
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
@push('scripts')
<script>
    function sendData(url) {
        document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
    };
</script>
@endpush
