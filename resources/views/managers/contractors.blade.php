@extends('layouts.manager')

@section('title', 'Contractors')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>Subcontractors</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Name</th>
                                            <th>Workers</th>
                                            {{-- <th>Construction Site</th>
                                            <th>Location</th> --}}
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($contractors as $user)
                                            <tr>
                                                <td>{{ $user->user->first_name ?? '' }}</td>
                                                <td>{{ $user->user->contractorWorkers->count() ?? '0' }}
                                                {{-- <td>
                                                    @foreach ($user->user->userSites as $key => $site)
                                                        @if (!$loop->first)
                                                            ,
                                                        @endif
                                                        {{ isset($site->site->name) ? $site->site->name : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $user->user->location ?? 'N/A' }}</td> --}}
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="custom-switch-input" @if ($user->user->status == 'Active') checked="checked" @endif disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a href="{{ route($authUser->role . '.contractors.view', [$user->user->slug]) }}" class="btn btn-primary">View</a>
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