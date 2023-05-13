<script>  
  jQuery(document).ready(function(){
        const rules = {
            name: {
                required: true,
                minlength: nameMinLength,
                maxlength: nameMaxLength,
                regex: nameRegex,
            },
        }
        const messages = {
            name: {
                required:  `{{ __('customvalidation.site.name.required') }}`,
                minlength: `{{ __('customvalidation.site.name.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                maxlength: `{{ __('customvalidation.site.name.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                regex:     `{{ __('customvalidation.site.name.regex', ['regex' => '${nameRegex}']) }}`,
            },
        };

        handleValidation('site', rules, messages);
        
    });
</script>