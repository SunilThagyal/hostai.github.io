<script>  
    jQuery(document).ready(function() {
          const rules = {
              comment: {
                  required: true,
                  minlength: nameMinLength,
                  maxlength: nameMaxLength,
                  regex: nameRegex,
              },
          }
          const messages = {
              comment: {
                  required:  `{{ __('customvalidation.contractor.comment.required') }}`,
                  minlength: `{{ __('customvalidation.contractor.comment.min', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                  maxlength: `{{ __('customvalidation.contractor.comment.max', ['min' => '${nameMinLength}', 'max' => '${nameMaxLength}']) }}`,
                  regex:     `{{ __('customvalidation.contractor.comment.regex', ['regex' => '${nameRegex}']) }}`,
              },
          };
  
          handleValidation('rejectDocument', rules, messages);        
      });
  </script>