<script>  
  jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: nameMinLength,
                maxlength: nameMaxLength,
                regex: nameRegex,
            },

            email: {
                required: true,
                email:true,
                regex: emailRegex,
            },
            profile_pic: {
                required: true,
                filesize: profilePicSize,
                extension: profilePicMimes,
            },
        }
        const messages = {
            name: {
                required:  `{{ __('customvalidation.profile.name.required') }}`,
                minlength: `{{ __('customvalidation.profile.name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.profile.name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.profile.name.regex', ['regex' => '${nameRegex}']) }}`,
            },
            email: {
                required: `{{__('customvalidation.profile.email.required') }}`,
                email: `{{__('customvalidation.profile.email.email') }}`,
                regex: `{{ __('customvalidation.profile.email.regex', ['regex' => '${emailRegex}']) }}`,
            },
            profile_pic: {
                required: `{{ __('customvalidation.profile.profile_pic.required') }}`,
                filesize: `{{ __('customvalidation.profile.profile_pic.size', ['min' =>'${profilePicSize}'])}}`,
                extension: `{{ __('customvalidation.profile.profile_pic.mimes', ['mime' => '${profilePicMimes}']) }}`,
            },
        };

        handleValidation('profile', rules, messages);        
    });
</script>