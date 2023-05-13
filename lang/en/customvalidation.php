<?php

use Symfony\Contracts\Service\Attribute\Required;

return [
    'login' => [
        'email' => [
            'required' => 'Please enter the email',
            'email' => 'This is not a valid email address',
            'regex' => 'Please enter the valid email address',
        ],
        'password' => [
            'required' => 'Please enter the password',
            'min' => 'Password can be :min - :max characters',
            'max' => 'Password can be :min - :max characters',
            'regex' => 'Password can be alphanumeric and (@#$%^&*) these special characters *At least one uppercase *One lowercase *One numeric',

        ],
    ],
    'change_password' => [
        'old_password' => [
            'required' => 'Please enter the old password',
            'min' => 'Password can be :min - :max characters',
            'max' => 'Password can be :min - :max characters',
            'regex' => 'Enter a valid password',

        ],
        'password' => [
            'required' => 'Please enter the new password',
            'min' => 'Password can be :min - :max characters',
            'max' => 'Password can be :min - :max characters',
            'regex' => 'Password can be alphanumeric and (@#$%^&*) these special characters *At least one uppercase *One lowercase *One numeric',

        ],
        'confirm_password' => [
            'required' => 'Please enter the confirm password',

        ],
    ],

    'admin' => [
        'name' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets and in between space are allowed',
        ],
        'phone_number' => [
            'required' => 'Please enter the phone number',
            'digits' => 'Phone number must be of :digits',
            'phoneUS' => 'Phone number must be of :digits digits',
        ],
        'email' => [
            'required' => 'Please enter your email',
            'email' => 'This is not a valid email address',
            'regex' => 'Please enter the valid email address',
        ],
        'profile_pic' => [
            'required' => 'Please upload your profile picture',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only JPEG, JPG, PNG file type'
        ],
    ],
    'profile' => [
        'name' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets and in between space are allowed',
        ],
        'email' => [
            'required' => 'Please enter your email',
            'email' => 'This is not a valid email address',
            'regex' => 'Please enter the valid email address',
        ],
        'profile_pic' => [
            'required' => 'Please upload your profile picture',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only JPEG, JPG, PNG file type'
        ],
    ],

    'site' => [
        'name' => [
            'required' => 'Please enter the site name',
            'unique' => 'Site is already taken',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets and in between space are allowed',
            'string' => 'Only alphabets space are allowed',
        ],
    ],

    'architect' => [
        'name' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'string' => 'Only alphabets and in between space are allowed',
            'regex' => 'Only alphabets and in between space are allowed',

        ],
        'construction_site' => [
            'required' => 'Please select the construction site',
            'exists' => 'Selected site does not exist',
        ],
        'location' => [
            'required' => 'Location field is required',
            'min' => 'Location can be :min - :max characters',
            'max' => 'Location can be :min - :max characters',
            'regex' => 'Please Enter a valid loction',
        ],
        'profile_pic' => [
            'required' => 'Please upload  profile picture',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only JPEG, JPG, PNG file type'
        ],
        'certificate' => [
            'required' => 'Please upload certificate',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only pdf file type'
        ],
        'password' => [
            'required' => 'Please enter the password',
            'min' => 'Password can be :min - :max characters',
            'max' => 'Password can be :min - :max characters',
            'regex' => "Password can be alphanumeric and (@#$%^&*) these special characters *At least one uppercase *One lowercase *One numeric",

        ],
        'confirm_password' => [
            'required' => 'Please enter the confirm password',
            'equal' => 'Password and confirm password must be same',

        ],
        'email' => [
            'required' => 'Please enter your email',
            'email' => 'This is not a valid email address',
            'regex' => 'Please enter the valid email address',
            'unique' => 'Please enter the unique email',
        ],
    ],

    'contractor' => [
        'name' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Name should be greater than 2 characters only alphabets and in between space are allowed only',
        ],
        'contact_name' => [
            'required' => 'Please enter the contact name',
            'min' => 'contact name can be :min - :max characters',
            'max' => 'contact name can be :min - :max characters',
            'regex' => 'contact name should be greater than 2 characters only alphabets and in between space are allowed only',
        ],
        'company_name' => [
            'required' => 'Please enter the company name',
            'min' => 'company name can be :min - :max characters',
            'max' => 'company name can be :min - :max characters',
            'regex' => 'Enter a valid company name',
        ],
        'construction_site' => [
            'required' => 'Please select the construction site',
            'exists' => 'Selected site does not exist',
        ],
        'architect_id' => [
            'required' => 'Please select the project manager',
        ],
        'password' => [
            'required' => 'Please enter the password',
            'min' => 'Password can be :min - :max characters',
            'max' => 'Password can be :min - :max characters',
            'regex' => 'Password can be alphanumeric and (@#$%^&*) these special characters *At least one uppercase *One lowercase *One numeric',

        ],
        'confirm_password' => [
            'required' => 'Please enter the confirm password',
            'equal' => 'Password and confirm password must be same',

        ],
        'email' => [
            'required' => 'Please enter your email',
            'email' => 'This is not a valid email address',
            'regex' => 'Please enter the valid email address',
            'unique' => 'Please enter the unique email address',

        ],
        'location' => [
            'required' => 'Location field is required ',
            'min' => 'Location can be :min - :max characters',
            'max' => 'Location can be :min - :max characters',
            'regex' => 'Please Enter a valid loction',
        ],
        'profile_pic' => [
            'required' => 'Please upload  profile picture',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only JPEG, JPG, PNG file type'
        ],
        'comment' => [
            'required' => 'Please enter the rejection reason',
            'min' => 'Rejection reason can be :min - :max characters',
            'max' => 'Rejection reason can be :min - :max characters',
            'string' => 'Only alphabets and in between space are allowed',
        ],
        'document_name' => [
            'required' => 'Please enter the document name',
            'max' => 'Document name can be max 30 characters',
        ],
        'certificate' => [
            'required' => 'Please upload this Document',
            'max' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only pdf,jpg,jpeg,png file type',
        ],


    ],

    'worker' => [
        'name' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets and in between space are allowed',
        ],

        'firstName' => [
            'required' => 'This field is required*',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets are allowed in first name',
        ],

        'lastName' => [
            'required' => 'Please enter the name',
            'min' => 'Name can be :min - :max characters',
            'max' => 'Name can be :min - :max characters',
            'regex' => 'Only alphabets are allowed in last name',
        ],

        'employment_type' => [
            'required' => 'Please select employment type',
        ],
        'workerof'  =>[
            'required'  =>  'Please select contractor'
        ],
        'construction_site' => [
            'required' => 'Please select the construction site',
        ],
        'location' => [
            'required' => 'Location field is required',
            'min' => 'Location can be :min - :max characters',
            'max' => 'Location can be :min - :max characters',
            'regex' => 'Please enter a valid loction',
        ],
        'profile_pic' => [
            'required' => 'Please upload  profile picture',
            'size' => 'File size should not be greater 2 MB',
            'mimes' => 'Supported only JPEG, JPG, PNG file type'
        ],
        'csv_file' => [
            'required' => 'Please upload csv file',
            'valid_type' => 'Please upload csv file only',
        ],
        'certificate' => [
            'required' => 'Please upload certificate',
            'required_without' => 'Please upload certificate',
            'size' => 'File size should not be greater than 2 MB',
            'mimes' => 'Supported only pdf file type'
        ],
        'document_name' => [
            'required' => 'Document name is required',
        ],
        'dates' => [
            'required' => 'Please select the date',
            'format' => 'Invalid format of the date',
        ],
    ],
];
