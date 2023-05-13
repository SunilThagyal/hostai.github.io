<?php

use App\Models\Contractor;
use App\Models\User;

function get_manager_type()
{
    if( Request::route('type') == "main-manager" )
        return "Sub Manager";
    return "Sub Manager(View Only)";
    // return ucwords(str_replace("-", " ", Request::route('type')));
}

function get_parent_manager()
{
    $user = Auth::user();
    if ($user->role == config('constants.project-manager'))
        return $user->id;
    elseif ($user->role == config('constants.main-manager'))
        return $user->assignedManagers->project_manager_id;
    elseif ($user->role == config('constants.subcontractor')) {
        $managerId = Contractor::where('user_id', $user->id)->first();
        return $managerId->manager_id;
    }

    return null;
}

function get_userId($slug)
{
    $user = User::where('slug', $slug)->first();
    return $user->id;
}


if (!function_exists('jsencode_userdata')) {
    function jsencode_userdata($data, string $encryptionMethod = null, string $secret = null)
    {
        if (empty($data)) {
            return "";
        }
        $encryptionMethod = config('app.encryptionMethod');
        $secret = config('app.secrect');
        try {
            $iv = substr($secret, 0, 16);
            $jsencodeUserdata = str_replace('/', '!', openssl_encrypt($data, $encryptionMethod, $secret, 0, $iv));
            $jsencodeUserdata = str_replace('+', '~', $jsencodeUserdata);
            return $jsencodeUserdata;
        } catch (\Exception $e) {
            return null;
        }
    }
}
if (!function_exists('jsdecode_userdata')) {
    function jsdecode_userdata($data, string $encryptionMethod = null, string $secret = null)
    {
        if (empty($data))
            return null;
        $encryptionMethod = config('app.encryptionMethod');
        $secret = config('app.secrect');
        try {
            $iv = substr($secret, 0, 16);
            $data = str_replace('!', '/', $data);
            $data = str_replace('~', '+', $data);
            $jsencodeUserdata = openssl_decrypt($data, $encryptionMethod, $secret, 0, $iv);
            return $jsencodeUserdata;
        } catch (\Exception $e) {
            return null;
        }
    }
}
