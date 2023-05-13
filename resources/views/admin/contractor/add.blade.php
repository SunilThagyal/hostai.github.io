@extends('layouts.admin')
@section('title', 'Add Subcontractor')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-12">
                        <div class="card">
                            <x-alert/>
                            <div class="card-header">
                                <h4>Add Subcontractor</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end" href="{{ route($authUser->role . '.contractors') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="contractor" action="{{ route($authUser->role . '.store.contractor') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Contact Name <code>*</code> </label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- name to  company_name--}}
                                    <div class="form-group">
                                        <label>Company Name <code>*</code> </label>
                                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{--  --}}
                                    @if ($authUser->role == 'admin')
                                        <div class="form-group">
                                            <label>Select Main Contractor <code>*</code></label>
                                            <select name="architect_id" id="" class="form-control architectId architect-id @error('architect_id') is-invalid @enderror">
                                                <option value="">Select Main Contractor</option>
                                                @foreach ($projectManagers as $projectManager)
                                                    <option value="{{ $projectManager->id }}" data="{{ $projectManager->slug }}">{{ $projectManager->first_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('architect_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                    {{-- main contractor --}}

                                    <div class="form-group">
                                        <label>Subcontractor of</label>
                                        <select name="main_contractor" id="main_contractor" class="form-control architectId architect-id @error('architect_id') is-invalid @enderror">
                                            <option value="">Select Contractor</option>
                                            @if ($authUser->role == 'project-manager' || $authUser->role == 'main-manager'  )
                                            @foreach ($main_contractors as $main_contractor)
                                                <option value="{{ $main_contractor->id }}" data="{{ $main_contractor->slug }}">{{ $main_contractor->first_name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('main_contractor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                    {{--  --}}
                                    <div class="form-group site">
                                        <label>Construction Site <code>*</code></label>
                                        <select name="construction_site[]" id="site" class="form-control selectric @error('construction_site') is-invalid @enderror @error('construction_site.*') is-invalid @enderror" multiple>
                                            <option disabled >Select Site</option>
                                            @if ($authUser->role == 'project-manager' || $authUser->role == 'main-manager')
                                                @foreach ($sites->userSites as $site)
                                                    <option value="{{ $site->site->id }}">{{ $site->site->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('construction_site')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('construction_site.*')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Location <code>*</code></label>
                                        <input type="text" name="location"
                                            class="form-control @error('location') is-invalid @enderror"
                                            value="{{ old('location') }}">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email <code>*</code></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password <code>*</code></label>
                                        <input type="password" name="password" id="cpassword"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password <code>*</code></label>
                                        <input type="password" name="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            value="{{ old('confirm_password') }}">
                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Picture</label>
                                        <input type="file" name="profile_pic" value="{{ old('profile_pic') }}"
                                            class="form-control @error('profile_pic') is-invalid @enderror">
                                        @error('profile_pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- working on docs --}}


                                    <div id="AdministrativeAddMore" class="form-group">
                                        <label>Upload Documents</label>
                                        <div class="certificate-outer">
                                            <div class="certificate-input">
                                                <input type="text" placeholder="Document Name" name="admin_document_name[0]" value="{{ old('admin_document_name.0' )}}" class="form-control  @error('admin_document_name.0') is-invalid @enderror">
                                                @error('admin_document_name.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="certificate-choose-file">
                                                <input type="file" name="admin_certificate[0]" value="{{ old('admin_certificate.0' )}}" class="form-control  @error('admin_certificate.0') is-invalid @enderror">
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
                                                    <input type="text" placeholder="Document Name" name="admin_document_name[{{ $i }}]" value="{{ old('admin_document_name.' . $i )}}" class="form-control  @error('admin_document_name.' . $i) is-invalid @enderror">
                                                    @error('admin_document_name.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="file" name="admin_certificate[{{ $i }}]" value="{{ old('admin_certificate.' . $i )}}" class="form-control  @error('admin_certificate.' . $i) is-invalid @enderror">
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
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

    <script>

        const slug = '';
        var i = 1;
        var j = 1
        jQuery(function() {
            jQuery('select#site').selectric();
        });
        var current_element ;
        jQuery(document).ready(function() {



            //  validation if doc is uploaded
            $('input[name^="admin_certificate"]').change(function() {
                var admin_certificate_input = $(this);
                var admin_document_name_input = $('input[name^="admin_document_name"]');
                // Check if admin_certificate input is not empty
                if (admin_certificate_input.val() != '') {
                    admin_document_name_input.addClass('admin-document-name');
                } else {
                    admin_document_name_input.removeClass('admin-document-name');
                }

            });
                //validation if docname is filled
            $('input[name^="admin_document_name"]').change(function() {
                var admin_certificate_Name = $(this);
                var admin_certificate = $('input[name^="admin_certificate"]');
                if (admin_certificate_Name.val() != '') {
                    admin_certificate.addClass('worker-certificate');
                } else {
                    admin_certificate.removeClass('worker-certificate');
                    admin_certificate.removeClass('is-invalid');
                }
            });


            //
                // datereange picker
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
                // end of date range picker
            // if (authUserRole == 'admin') {
                jQuery('.architectId').on('change', function() {
                    current_element = $(this);
                    if (jQuery(this).val()) {
                        let architectSlug = jQuery(this).find(':selected').attr('data')
                        let params = {
                            'slug': architectSlug,
                        };
                        let url = APP_URL + '/' + authUserRole + "/architect/site";
                        let response = ajaxCall(url, 'get', params);
                        response.then(handleSite).catch(handleSiteError)
                    } else {
                        let options = '<option disabled>Select Site</option>';
                        let contractor_list = '<option disabled>Select Contractor</option>';
                        jQuery('#site').html(options);
                        @if ($authUser->role == 'admin')
                        jQuery('#main_contractor').html(contractor_list);
                        @endif
                        jQuery('select#site').selectric('refresh');
                    }
                })
            // }

            // working on add more docs
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

            // should end here

        });

        function handleSite(response) {

            if (response.status) {
                let options = '<option disabled>Select Site</option>';
                let contractor_list = '<option selected disabled>Select Contractor</option>';
                response.data.sites.forEach(site => {
                    options += `<option value="${site.id}">${site.name}</option>`;
                });
                response.data.contractors.forEach(contractor => {
                    contractor_list += `<option value="${contractor.id}" data="${contractor.slug}">${contractor.first_name}</option>`;
                });
                @if ($authUser->role == 'admin')
                // console.log();
                if( current_element.attr("id") != "main_contractor" )
                jQuery('#main_contractor').html(contractor_list);
                @endif
                jQuery('#site').html(options);
                jQuery('select#site').selectric('refresh');
            }
        }

        function handleSiteError(error) {
            console.log('error', error)
        }

    </script>
    @includeFirst(['validation.js_contractor'])
@endpush
