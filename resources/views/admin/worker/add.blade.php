@extends('layouts.admin')
@section('title', 'Add Worker')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert />
                            <div class="card-header">
                                <h4>Add Worker</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route( $authUser->role.'.workers') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="worker" action="{{route( $authUser->role.'.store.worker')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                        <input type="hidden" name="certificate_count" id="certificateCount" value="{{ old('certificate_count', 0) }}">
                                        <input type="hidden" name="admin_certificate_count" id="AdminCertificateCount" value="{{ old('admin_certificate_count', 0) }}">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
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
                                            <select name="workerof"  class="form-control change-subscontractor @error('workerof') is-invalid @enderror">
                                                <option disabled selected>Select subcontractor</option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{ $contractor->user->id }}" data-assigned-sites="{{ $contractor->user->userSites->pluck('site_id') }}">{{ $contractor->company_name }}</option>
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
                                            <select name="construction_site" id="siteId" class="form-control subscontractor-sites @error('construction_site') is-invalid @enderror">
                                                <option disabled selected value="">Select Construction Site</option>
                                                @foreach($user->userSites as $site)
                                                    <option value="{{ $site->site->id }}">{{ $site->site->name }}</option>
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
                                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
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
                                                <option value="Fixed Employee (CDI & CDD)">Fixed Employee (CDI & CDD)</option>
                                                <option value="Short Term (Interim)">Short Term (Interim)</option>
                                            </select>
                                            @error('employment_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Profile Picture</label>
                                            <input type="file" name="profile_pic" value="{{ old('profile_pic' )}}" class="form-control  @error('profile_pic') is-invalid   @enderror">
                                            @error('profile_pic')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- Administrative documents  --}}


                                        <div id="AdministrativeAddMore" class="form-group">
                                            <label>Administrative Documents</label>
                                            <div class="certificate-outer">
                                                <div class="certificate-input">
                                                    <input type="text" placeholder="Identification Document" name="admin_document_name[0]" value="{{ old('admin_document_name.0' )}}" class="form-control admin-document-name @error('admin_document_name.0') is-invalid @enderror">
                                                    @error('admin_document_name.0')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="file" name="admin_certificate[0]" value="{{ old('admin_certificate.0' )}}" class="form-control admin-worker-certificate @error('admin_certificate.0') is-invalid @enderror">
                                                    @error('admin_certificate.0')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="admin_dates[0]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date">
                                                </div>
                                                <button  class="btn btn-primary" type="button" id="addMoreAdmin">Add</button>
                                            </div>

                                            @for($i = 1; $i <= old('certificate_count', 0); $i++)
                                                <div class="certificate-outer">
                                                    <div class="certificate-input">
                                                        <input type="text" placeholder="Document Name" name="admin_document_name[{{ $i }}]" value="{{ old('admin_document_name.' . $i )}}" class="form-control admin-document-name @error('admin_document_name.' . $i) is-invalid @enderror">
                                                        @error('admin_document_name.' . $i)
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="certificate-choose-file">
                                                        <input type="file" name="admin_certificate[{{ $i }}]" value="{{ old('admin_certificate.' . $i )}}" class="form-control worker_certificate @error('admin_certificate.' . $i) is-invalid @enderror">
                                                        @error('admin_certificate.' . $i)
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="admin_dates[{{ $i }}]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date">
                                                    </div>
                                                    <button class="btn btn-danger admin_doc_remove" type="button">Remove </button>
                                                </div>
                                            @endfor
                                        </div>

                                        {{--  --}}

                                        <div id="addMoreCertificate" class="form-group">
                                            <label>Saftey Documents</label>
                                            <div class="certificate-outer">
                                                <div class="certificate-input">
                                                    <input type="text" placeholder="Document Name" name="document_name[0]" value="{{ old('document_name.0' )}}" class="form-control document-name @error('document_name.0') is-invalid @enderror">
                                                    @error('document_name.0')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="file" name="certificate[0]" value="{{ old('certificate.0' )}}" class="form-control worker-certificate @error('certificate.0') is-invalid @enderror">
                                                    @error('certificate.0')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="dates[0]" class="form-control daterange-cus" placeholder="Select Expiry Date">
                                                </div>
                                                <button class="btn btn-primary" type="button" id="addMore">Add</button>
                                            </div>

                                            @for($i = 1; $i <= old('certificate_count', 0); $i++)
                                                <div class="certificate-outer">
                                                    <div class="certificate-input">
                                                        <input type="text" placeholder="Document Name" name="document_name[{{ $i }}]" value="{{ old('document_name.' . $i )}}" class="form-control document-name @error('document_name.' . $i) is-invalid @enderror">
                                                        @error('document_name.' . $i)
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="certificate-choose-file">
                                                        <input type="file" name="certificate[{{ $i }}]" value="{{ old('certificate.' . $i )}}" class="form-control worker-certificate @error('certificate.' . $i) is-invalid @enderror">
                                                        @error('certificate.' . $i)
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="dates[{{ $i }}]" class="form-control daterange-cus" placeholder="Select Expiry Date">
                                                    </div>
                                                    <button class="btn btn-danger remove" type="button">Remove </button>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
        const slug = "";
        var i = 1;
        var j = 1
        jQuery(document).ready(function() {
            jQuery('input.daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            jQuery('input.admin-daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
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
                --i;
                let certificateCount = jQuery('#certificateCount').val();
                jQuery('#certificateCount').val(+certificateCount - 1);
                jQuery(this).closest("div").remove();
                resetindex();
            });

            //
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
                                <input type="text" placeholder="Document Name" name="admin_document_name[${j}]" class="form-control admin-document-name">
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
                                <input type="text" id="AdminDate${j}" name="admin_dates[${j}]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date">
                            </div>
                            <button class="btn btn-danger admin_doc_remove" type="button">Remove</button>
                        </div>`;

                jQuery('#AdministrativeAddMore').append(html2)
                var dates = '#AdminDates'+j
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
            jQuery(document).on('click', '.admin_doc_remove', function() {
                --j;
                let certificateCountAdmin = jQuery('#AdminCertificateCount').val();
                jQuery('#AdminCertificateCount').val(+ certificateCountAdmin - 1);
                jQuery(this).closest("div").remove();
                resetindexadmin();
            });

            //
        });
    </script>
    @includeFirst(['validation.js_worker'])
@endpush
