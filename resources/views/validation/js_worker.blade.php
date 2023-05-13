<script>
  jQuery(document).ready(function(){
        const rules = {
            first_name: {
                required: true,
                minlength: firstNameMinLength,
                maxlength: firstNameMaxLength,
                regex: firstNameRegex,
            },
            last_name: {
                minlength: nameMinLength,
                maxlength: nameMaxLength,
                regex: nameRegex,
            },
            worker_id: {
                required: true,
            },
            workerof:{
                required:true
            },
            construction_site: {
                required: true,
            },
            // location: {
            //     required: true,
            //     minlength: locationMinLength,
            //     maxlength: locationMaxLength,
            //     regex: locationRegex,
            // },
            employment_type: {
                required: true,
            },
            profile_pic: {
                filesize:profilePicSize,
                extension: profilePicMimes,
            },
            csv_file: {
                required: true,
                accept: "csv"
            },
            // "document_name[]": {
            //     required: true
            // },
            "certificate[]": {
                required: function() {
                    if (slug != '') {
                        return false;
                    }
                },
                filesize: certificateSize,
                extension: certificateMimes
            }
            // certificate: {
            //     required: function(element) {
            //         if (slug != '') {
            //             return false;
            //         }
            //         return true;
            //     },
            //     filesize: certificateSize,
            //     extension: certificateMimes,
            // },

        }
        const messages = {

            first_name: {
                required:  `{{ __('customvalidation.worker.firstName.required') }}`,
                minlength: `{{ __('customvalidation.worker.firstName.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.worker.firstName.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.worker.firstName.regex', ['regex' => '${nameRegex}']) }}`,
            },
            last_name: {
                minlength: `{{ __('customvalidation.worker.name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.worker.name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.worker.name.regex', ['regex' => '${nameRegex}']) }}`,
            },
            worker_id: {
                required:  `{{ __('customvalidation.worker.worker_id.required') }}`,
            },
            workerof:{
                required:  `{{ __('customvalidation.worker.workerof.required') }}`,
            },
            construction_site: {
                required:  `{{ __('customvalidation.worker.construction_site.required') }}`,
            },
            employment_type: {
                required:  `{{ __('customvalidation.worker.employment_type.required') }}`,
            },
            // location: {
            //     required:  `{{ __('customvalidation.worker.location.required') }}`,
            //     minlength: `{{ __('customvalidation.worker.location.min', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
            //     maxlength: `{{ __('customvalidation.worker.location.max', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
            //     regex:     `{{ __('customvalidation.worker.location.regex', ['regex' => '${locationRegex}']) }}`,
            // },
            profile_pic: {
                required: `{{ __('customvalidation.worker.profile_pic.required') }}`,
                filesize: `{{ __('customvalidation.worker.profile_pic.size', ['min' =>'${profilePicSize}'])}}`,
                extension: `{{ __('customvalidation.worker.profile_pic.mimes', ['mime' => '${profilePicMimes}']) }}`,
            },
            csv_file: {
                required: '{{ __("customvalidation.worker.csv_file.required")}}',
                accept: '{{ __("customvalidation.worker.csv_file.valid_type")}}'
            }
            // certificate: {
            //     required: `{{ __('customvalidation.worker.certificate.required') }}`,
            //     filesize: `{{ __('customvalidation.worker.certificate.size', ['min' => '${certificateSize}']) }}`,
            //     extension: `{{ __('customvalidation.worker.certificate.mimes', ['mime' => '${certificateMimes}']) }}`,
            // },
        };

        handleValidation('worker', rules, messages);

    });
</script>
