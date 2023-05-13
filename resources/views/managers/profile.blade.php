@extends('layouts.manager')
@section('title', $authUser->fullName)
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2> {{ $authUser->fullName }} </h2>
                                    <div class="invoice-number">
                                        <img src="{{ !is_null($authUser->profile_url) ? asset('storage/' . $authUser->profile_url) : asset('images/profile.png') }}" width="50px" height="50px" style="object-fit: cover;border-radius: 50px;">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Email:</strong><br>
                                            {{ $authUser->email }}
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Status:</strong><br>
                                            {{ $authUser->status }}
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            <a href=" {{ route($authUser->role . '.profile.edit', [$authUser->slug]) }}" class="btn btn-primary">Edit</a>
                        </div>
                        <a class="btn btn-success" href="{{ url()->previous() ?? route('manager.dashboard') }}">Back</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
