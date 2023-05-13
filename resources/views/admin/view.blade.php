@extends('layouts.admin')
@section('title', $authUser->role)

@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="invoice">
          <div class="invoice-print">
            <div class="row">
              <div class="col-lg-12">
                <div class="invoice-title">
                  <h2> {{ $user->first_name }} </h2>
                  <div class="invoice-number"><img src="{{ (!is_null($user->profile_url)) ?  asset('storage/' . $user->profile_url)  : asset('images/profile.png') }}" width="50px" height="50px" style="object-fit: cover;border-radius: 50px;"></div>
                </div>
                <hr>
                {{-- <div class="row">

                  <div class="col-md-6">
                    @if ($authUser->role == 'contractor')

                    <address>
                      <strong>Certificates:</strong><br>
                      @if(!is_null($user->userDocuments))
                      @foreach($user->userDocuments as $document)
                      <a class="" target="_blank"
                        href="{{asset('storage/' . $document->uploaded_file_url)}}">
                        {{$document->uploaded_file_name}}</a>,
                      @endforeach
                      @else
                      <a class="btn btn-warning"> Document Not Uploaded</a>
                      @endif
                    </address>
                    @endif

                  </div>

                </div> --}}
                <div class="row">
                  <div class="col-md-6">
                    <address>
                      <strong>Email:</strong><br>
                      {{$user->email}}
                    </address>
                  </div>
                  <div class="col-md-6 text-md-right">
                    <address>
                      <strong>Status:</strong><br>
                      {{$user->status}}
                    </address>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="text-md-right">
            <div class="float-lg-left mb-lg-0 mb-3">
              <a href=" {{ route( $authUser->role.'.edit.admin', [$user->slug]) }}" class="btn btn-primary">Edit</a>
            </div>
              <a class="btn btn-success" href="{{ url()->previous() }}"> Back</a>
          </div>
        </div>
      </div>
    </section>
 </div>
@endsection
