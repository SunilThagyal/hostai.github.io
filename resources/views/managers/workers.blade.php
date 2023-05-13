@extends('layouts.manager')

@section('title', 'Workers')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>Workers</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($workers as $user)
                                            <tr>
                                                <td>{{ $user->user->first_name ?? '' }}</td>
                                                <td>
                                                    <a href="{{ route($authUser->role . '.workers.view', [$user->user->slug]) }}" class="btn btn-primary">View</a>
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