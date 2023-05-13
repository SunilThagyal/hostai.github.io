<script>  
  jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: nameMinLength,
                maxlength: nameMaxLength,
                regex: nameRegex,
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
                minlength: passwordMinLength,
                maxlength:passwordMaxLength,
                regex: passwordRegex,
                
            },
            confirm_password:{
                equalTo: "#cpassword"
            },
            profile_pic: {
                filesize: profilePicSize,
                extension: profilePicMimes,
            },
        }
        const messages = {
            name: {
                required:  `{{ __('customvalidation.architect.name.required') }}`,
                minlength: `{{ __('customvalidation.architect.name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.architect.name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.architect.name.regex', ['regex' => '${nameRegex}']) }}`,
            },
            construction_site: {
                required:  `{{ __('customvalidation.architect.construction_site.required') }}`,
            },
            location: {
                required:  `{{ __('customvalidation.architect.location.required') }}`,
                minlength: `{{ __('customvalidation.architect.location.min', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.architect.location.max', ['min' => '${locationMinLength}', 'max' => '${locationMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.architect.location.regex', ['regex' => '${locationRegex}']) }}`,
            },
            email: {
                required: `{{__('customvalidation.architect.email.required') }}`,
                email: `{{__('customvalidation.architect.email.email') }}`,
                regex: `{{ __('customvalidation.architect.email.regex', ['regex' => '${emailRegex}']) }}`,
            },
            password: {
                required: `{{ __('customvalidation.architect.password.required') }}`,
                minlength: `{{ __('customvalidation.architect.password.min', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.architect.password.max', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('customvalidation.architect.password.regex', ['regex' => '${passwordRegex}']) }}`,

            },
            confirm_password:{
                equalTo :`{{ __('customvalidation.architect.confirm_password.equal') }}`,
                required:`{{ __('customvalidation.architect.confirm_password.required') }}`,
            },
            profile_pic: {
                required: `{{ __('customvalidation.architect.profile_pic.required') }}`,
                filesize: `{{ __('customvalidation.architect.profile_pic.size', ['min' =>'${profilePicSize}'])}}`,
                extension: `{{ __('customvalidation.architect.profile_pic.mimes', ['mime' => '${profilePicMimes}']) }}`,
            },
        };

        handleValidation('updateArchitect', rules, messages);        
    });
</script>