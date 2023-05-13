@extends('layouts.manager')
@section('title', 'View Contractor')

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
                                <img alt="image" style="object-fit: cover; width:100px;height:100px" src="{{ !is_null($user->profile_url) ? asset('storage/' . $user->profile_url) : asset('images/profile.png') }}" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="javascript:void(0);">{{ $user->fullName ?? '' }}</a>
                                </div>
                                <div class="author-box-job">{{ $user->role ?? '' }}</div>
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
                                    <span class="float-left">Email</span>
                                    <span class="float-right text-muted">{{ $user->email ?? '' }}</span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">Location</span>
                                    <span class="float-right text-muted">{{ $user->location ?? '' }}</span>
                                </p>

                                <p class="clearfix">
                                    <span class="float-left">Main Contractor</span>
                                    <span class="float-right text-muted">{{ $user->contractor->architect->fullName ?? '' }}</span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">Site</span>
                                    <span class="float-right text-muted">
                                        @foreach ($user->userSites as $key => $site)
                                        {{ $site->site->name ?? '' }}
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
                                                    <th>#</th>
                                                    <th>Document Name</th>
                                                    <th>Document</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!is_null($documents))
                                                @foreach ($documents as $docs)
                                                <tr>
                                                    <td>{{ $loop->iteration }} </td>
                                                    <td>{{ $docs->document_name }}</td>
                                                    <td>
                                                        <a style="text-decoration:none" data-toggle="modal" data-target="#documentModal" onclick="sendData('{{$docs->uploaded_file_url}}')" target="_blank" href="#">{{ $docs->uploaded_file_name }}</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <a class="btn btn-warning">Documents not uploaded</a>
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
