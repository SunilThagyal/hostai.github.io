<?php
return [
        'name_regex' =>'/^[^-\s][a-zA-Z\s]{2,50}$/',
        'name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'name_minlength' => 2,
        'name_maxlength' => 50,


        'company_name_regex' => '/^[a-zA-Z0-9&.\'\-\s]{2,50}$/',
        'company_name_minlength' => 2,
        'company_name_maxlength' => 80,


        'first_name_regex' =>'/^[a-zA-Z]{2,30}$/',
        'first_name_regex_message' =>  'Only alphabets allowed',
        'first_name_minlength' => 2,
        'first_name_maxlength' => 30,

        'last_name_regex' =>'/^[a-zA-Z]{2,30}$/',
        'last_name_regex_message' =>  'Only alphabets allowed',
        'last_name_minlength' => 2,
        'last_name_maxlength' => 30,

        'location_regex' => '/^[a-zA-Z]+[a-zA-Z\s\d@#&:,]{2,50}$/',
        'location_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s\d@#&:,.]{2,50}$/',
        'location_minlength' => 2,
        'location_maxlength' => 50,

        'php_profile_pic_mimes' => 'jpg,jpeg,png',
        'js_profile_pic_mimes' => 'jpg|jpeg|png',
        'php_profile_pic_size' => '2000',
        'js_profile_pic_size' => '2000000',

        'php_csv_file_mimes' => 'csv',
        'js_csv_file_mimes' => 'jpg|jpeg|png',
        'php_csv_file_size' => '2000',
        'js_csv_file_size' => '2000000',

        'php_certificate_mimes' => 'pdf,jpeg,jpg,png',
        'js_certificate_mimes' => 'pdf,jpeg,jpg,png',
        'php_certificate_size' => '2000',
        'js_certificate_size' => '2000000',

        'email_regex' => '/^[a-zA-Z0-9]+([._+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/',
        'email_regex_message' =>  '/^[a-zA-Z]+(?!.*[\_\-\.]{2}).*[a-zA-Z0-9_\.\-]{2,}[a-zA-Z0-9]{1}@[a-zA-Z]+(\.[a-zA-Z]+)?[\.]{0}[a-zA-Z]{2,10}$/',

        'password_regex' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*]{8,32}$/',
        'password_regex_message' =>  '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*]{8,32}$/',
        'password_minlength' => 8,
        'password_maxlength' => 32,
];
