@extends('layouts.admin')
@section('title', 'View '.get_manager_type() )

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View Manager</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.managers.index',['type'=>Request::route('type')]) }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{ $manager->fullName }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $manager->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    @if (!is_null($manager->profile_url))
                                        <img src="{{ asset('storage/' . $manager->profile_url) }}" alt="profile pic">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
