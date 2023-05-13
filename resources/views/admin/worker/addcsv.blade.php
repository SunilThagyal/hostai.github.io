@extends('layouts.admin')

@section('title', 'Upload CSV')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Upload csv</h4>
                            <div class="card-header-form">
                                <a class="btn btn-primary btn-lg float-end" href="{{ route( $authUser->role.'.workers') }}">Back</a>
                            </div>
                            @if ($message = Session::get('warning'))
                            <div class="alert alert-warning alert-block">
                                <button type="button" class="close" data-dismiss="alert">?</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                        </div>
                        <form id="worker" action="{{route( $authUser->role.'.csvstore.worker')}}" enctype="multipart/form-data" method="post">
                            <div class="card-body">
                                @csrf
                                @if($authUser->role != 'subcontractor')
                                {{-- <div class="form-group">
                                    <label>Select Main Contractor</label>
                                    <select name="architect_id" id="architectId" class="form-control @error('architect_id') is-invalid @enderror architect-id">
                                        <option value="" {{ $architects->count() >1 ? " " : "disabled";}}>Select Main Contractor </option>
                                        @foreach( $architects as $architect )
                                        <option value="{{ $architect->id }}" data="{{ $architect->slug }}"> {{ $architect->first_name }} </option>
                                        @endforeach
                                    </select>
                                    @error('architect_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                            </div> --}}
                        {{--subcontractor--}}
                            @if(in_array( $authUser->role , ['project-manager','admin',config('constants.main-manager')] ))
                            <div class="form-group">
                            <label>Subcontractor</label>
                            <select name="workerof" id="siteId" class="form-control @error('workerof') is-invalid @enderror">
                                <option disabled selected>Select subcontractor</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->user->id }}">{{ $contractor->user->first_name }}</option>
                                @endforeach
                            </select>
                            @error('workerof')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            @endif
                        {{--  --}}
                                @endif
                                <div class="form-group">
                                    <label>CSV File</label>
                                    <input type="file" name="csv_file" value="{{ old('csv_file' )}}" class="form-control  @error('csv_file') is-invalid   @enderror">
                                    @error('csv_file')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection
@push('scripts')
<script>
    const slug = '';
    jQuery(document).ready(function() {
        if (authUserRole == 'admin') {
            jQuery('.architect-id').on('change', function() {
                let architectSlug = jQuery(this).find(':selected').attr('data')
                let params = {
                    'slug': architectSlug,
                };
                let url = APP_URL + '/' + authUserRole + "/architect/contractor";
                let response = ajaxCall(url, 'get', params);
                response.then(handleContractorData).catch(handleContractorError)
            })
        } else {
            let architectSlug = jQuery(this).find(':selected').attr('data')
            let architectId = jQuery(this).find(':selected').val()
            let params = {
                'slug': architectSlug,
            };
            let url = APP_URL + '/' + authUserRole + "/architect/contractor";
            let response = ajaxCall(url, 'get', params);
            $('#architectId').val(parseInt(architectId)).trigger('change');
            response.then(handleContractorData).catch(handleContractorError)
        }
    });

    function handleContractorData(response) {
        if (response.status) {
            let options = '<option value="">Select Contractor</option>';
            response.data.contractors.forEach(contractor => {
                options += `<option value="${contractor.id}" data="${contractor.slug}" class="contractor">${contractor.first_name}</option>`;
            });
            $('#contractorId').html(options);
            $('select#contractorId').selectric('refresh');
        }
    }

    function handleContractorError(error) {
        console.log('error', error)
    }

    jQuery(document).ready(function() {
        jQuery('.contractor-id').on('change', function() {
            let contractorSlug = jQuery(this).find(':selected').attr('data')
            let params = {
                'slug': contractorSlug,
            };
            let url = APP_URL + "/admin/architect/site";
            let response = ajaxCall(url, 'get', params);
            response.then(handleSiteData).catch(handleSiteError)
        })
    });

    function handleSiteData(response) {
        if (response.status) {
            let options = '<option value="">Select Site</option>';
            response.data.sites.forEach(site => {
                options += `<option value="${site.id}" >${site.name}</option>`;
            });
            $('#siteId').html(options);
            $('select#siteId').selectric('refresh');
        }
    }

    function handleSiteError(error) {
        console.log('error', error)
    }


    var i = 0;

    jQuery("#addMore").click(function() {
        ++i;
        jQuery("#addMoreCertifacte").append('<input type="file" name="certificate[' + i + ']"  class="form-control "><button type="button" class="btn btn-danger remove">Remove</button>');
    });
    jQuery(document).on('click', '.remove', function() {
        jQuery(this).prev().remove()
        jQuery(this).remove()
    });
</script>
@includeFirst(['validation.js_worker'])
@endpush
