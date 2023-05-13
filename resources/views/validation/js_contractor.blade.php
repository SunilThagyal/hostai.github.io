<script>
  jQuery(document).ready(function(){
        const rules = {
            name: {
                required: true,
                minlength: nameMinLength,
                maxlength: nameMaxLength,
                regex: nameRegex,
            },
            company_name: {
                required: true,
                minlength: companyNameMinLength,
                maxlength: companyNameMaxLength,
                regex: companyNameRegex,
            },
            construction_site: {
                required: true,
            },
            location: {
                required: true,
                minlength: locationMinLength,
                maxlength: locationMaxLength,
                regex: locationRegex,
            },
            email: {
                required: true,
                email:true,
                regex: emailRegex,
            },
            password: {
                required: function(element) {
                    if (slug != '') {
                        return false;
                    }
                    return true;
                },
                minlength: passwordMinLength,
                maxlength:passwordMaxLength,
                regex: passwordRegex,

            },
            confirm_password:{
                required:function(element) {
                    if (slug != '') {
                        return false;
                    }
                    return true;
                },
                equalTo : "#cpassword"
            },
            profile_pic: {
                required: function(element) {
                    if (slug != '') {
                        return false;
                    }
                    return false;
                },
                filesize:profilePicSize,
                extension: profilePicMimes,

            },
        }
        const messages = {
            name: {
                required:  `{{ __('customvalidation.contractor.contact_name.required') }}`,
                minlength: `{{ __('customvalidation.contractor.contact_name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.contractor.contact_name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.contractor.contact_name.regex', ['regex' => '${nameRegex}']) }}`,
            },
            company_name: {
                required:  `{{ __('customvalidation.contractor.company_name.required') }}`,
                minlength: `{{ __('customvalidation.contractor.company_name.min', ['min' => '${companyNameMinLength}', 'max' => '${companyNameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.contractor.company_name.max', ['min' => '${companyNameMinLength}', 'max' => '${companyNameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.contractor.company_name.regex', ['regex' => '${companyNameRegex}']) }}`,
            },
            construction_site: {
                required:  `{{ __('customvalidation.contractor.construction_site.required') }}`,
            },
            location: {
                required:  `{{ __('customvalidation.contractor.location.required') }}`,
                minlength: `{{ __('customvalidation.contractor.location.min', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.contractor.location.max', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.contractor.location.regex', ['regex' => '${locationRegex}']) }}`,
            },
            email: {
                required: `{{__('customvalidation.contractor.email.required') }}`,
                email: `{{__('customvalidation.contractor.email.email') }}`,
                regex: `{{ __('customvalidation.contractor.email.regex', ['regex' => '${emailRegex}']) }}`,
            },
            password: {
                required: `{{ __('customvalidation.contractor.password.required') }}`,
                minlength: `{{ __('customvalidation.contractor.password.min', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.contractor.password.max', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('customvalidation.contractor.password.regex', ['regex' => '${passwordRegex}']) }}`,

            },
            confirm_password:{
                equalTo :`{{ __('customvalidation.contractor.confirm_password.equal') }}`,
                required:`{{ __('customvalidation.contractor.confirm_password.required') }}`,
            },
            profile_pic: {
                required: `{{ __('customvalidation.worker.profile_pic.required') }}`,
                filesize: `{{ __('customvalidation.worker.profile_pic.size', ['min' =>'${profilePicSize}'])}}`,
                extension: `{{ __('customvalidation.worker.profile_pic.mimes', ['mime' => '${profilePicMimes}']) }}`,
            },
        };

        handleValidation('contractor', rules, messages);

    });
</script>
