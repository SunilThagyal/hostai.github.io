<script>
    //name
    const nameRegex = {{ config('validation.name_regex') }};
    const nameMinLength = parseInt(`${nameRegex}`.match(/(?<={)\d+/)[0]);
    const nameMaxLength = parseInt(`${nameRegex}`.match(/\d+(?=})/)[0]);

    //company name
    const companyNameRegex ={{config('validation.company_name_regex')}};
    const companyNameMinLength = parseInt(`${companyNameRegex}`.match(/(?<={)\d+/)[0]);
    const companyNameMaxLength = parseInt(`${companyNameRegex}`.match(/\d+(?=})/)[0]);

    //firstname
    const firstNameRegex = {{ config('validation.first_name_regex') }};
    const firstNameMinLength = parseInt(`${firstNameRegex}`.match(/(?<={)\d+/)[0]);
    const firstNameMaxLength = parseInt(`${firstNameRegex}`.match(/\d+(?=})/)[0]);

    //firstname
    const lastNameRegex = {{ config('validation.last_name_regex') }};
    const lastNameMinLength = parseInt(`${lastNameRegex}`.match(/(?<={)\d+/)[0]);
    const lastNameMaxLength = parseInt(`${lastNameRegex}`.match(/\d+(?=})/)[0]);

     //email
    const emailRegex = {{ config('validation.email_regex') }};

     //password
    const passwordRegex = {{ config('validation.password_regex') }};
    const passwordMinLength = parseInt(`${passwordRegex}`.match(/(?<={)\d+/)[0]);
    const passwordMaxLength = parseInt(`${passwordRegex}`.match(/\d+(?=})/)[0]);

     //location
    const locationRegex = {{ config('validation.location_regex') }};
    const locationMinLength = parseInt(`${locationRegex}`.match(/(?<={)\d+/)[0]);
    const locationMaxLength = parseInt(`${locationRegex}`.match(/\d+(?=})/)[0]);

     //profile
    const profilePicMimes ="{{  config('validation.js_profile_pic_mimes') }}";
    const profilePicSize = "{{ config('validation.js_profile_pic_size') }}";

    //certificate
    const certificateMimes= "{{ config('validation.js_certificate_mimes') }}";
    const certificateSize = "{{ config('validation.js_certificate_size') }}";


</script>
