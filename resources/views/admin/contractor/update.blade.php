@extends('layouts.admin')
@section('title', 'Update Contractor')

@section('content')
{{-- @dd($user->contractor->c_id); --}}
{{-- [11:42 AM] Gurjit  Singh
 @if($errors)
@foreach ($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach
 @endif --}}
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
                                <h4>Update Contractor</h4>
                                <div class="card-header-form">
                                    <a class="btn btn-primary btn-lg float-end"
                                        href="{{ route('admin.contractors') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="contractor" action="{{ route($authUser->role.'.update.contractor', [$user->slug]) }}"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Contact name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $user->first_name }}">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                {{-- name to  company_name--}}
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" value="{{!is_null($user->contractor->company_name) ? $user->contractor->company_name : ''}}" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{--  --}}

                                    @if ($authUser->role == 'admin')
                                        <div class="form-group">
                                            <label>Select Main Contractor</label>
                                            <select name="architect_id" id="architectId" class="form-control architect-id @error('architect_id') is-invalid @enderror">
                                                <option disabled>Select Main Contractor</option>
                                                @foreach ($projectManagers as $projectManager)
                                                    <option value="{{ $projectManager->id }}" data="{{ $projectManager->slug }}" @if ($projectManager->id == $user->contractor->manager_id) selected @endif>{{ $projectManager->first_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('architect_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        @endif
                                         {{-- select contractor --}}


                                      <div class="form-group">
                                        <label>Subcontractor of</label>
                                        <select name="main_contractor" id="main_contractor" class=" architect-id form-control">
                                            <option value="">Select Contractor</option>
                                            @foreach ($main_contractors as $main_contractor)


                                                <option value="{{ $main_contractor->id }}" data="{{ $main_contractor->slug }}" {{($main_contractor->id == $user->contractor->contractor_id) ? 'selected' : ''}}  > {{ $main_contractor->first_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- end selection of contractor --}}
                                        @if ($authUser->role == 'admin')
                                        <div class="form-group">
                                            <label>Construction Site</label>
                                            <select name="construction_site[]" id="site"
                                                class="form-control selectric @error('construction_site') is-invalid @enderror @error('construction_site.*') is-invalid @enderror"
                                                multiple="multiple">
                                                <option disabled value="">Select Construction Site</option>
                                                    @foreach ($sites as $site)
                                                        <option value="{{ $site->id }}" {{ in_array($site->id, $constructionSite) ? 'selected' : '' }}>{{ $site->name }}</option>
                                                    @endforeach
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
                                    @else
                                        <div class="form-group">
                                            <label>Construction Site</label>
                                            <select name="construction_site[]" id="site"
                                                class="form-control selectric @error('construction_site') is-invalid @enderror @error('construction_site.*') is-invalid @enderror"
                                                multiple="multiple">
                                                <option disabled>Select Construction Site</option>
                                                    @foreach ($sites as $site)
                                                        <option value="{{ $site->site_id }}" {{ in_array($site->site_id, $constructionSite) ? 'selected' : '' }}>{{ $site->site->name }}</option>
                                                    @endforeach
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
                                    @endif


                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" name="location"
                                            class="form-control @error('location') is-invalid @enderror"
                                            value="{{ $user->location }}">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" id="cpassword"
                                            class="form-control @error('password') is-invalid @enderror" value="">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            value="">
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
                                    {{-- admin strrrr doc --}}
                                    <div id="AdministrativeAddMore" class="form-group">
                                        <label> Upload Documents</label>
                                        {{--  --}}
                                        @if(isset($user->contractorDocuments[0]->valid_between) && !is_null($user->contractorDocuments[0]->valid_between))
                                        @php
                                            $validDate = strtotime($user->contractorDocuments[0]->valid_between);
                                            $remainingDays = floor(($validDate - time()) / (60 * 60 * 24)) + 2;
                                        @endphp
                                        @if($remainingDays <= 0)
                                            <p class="text-warning">Document is already expired</p>
                                        @elseif($remainingDays == 1)
                                            <p class="text-warning">Document will expire in 1 day</p>
                                        @elseif($remainingDays <= 10)
                                            <p class="text-warning">Document will expire in {{ $remainingDays }} days</p>
                                        @endif
                                        @endif


                                {{--  --}}
                                        <div class="certificate-outer">
                                            <div class="certificate-input">
                                                {{--  --}}

                                                {{-- @dd($user->contractorDocuments); --}}
                                                <input type="text" placeholder="Document Name" name="admin_document_name[0]" value="{{ old('admin_document_name.0', $user->contractorDocuments[0]->document_name ?? '') }}" class="form-control @if ($user->contractorDocuments->count() != 0) admin-document-name @endif    @error('admin_document_name.0') is-invalid @enderror">
                                                @error('admin_document_name.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="certificate-choose-file">
                                                <input type="hidden" name="old_admin_certificate[0]" @if ($user->contractorDocuments->count()) value="{{ $user->contractorDocuments[0]->id }}" @endif>
                                                <input type="hidden" name="old_admin_certificate_name[0]" @if (isset($user->contractorDocuments[0]) && !is_null($user->contractorDocuments[0]->uploaded_file_name)) value="{{ $user->contractorDocuments[0]->uploaded_file_name }}" @endif>
                                                <input type="hidden" name="old_admin_certificate_url[0]" @if (isset($user->contractorDocuments[0]) && !is_null($user->contractorDocuments[0]->uploaded_file_url)) value="{{ $user->contractorDocuments[0]->uploaded_file_url }}" @endif>
                                                <input type="file" name="admin_certificate[0]" value="{{ old('admin_certificate.0') }}" class="form-control  @error('admin_certificate.0') is-invalid @enderror">

                                                @error('admin_certificate.0')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                @if ($user->contractorDocuments->count() && !is_null($user->contractorDocuments[0]->uploaded_file_url))
                                                    <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $user->contractorDocuments[0]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $user->contractorDocuments[0]->uploaded_file_url) }}">{{ $user->contractorDocuments[0]->uploaded_file_name }}</a>
                                                @endif
                                            </div>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" id = "AdminDates0" name="admin_dates[0]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.0', $user->contractorDocuments[0]->valid_between ?? '') }}">
                                            </div>
                                            <button class="btn btn-primary" type="button" id="addMoreAdmin">Add</button>
                                        </div>

                                        @for($i = 1; $i <= old('admin_certificate_count', $user->contractorDocuments->count()) - 1; $i++)
                                        {{--  --}}
                                        @if(!is_null($user->contractorDocuments[$i]->valid_between))
                                        @php
                                          $validDate = strtotime($user->contractorDocuments[$i]->valid_between);
                                          $remainingDays = floor(($validDate - time()) / (60 * 60 * 24)) + 2;
                                        @endphp
                                        @if($remainingDays <= 0)
                                          <label class="text-warning">Document is already expired</label>
                                        @elseif($remainingDays == 1)
                                          <label class="text-warning">Document will expire in 1 day</label>
                                        @elseif($remainingDays <= 10)
                                          <label class="text-warning">Document will expire in {{ $remainingDays }} days</label>
                                        @endif
                                      @endif



                                        {{--  --}}
                                            <div class="certificate-outer">
                                                <div class="certificate-input">
                                                    <input type="text" placeholder="Document Name" name="admin_document_name[{{ $i }}]" value="{{ old('admin_document_name.' . $i, $user->contractorDocuments[$i]->document_name ?? '')}}" class="form-control @if (isset($user->contractorDocuments[$i])) admin-document-name @endif @error('admin_document_name.' . $i) is-invalid @enderror">
                                                    @error('admin_document_name.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="certificate-choose-file">
                                                    <input type="hidden" name="old_admin_certificate[{{ $i }}]" class="old-certificate" @if (isset($user->contractorDocuments[$i])) value="{{ $user->contractorDocuments[$i]->id }}" @endif>
                                                    <input type="hidden" name="old_admin_certificate_name[{{ $i }}]" @if (isset($user->contractorDocuments[$i]) && !is_null($user->contractorDocuments[$i]->uploaded_file_name)) value="{{ $user->contractorDocuments[$i]->uploaded_file_name }}" @endif>
                                                    <input type="hidden" name="old_admin_certificate_url[{{ $i }}]" @if (isset($user->contractorDocuments[$i]) && !is_null($user->contractorDocuments[$i]->uploaded_file_url)) value="{{ $user->contractorDocuments[$i]->uploaded_file_url }}" @endif>
                                                    <input type="file" name="admin_certificate[{{ $i }}]" value="{{ old('admin_certificate.' . $i )}}" class="form-control @error('admin_certificate.' . $i) is-invalid @enderror">
                                                    @error('admin_certificate.' . $i)
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    @if (isset($user->contractorDocuments[$i]) && !is_null($user->contractorDocuments[$i]->uploaded_file_url))
                                                        <a style="text-decoration:none" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="sendData('{{ $user->contractorDocuments[$i]->uploaded_file_url }}')" target="_blank" href="{{ asset('storage/' . $user->contractorDocuments[$i]->uploaded_file_url) }}">{{ $user->contractorDocuments[$i]->uploaded_file_name }}</a>
                                                    @endif
                                                </div>

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="admin_dates[{{ $i }}]" class="form-control admin-daterange-cus" placeholder="Select Expiry Date" value="{{ old('admin_dates.' . $i, $user->contractorDocuments[$i]->valid_between ?? '') }}">
                                                </div>
                                                <button class="btn btn-danger admin_doc_remove" type="button">Remove </button>
                                            </div>
                                        @endfor
                                    </div>
                                    {{-- ends here --}}
                                    {{--
                                    <div class="form-group">
                                        <label>Certificate</label>
                                        <input type="file" name="certificate" value="{{ old('certificate') }}"
                                            class="form-control @error('certificate') is-invalid @enderror">
                                        @error('certificate')
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    --}}
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Update</button>
                                <button class="btn btn-secondary" type="reset">Reset</button>
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
        const slug = '{{ $user->slug }}';
        const contractorId = '{{$user->id}}'
        var j = +"{{ $user->contractorDocuments->count() > 0 ? $user->contractorDocuments->count() : 1 }}";


        var current_element ;
        function sendData(url) {
            document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
        };
        jQuery(document).ready(function() {


            @if ($user->contractorDocuments->count() == 0)
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
            @endif

            //

            jQuery('.architect-id').on('change', function() {
                current_element = $(this);
                let architectSlug = jQuery(this).find(':selected').attr('data');
                if( !architectSlug )
                    return;
                let params = {
                    'slug': architectSlug,
                };
                let url = APP_URL + "/admin/architect/site";
                let response = ajaxCall(url, 'get', params);
                response.then(handleStateData).catch(handleStateError)
            });

            //
            jQuery('input.admin-daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            jQuery('input.admin-daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
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
                                'contractor_id': contractorId,
                            };
                            let url = APP_URL + '/' + authUserRole + '/contractor/document/delete';
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
            if( $("#main_contractor").val() )
                $("#main_contractor").change();
            else
                $("[name=architect_id]").change();


        });

        function handleStateData(response) {
            jQuery('#site').empty();
            //jQuery('#main_contractor').empty();
            if (response.status) {
                let options = '<option disabled>Select Site</option>';
                let contractor_list = '<option selected disabled>Select Contractor</option>';
                response.data.sites.forEach(site => {
                    let selectedAttribute = '';
                    if( {{ Js::from( $constructionSite ) }}.includes(site.id) )
                    selectedAttribute = 'selected'
                    options += `<option value="${site.id}" ${selectedAttribute} >${site.name}</option>`;
                });

                response.data.contractors.forEach(contractor => {
                    contractor_list += `<option value="${contractor.id}" data="${contractor.slug}">${contractor.first_name}</option>`;
                });

                $('#site').html(options);
                @if ($authUser->role == 'admin')
                if( current_element.attr("id") != "main_contractor" )
                jQuery('#main_contractor').html(contractor_list);
                @endif

                $('select#site').selectric('refresh');
            }
        }

        function handleStateError(error) {
            console.log('error', error)
        }
    </script>
    @includeFirst(['validation.js_contractor'])
@endpush
