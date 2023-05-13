<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "slug" => "contractor-register",
                "subject" => "Registerd Successfully",
                "content" => '
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="height: 50px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 16px;">Welcome to [MANAGER]’s TeeQode! Here are a few things you can do to get started on your journey with us. </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left">
                                                                        <p><strong>1. Get verified </strong></p>
                                                                        <p>Upload the required documents to get verified by [MANAGER]. </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="[IMG1]" alt="id-verified_hires" width="150">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left">
                                                                        <p><strong>2. Start uploading</strong></p>
                                                                        <p>Once verified you can now start uploading your workers and their safety documents.</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <img src="[IMG2]" alt="realtime-protection_hires" width="150">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Your account details: </b></td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="height: 5px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email: [EMAIL]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Password: [PASSWORD] </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 5px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                <td>To Login, click on the below: <br /><a href="[URL]"
                                                                        style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
                                                                </td>
                                                            </tr>
                                                                <tr>
                                                                    <td style="height: 10px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>The TeeQode Team</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>support@teeqode.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 50px;">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

            '
            ],
            [
                "slug " => "project-manger",
                "subject" => "Register Sucessfully",
                "content" => ' <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td style="height: 50px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px;">Welcome to TeeQode!</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Congratulations on starting your journey with TeeQode. We’re excited to present you our safety management system. </td>
                    </tr>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Your account details: </b></td>
                    </tr>

                    <tr>
                        <td style="height: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Email: [EMAIL]</td>
                    </tr>
                    <tr>
                        <td>Password: [PASSWORD]</td>
                    </tr>
                    <tr>
                        <td style="height: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>To Login, click on the below: <br /><a href="[URL]"
                                style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
                    </td>
                    </tr>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>The TeeQode Team</td>
                    </tr>
                    <tr>
                        <td>support@teeqode.com</td>
                    </tr>
                    <tr>
                        <td style="height: 50px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>'
            ],
            [
                "slug " => "manager",
                "subject" => "Register Sucessfully",
                "content" => ' <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td style="height: 50px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px;">Welcome to TeeQode!</td>
                    </tr>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Congratulations on starting your journey with TeeQode. We’re excited to present you our safety management system. </td>
                    </tr>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Your account details: </b></td>
                    </tr>

                    <tr>
                        <td style="height: 5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Email: [EMAIL]</td>
                    </tr>
                    <tr>
                        <td>Password: [PASSWORD]</td>
                    </tr>
                <tr>
                    <td style="height: 5px;">&nbsp;</td>
                </tr>
                <tr>
                    <td>To Login, click on the below: <br /><a href="[URL]"
                            style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
                </td>
                    <tr>
                        <td style="height: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>The TeeQode Team</td>
                    </tr>
                    <tr>
                        <td>support@teeqode.com</td>
                    </tr>
                    <tr>
                        <td style="height: 50px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>'
            ],
            [
                "slug" => "forgot-password",
                "subject" => "Forgot password",
                "content" =>
                '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; background-color: #fff;text-align: center;">
                <tbody>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td style="height: 50px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" style="text-align: center;">
                                            <h1 class="heading" style="margin: 0;">Forgot your password?</h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 20px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 16px;">We received a request to reset the password for your account. </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="password-check_hires.png" alt="password-img" width="200">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>To reset your password, click on the below: <br /><a href="#" style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Reset Password</a></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>Or copy and paste the url into your browser to reset your password.</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>The TeeQode Team</td>
                                    </tr>
                                    <tr>
                                        <td>support@teeqode.com</td>
                                    </tr>
                                    <tr>
                                        <td style="height: 50px;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>'
            ],
            [
                "slug" => "document-expire",
                "subject" => "Your document will expire soon ",
                "content" =>
                '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; background-color: #fff;text-align: center;">
                    <tbody>
        <tr>
            <td style="width: 10%;"></td>
            <td style="width: 80%;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 50px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align: center;">
                                <h1 class="heading" style="margin: 0;">DOCUMENT VALIDITY REMAINDER </h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px;">Hi [CONTRACTOR], </td>
                        </tr>
                        <tr>
                            <td style="height: 10px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="height: 10px;">The [DOCUMENT] of [WORKER] will expire in
                                [TIME_LEFT].

                                Please update your document soon. </td>
                        </tr>
                        <tr>
                        <td style="height: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <img src="[IMG]" alt="password-img" width="200">
            </td>
        </tr>
        <tr>
            <td style="height: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td>To Login, click on the below: <br /><a href="[LOGIN]"
                    style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
            </td>
        </tr>
        <tr>
            <td style="height: 10px;">&nbsp;</td>
        </tr>
        <tr>
            <td>The TeeQode Team</td>
        </tr>
        <tr>
            <td>support@teeqode.com</td>
        </tr>
        <tr>
            <td style="height: 50px;">&nbsp;</td>
        </tr>
    </tbody>
</table>'],
            [
                "slug" => "contractor-document-expire",
                "subject" => "Your document will expire soon ",
                "content" =>
                '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; background-color: #fff;text-align: center;">
                    <tbody>
            <tr>
            <td style="width: 10%;"></td>
            <td style="width: 80%;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="height: 50px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align: center;">
                                <h1 class="heading" style="margin: 0;">DOCUMENT VALIDITY REMAINDER </h1>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-size: 16px;">Hi,</td>
                        </tr>
                        <tr>
                            <td style="height: 10px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="height: 10px;">The [DOCUMENT] of [Contractor] will expire in
                                [TIME_LEFT].

                                Please update your document soon. </td>
                        </tr>
                        <tr>
                        <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
            <td>
                <img src="[IMG]" alt="password-img" width="200">
            </td>
            </tr>
            <tr>
            <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
            <td>To Login, click on the below: <br /><a href="[LOGIN]"
                    style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
            </td>
            </tr>
            <tr>
            <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
            <td>The TeeQode Team</td>
            </tr>
            <tr>
            <td>support@teeqode.com</td>
            </tr>
            <tr>
            <td style="height: 50px;">&nbsp;</td>
            </tr>
            </tbody>
            </table>'],
    [
        "slug" => "reject-worker",
        "subject" => "Worker rejected",
        "content" =>
        '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; background-color: #fff;text-align: center;">
            <tbody>
    <tr>
    <td style="width: 10%;"></td>
    <td style="width: 80%;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td style="height: 20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-size: 16px;">Hi [CONTRACTOR], </td>
                </tr>
                <tr>
                    <td style="height: 10px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="height: 10px;"> Please update [WORKER]&apos;s documents.</td>
                </tr>
                <tr>
                <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <img src="[IMG]" alt="reject" width="150">
                </td>
            </tr>
                <tr>
                <td style="height: 10px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="height: 10px;"> Your message from [MAIN_CONTRACTOR] : </td>
                </tr>
                <tr>
                <td style="height: 10px;">&nbsp;</td>
                </tr>
                <tr>
                <td style="height: 10px;"> "[REMARK]" </td>
                </tr>
                <tr>
                <td style="height: 10px;">&nbsp;</td>
                </tr>
                <tr>
                <td>Login to view <br /><a href="[LOGIN]"
                        style="text-decoration: none;margin-top: 10px;display: inline-block; background-color: #000; color: #fff;padding: 8px 12px;">Login</a>
                </td>
                </tr>
                <tr>
                <td style="height: 10px;">&nbsp;</td>
                </tr>
                <tr>
                <td>The TeeQode Team</td>
                </tr>
                <tr>
                <td>support@teeqode.com</td>
                </tr>
                <tr>
                <td style="height: 50px;">&nbsp;</td>
                </tr>
                </tbody>
                </table>'
    ]

];
        EmailTemplate::insert($data);
    }
}
