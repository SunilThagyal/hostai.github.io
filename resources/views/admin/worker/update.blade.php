@extends('layouts.admin')

@section('title', 'Update Worker')

@section('content')
    @section('modal')
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="recivedData" width="100%" height="500px"style="border:none"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>Update Worker</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.workers') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="worker" action="{{ route($authUser->role.'.update.worker', [$worker->slug]) }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="hidden" name="certificate_count" id="certificateCount" value="{{ old('certificate_count', $worker->safetyDocuments->count()) }}">
                                    <input type="hidden" name="admin_certificate_count" id="AdminCertificateCount" value="{{ old('admin_certificate_count', $worker->adminDocuments->count()) }}">

                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $worker->first_name }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $worker->last_name }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{--subcontractor--}}
                                    @if( in_array( auth()->user()->role , [config('constants.main-manager'),config('constants.project-manager')] ) )
                                    <div class="form-group">
                                        <label>Subcontractor</label>
                                        <select name="workerof" class="form-control change-subscontractor  @error('workerof') is-invalid @enderror">
                                            <option disabled selected>Select subcontractor</option>
                                            @foreach($getContractors as $getContractor)
                                            {{-- @dd('helo',$getContractor->user->id,$contractor->id); --}}
                                                <option  value="{{ $getContractor->user->id }}" @if(!is_null($getContractor->user->id ) && ($worker->worker->workerContractor->id == $getContractor->user->id )) selected @endif data-assigned-sites="{{ $getContractor->user->userSites->pluck('site_id') }}">
                                                    {{ $getContractor->company_name }}
                                                </option>
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
                                    <div class="form-group">
                                        <label>Construction Site</label>
                                        <select name="construction_site" data-preselected="{{ $worker->workerSite ? $worker->workerSite->site_id : '' }}" id="siteId" class="form-control subscontractor-sites  @error('construction_site') is-invalid @enderror">
                                            <option disabled value="">Select Construction Site</option>
                                            @foreach($contractor->userSites as $site)
                                                <option value="{{ old('construction_site', $site->site->id) }}" @if(!is_null($worker->workerSite) && ($site->site->id == $worker->workerSite->site_id)) selected @endif>{{ $site->site->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('construction_site')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location',$worker->location) }}">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <label>Employment Type</label>
                                        <select name="employment_type" class="form-control @error('employment_type') is-invalid @enderror">
                                            <option value="">Select Employment Type</option>
                                            <option value="Fixed Employee (CDI & CDD)" {{ $worker->Worker->employment_type == 'Fixed Employee (CDI & CDD)' ? 'selected' : '' }}> Fixed Employee (CDI & CDD) </option>
                                            <option value="Short Term (Interim)" {{ $worker->Worker->employment_type == 'Short Term (Interim)' ? 'selected' : '' }}> Short Term (Interim) </option>
                                        </select>
                                        @error('employment_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" name="profile_pic" value="{{ old('profile_pic') }}" class="form-control  @error('profile_pic') is-invalid @enderror">
                                        @error('profile_pic')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if (!is_null($worker->profile_url))
                                        <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $worker->profile_url }}')" target="_blank" href="{{ asset('storage/' . $worker->profile_url) }}">View</a>
                                    @endif

                                    {{-- admin strrrr doc --}}
                                    <div id="AdministrativeAddMore" class="form-group">
                                        <label>Add Administrative Certificate</label>
                                        <div class="certificate-outer">
                                            <div class="certificate-input">
                                                <input type="text" placeholder="Identification Document" name="admin_document_name[0]" value="{{ old('admin_document_name.0', $worker->adminDocuments[0]->document_name ?? '') }}" class="form-control admin-document-name  @error('admin_document_name.0') is-invalid @enderror">
                                                @error('admin_document_name.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="certificate-choose-file">
                                                <input type="hidden" name="old_admin_certificate[0]" @if ($worker->adminDocuments->count()) value="{{ $worker->adminDocuments[0]->id }}" @endif>
                                                <input type="hidden" name="old_admin_certificate_name[0]" @if (isset($worker->adminDocuments[0]) && !is_null($worker->adminDocuments[0]->uploaded_file_name)) value="{{ $worker->adminDocuments[0]->uploaded_file_name }}" @endif>
                                                <input type="hidden" name="old_admin_certificate_url[0]" @if (isset($worker->adminDocuments[0]) && !is_null($worker->adminDocuments[0]->uploaded_file_url)) value="{{ $worker->adminDocuments[0]->uploaded_file_url }}" @endif>
                                                <input type="file" name="admin_certificate[0]" value="{{ old('admin_certificate.0') }}" class="form-control @if ($worker->adminDocuments->count() == 0) admin-worker-certificate @endif @error('admin_certificate.0') is-invalid @enderror">
                                                @error('admin_certificate.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                @if ($worker->adminDocuments->count() && !is_null($worker->adminDocuments[0]->uploaded_file_url))
                                                    <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $worker->adminDocuments[0]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $worker->adminDocuments[0]->uploaded_file_url) }}">{{ $worker->adminDocuments[0]->uploaded_file_name }}</a>
                                                @endif
                                            </div>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" id = "AdminDates0" name="admin_dates[0]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.0', $worker->adminDocuments[0]->valid_between ?? '') }}">
                                            </div>
                                            <button class="btn btn-primary" type="button" id="addMoreAdmin">Add</button>
                                        </div>

                                        @for($i = 1; $i <= old('admin_certificate_count', $worker->adminDocuments->count()) - 1; $i++)
                                            <div class="certificate-outer">
                                                <div class="certificate-input">
                                                    <input type="text" placeholder="Document Name" name="admin_document_name[{{ $i }}]" value="{{ old('admin_document_name.' . $i, $worker->adminDocuments[$i]->document_name ?? '')}}" class="form-control admin-document-name @error('admin_document_name.' . $i) is-invalid @enderror">
                                                    @error('admin_document_name.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="hidden" name="old_admin_certificate[{{ $i }}]" class="old-certificate" @if (isset($worker->adminDocuments[$i])) value="{{ $worker->adminDocuments[$i]->id }}" @endif>
                                                    <input type="hidden" name="old_admin_certificate_name[{{ $i }}]" @if (isset($worker->adminDocuments[$i]) && !is_null($worker->adminDocuments[$i]->uploaded_file_name)) value="{{ $worker->adminDocuments[$i]->uploaded_file_name }}" @endif>
                                                    <input type="hidden" name="old_admin_certificate_url[{{ $i }}]" @if (isset($worker->adminDocuments[$i]) && !is_null($worker->adminDocuments[$i]->uploaded_file_url)) value="{{ $worker->adminDocuments[$i]->uploaded_file_url }}" @endif>
                                                    <input type="file" name="admin_certificate[{{ $i }}]" value="{{ old('admin_certificate.' . $i )}}" class="form-control @if (!isset($worker->adminDocuments[$i])) admin-worker-certificate @endif @error('admin_certificate.' . $i) is-invalid @enderror">
                                                    @error('admin_certificate.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if (isset($worker->adminDocuments[$i]) && !is_null($worker->adminDocuments[$i]->uploaded_file_url))
                                                        <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $worker->adminDocuments[$i]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $worker->adminDocuments[$i]->uploaded_file_url) }}">{{ $worker->adminDocuments[$i]->uploaded_file_name }}</a>
                                                    @endif
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="admin_dates[{{ $i }}]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.' . $i, $worker->adminDocuments[$i]->valid_between ?? '') }}">
                                                </div>
                                                <button class="btn btn-danger admin_doc_remove" type="button">Remove </button>
                                            </div>
                                        @endfor
                                    </div>
                                    {{-- ends here --}}
                                    <div id="addMoreCertificate" class="form-group">
                                        <label>Add Safety Certificate</label>
                                        <div class="certificate-outer">
                                            <div class="certificate-input">
                                                <input type="text" placeholder="Document Name" name="document_name[0]" value="{{ old('document_name.0', $worker->safetyDocuments[0]->document_name ?? '') }}" class="form-control document-name  @error('document_name.0') is-invalid @enderror">
                                                @error('document_name.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="certificate-choose-file">
                                                <input type="hidden" name="old_certificate[0]" @if ($worker->safetyDocuments->count()) value="{{ $worker->safetyDocuments[0]->id }}" @endif>
                                                <input type="hidden" name="old_certificate_name[0]" @if (isset($worker->safetyDocuments[0]) && !is_null($worker->safetyDocuments[0]->uploaded_file_name)) value="{{ $worker->safetyDocuments[0]->uploaded_file_name }}" @endif>
                                                <input type="hidden" name="old_certificate_url[0]" @if (isset($worker->safetyDocuments[0]) && !is_null($worker->safetyDocuments[0]->uploaded_file_url)) value="{{ $worker->safetyDocuments[0]->uploaded_file_url }}" @endif>
                                                <input type="file" name="certificate[0]" value="{{ old('certificate.0') }}" class="form-control @if ($worker->safetyDocuments->count() == 0) worker-certificate @endif @error('certificate.0') is-invalid @enderror">
                                                @error('certificate.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                @if ($worker->safetyDocuments->count() && !is_null($worker->safetyDocuments[0]->uploaded_file_url))
                                                    <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $worker->safetyDocuments[0]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $worker->safetyDocuments[0]->uploaded_file_url) }}">{{ $worker->safetyDocuments[0]->uploaded_file_name }}</a>
                                                @endif
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" name="dates[0]" class="form-control daterange-cus"
                                                    placeholder="Select Expiry Date" value="{{ old('dates.0', $worker->userDocuments[0]->valid_between ?? '') }}">
                                            </div>
                                            <button class="btn btn-primary" type="button" id="addMore">Add</button>
                                        </div>

                                        @for($i = 1; $i <= old('certificate_count', $worker->safetyDocuments->count()) - 1; $i++)
                                            <div class="certificate-outer">
                                                <div class="certificate-input">
                                                    <input type="text" placeholder="Document Name" name="document_name[{{ $i }}]" value="{{ old('document_name.' . $i, $worker->safetyDocuments[$i]->document_name ?? '')}}" class="form-control document-name @error('document_name.' . $i) is-invalid @enderror">
                                                    @error('document_name.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="hidden" name="old_certificate[{{ $i }}]" class="old-certificate" @if (isset($worker->safetyDocuments[$i])) value="{{ $worker->safetyDocuments[$i]->id }}" @endif>
                                                    <input type="hidden" name="old_certificate_name[{{ $i }}]" @if (isset($worker->safetyDocuments[$i]) && !is_null($worker->safetyDocuments[$i]->uploaded_file_name)) value="{{ $worker->safetyDocuments[$i]->uploaded_file_name }}" @endif>
                                                    <input type="hidden" name="old_certificate_url[{{ $i }}]" @if (isset($worker->safetyDocuments[$i]) && !is_null($worker->safetyDocuments[$i]->uploaded_file_url)) value="{{ $worker->safetyDocuments[$i]->uploaded_file_url }}" @endif>
                                                    <input type="file" name="certificate[{{ $i }}]" value="{{ old('certificate.' . $i )}}" class="form-control @if (!isset($worker->safetyDocuments[$i])) worker-certificate @endif @error('certificate.' . $i) is-invalid @enderror">
                                                    @error('certificate.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if (isset($worker->safetyDocuments[$i]) && !is_null($worker->safetyDocuments[$i]->uploaded_file_url))
                                                        <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $worker->safetyDocuments[$i]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $worker->safetyDocuments[$i]->uploaded_file_url) }}">{{ $worker->safetyDocuments[$i]->uploaded_file_name }}</a>
                                                    @endif
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="dates[{{ $i }}]" class="form-control daterange-cus" placeholder="Select Expiry Date" value="{{ old('dates.' . $i, $worker->safetyDocuments[$i]->valid_between ?? '') }}">
                                                </div>
                                                <button class="btn btn-danger remove" type="button">Remove </button>
                                            </div>
                                        @endfor
                                    </div>

                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" form="worker" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script>
        const slug = "{{ $worker->slug }}";
        const workerId = '{{ $worker->id }}'
        function sendData(url) {
            document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
        };
        var i = +"{{ $worker->safetyDocuments->count() > 0 ? $worker->safetyDocuments->count() : 1 }}";
        var j = +"{{ $worker->adminDocuments->count() > 0 ? $worker->adminDocuments->count() : 1 }}";

        jQuery(document).ready(function() {
            jQuery('input.daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            jQuery('input.admin-daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });


            jQuery('input.daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

            jQuery('input.admin-daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

            jQuery("#addMore").click(function() {
                if (i == 5) {
                    return swal({
                        text: 'you can only upload only 5 documents once',
                        icon: 'warning',
                        dangerMode: true,
                    });
                }

                var html = `<div class="certificate-outer">
                            <div class="certificate-input">
                                <input type="text" placeholder="Document Name" name="document_name[${i}]" class="form-control document-name">
                            </div>
                            <div class="certificate-choose-file">
                                <input type="file" name="certificate[${i}]" class="form-control worker-certificate">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" id="date${i}" name="dates[${i}]" class="form-control daterange-cus" placeholder="Select Expiry Date">
                            </div>
                            <button class="btn btn-danger remove" type="button">Remove</button>
                        </div>`;

                jQuery('#addMoreCertificate').append(html)
                var dates = '#date'+i
                jQuery(dates).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate: moment(),
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                jQuery(dates).on('apply.daterangepicker', function(ev, picker) {
                    jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
                });
                let certificateCount = jQuery('#certificateCount').val();
                jQuery('#certificateCount').val(+certificateCount + 1);
                ++i;
            });

            function resetindex() {
                let i = 0;
                jQuery(document).find('.certificate-outer').each(function (index) {
                    jQuery(this).find('input.document-name').attr('name', 'document_name[' + i + ']')
                    jQuery(this).find('input[type="file"].worker-certificate').attr('name', 'certificate[' + i + ']')
                    jQuery(this).find('input.daterange-cus').attr('name', 'dates[' + i + ']')
                    i++;
                });
            }

            jQuery(document).on('click', '.remove', function() {
                let isRemoveExistingDoc = jQuery(this).parent().find('.certificate-choose-file').find('input.old-certificate');
                if (isRemoveExistingDoc.length) {
                    return swal({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this document!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            let removedId = isRemoveExistingDoc.attr('value');
                            let params = {
                                'id': removedId,
                                'worker_id': workerId,
                            };
                            let url = APP_URL + '/' + authUserRole + '/worker/document/delete';
                            let response = ajaxCall(url, 'post', params);
                            response.then((res) => {
                                let certificateCount = jQuery('#certificateCount').val();
                                jQuery('#certificateCount').val(+certificateCount - 1);
                                jQuery(this).closest("div").remove();
                                resetindex();
                                --i
                            }).catch((err) => {
                                alert('something wrong')
                            })
                        }
                    });
                } else {
                    let certificateCount = jQuery('#certificateCount').val();
                    jQuery('#certificateCount').val(+certificateCount - 1);
                    jQuery(this).closest("div").remove();
                    resetindex();
                    --i
                }
            });
            //admin docs

            jQuery("#addMoreAdmin").click(function() {

                if (j == 5) {
                    return swal({
                        text: 'you can only upload only 5 documents once',
                        icon: 'warning',
                        dangerMode: true,
                    });
                }

                var html2 = `<div class="certificate-outer">
                            <div class="certificate-input">
                                <input type="text" placeholder="Document Name" name="admin_document_name[${j}]" class="form-control admin-document-name ">
                            </div>
                            <div class="certificate-choose-file">
                                <input type="file" name="admin_certificate[${j}]" class="form-control admin-worker-certificate">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" id="AdminDates${j}" name="admin_dates[${j}]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date">
                            </div>
                            <button class="btn btn-danger admin_doc_remove" type="button">Remove</button>
                        </div>`;

                jQuery('#AdministrativeAddMore').append(html2)
                var dates2 = '#AdminDates'+j
                jQuery(dates2).daterangepicker({
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate: moment(),
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'YYYY-MM-DD'
                    }
                });

                jQuery(dates2).on('apply.daterangepicker', function(ev, picker) {
                    jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
                });
                let admin_certificate_count = jQuery('#AdminCertificateCount').val();
                jQuery('#AdminCertificateCount').val(+ admin_certificate_count + 1);
                ++j;
            });

            function resetindexadmin() {
                let j = 0;
                jQuery(document).find('.certificate-outer').each(function (index) {
                    jQuery(this).find('input.admin-document-name').attr('name', 'admin_document_name[' + j + ']')
                    jQuery(this).find('input[type="file"].admin-worker-certificate').attr('name', 'admin_certificate[' + j + ']')
                    jQuery(this).find('input.admin-daterange-cus').attr('name', 'admin_dates[' + j + ']')
                    j++;
                });
            }
            // jQuery(document).on('click', '.admin_doc_remove', function() {
            //     --j;
            //     let certificateCountAdmin = jQuery('#AdminCertificateCount').val();
            //     jQuery('#AdminCertificateCount').val(+ certificateCountAdmin - 1);
            //     jQuery(this).closest("div").remove();
            //     resetindexadmin();
            // });

            jQuery(document).on('click', '.admin_doc_remove', function() {
                let isRemoveExistingDoc = jQuery(this).parent().find('.certificate-choose-file').find('input.old-certificate');
                if (isRemoveExistingDoc.length) {
                    return swal({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this document!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            let removedId = isRemoveExistingDoc.attr('value');
                            let params = {
                                'id': removedId,
                                'worker_id': workerId,
                            };
                            let url = APP_URL + '/' + authUserRole + '/worker/document/delete';
                            let response = ajaxCall(url, 'post', params);
                            response.then((res) => {
                                let certificateCountAdmin = jQuery('#AdminCertificateCount').val();
                                jQuery('#AdminCertificateCount').val(+certificateCountAdmin - 1);
                                jQuery(this).closest("div").remove();
                                resetindexadmin();
                                --j
                            }).catch((err) => {
                                alert('something wrong')
                            })
                        }
                    });
                } else {
                    let certificateCountAdmin = jQuery('#AdminCertificateCount').val();
                    jQuery('#AdminCertificateCount').val(+certificateCountAdmin - 1);
                    jQuery(this).closest("div").remove();
                    resetindexadmin();
                    --j
                }
            });

            //
        });
    </script>
    @includeFirst(['validation.js_worker'])
@endpush
