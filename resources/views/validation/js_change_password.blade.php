<script>  
  jQuery(document).ready(function(){
        const rules = {
            old_password: {
                required: true,
                minlength: passwordMinLength,
                maxlength:passwordMaxLength,
                regex: passwordRegex,
                
            },
            password: {
                required: true,
                minlength: passwordMinLength,
                maxlength:passwordMaxLength,
                regex: passwordRegex,
                
            },
            confirm_password:{
                required:true,
                equalTo : "#cpassword"
            },
        }
        const messages = {
            old_password: {
                required: `{{ __('customvalidation.change_password.old_password.required') }}`,
                minlength: `{{ __('customvalidation.change_password.old_password.min', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.change_password.old_password.max', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('customvalidation.change_password.old_password.regex', ['regex' => '${passwordRegex}']) }}`,

            },
            password: {
                required: `{{ __('customvalidation.change_password.password.required') }}`,
                minlength: `{{ __('customvalidation.change_password.password.min', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.change_password.password.max', ['min' => '${passwordMinLength}' , 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('customvalidation.change_password.password.regex', ['regex' => '${passwordRegex}']) }}`,

            },
            confirm_password:{
                equalTo :`{{ __('customvalidation.change_password.confirm_password.equal') }}`,
                required:`{{ __('customvalidation.change_password.confirm_password.required') }}`,
            },
        };

        handleValidation('changePassword', rules, messages);
        
    });
</script>