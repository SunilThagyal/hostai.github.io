@extends('layouts.admin')
@section('title', 'Uploaded documents')

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
<div class="main-content" style="min-height: 874px;">
    <section class="section">

        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4> Uploaded Documents</h4>
                    </div>
                    <div class="card-body">
                        {{--  --}}

                        {{-- admin strrrr doc --}}
                        <div id="AdministrativeAddMore" class="form-group">
                            <label> Upload Documents</label>
                            @forelse ($documents as $document)
                                {{--  --}}
                                {{--  --}}
                                @if (isset($document->valid_between) && !is_null($document->valid_between))
                                    @php
                                        $validDate = strtotime($document->valid_between);
                                        $remainingDays = floor(($validDate - time()) / (60 * 60 * 24)) + 2;
                                    @endphp
                                    @if ($remainingDays <= 0)
                                        <p class="text-warning">Document is already expired</p>
                                    @elseif($remainingDays == 1)
                                        <p class="text-warning">Document will expire in 1 day</p>
                                    @elseif($remainingDays <= 10)
                                        <p class="text-warning">Document will expire in {{ $remainingDays }}
                                            days</p>
                                    @endif
                                    @else
                                    @php
                                    // undefined
                                    $remainingDays = 100;
                                    @endphp
                                @endif
                                {{-- @dd($documents); --}}
                                {{-- {{jsencode_userdata($document->id),$document->id }} --}}
                                {{-- @dump($remainingDays) --}}
                                <form id="form-{{ $document->id }}"
                                    @if ($remainingDays <= 0) action="{{ route('subcontractor.document.reupload.expired', ['docs_id' => jsencode_userdata($document->id)]) }}" @endif
                                    method="post" class="validate-form" enctype="multipart/form-data">
                                    <div class="certificate-outer">
                                        <div class="certificate-input">
                                            @csrf
                                            <input type="text" placeholder="Document Name" @if( $remainingDays <= 0 )
                                                name="document[{{ $document->id }}][admin_document_name]" @else disabled @endif
                                                value="{{ old('admin_document_name', $document->document_name ?? '') }}"
                                                class="form-control admin-document-name  @if ($remainingDays <= 0) @error('document.' . $document->id . '.admin_document_name') is-invalid @enderror @endif">
                                            @if ($remainingDays <= 0)
                                                @error('document.' . $document->id . '.admin_document_name')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('document.' . $document->id . '.admin_document_name') }}</strong>
                                                    </span>
                                                @enderror
                                            @endif
                                        </div>
                                        {{-- @if ($remainingDays <= 0) --}}
                                        <div class="certificate-choose-file">
                                            <input type="file" @if( $remainingDays <= 0 ) name="document[{{ $document->id }}][certificate]" @else disabled @endif
                                                value="{{ old('admin_certificate') }}"
                                                class="form-control admin-worker-certificate  @if ($remainingDays <= 0) @if ($errors->has('document.' . $document->id . '.certificate')) is-invalid @endif @endif ">

                                                @if ($errors->has('document.' . $document->id . '.certificate'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('document.' . $document->id . '.certificate') }}</strong>
                                                    </span>
                                                @endif

                                            <a style="text-decoration:none" data-toggle="modal"
                                                data-target=".bd-example-modal-lg"
                                                onclick="sendData('{{ $document->uploaded_file_url }}')"
                                                target="_blank"
                                                href="{{ asset('storage/' . $document->uploaded_file_url) }}">{{ $document->uploaded_file_name }}</a>

                                        </div>
                                        {{-- @endif --}}
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="AdminDates0"
                                            @if( $remainingDays <= 0 ) name=admin_dates @else disabled @endif
                                                class="form-control admin-daterange-cus"
                                                placeholder="Select Expiry Date"
                                                value="{{ old('admin_dates', $document->valid_between ?? '') }}">
                                        </div>
                                        @if ($remainingDays <= 0 && $documents->count() && !is_null($document->uploaded_file_url))
                                            <button id="addMoreAdmin" class="btn btn-primary"
                                                type="submit">Update</button>
                                        @endif
                                    </div>
                                </form>

                            @empty
                                <p>no document </p>
                            @endforelse


                        </div>
                        {{-- ends here --}}

                        {{--  --}}
                        {{-- <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
     function sendData(url) {
        document.getElementById("recivedData").src = APP_URL + '/storage/' + url;
    };

        jQuery('input.admin-daterange-cus').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                minDate: moment(),
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            jQuery('input.admin-daterange-cus').on('apply.daterangepicker', function(ev, picker) {
                jQuery(this).val(picker.startDate.format('YYYY-MM-DD'));
            });
</script>
<script>
    $(document).ready(function() {
        $(".validate-form").each(function(){
            handleValidation( $(this) , {} , {} );
        });

        $('button[type="submit"]').click(function(event) {
            // var form = $(this).closest('form');
            // var formId = $(form).attr('id');
            // var validator = $('#' + formId).validate();

            // if (!validator.form()) {
            //     event.preventDefault();
            // }
        });
    });
</script>


@endpush

