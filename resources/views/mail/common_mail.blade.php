<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teeqode-email</title>
    <style>
        a {
            text-decoration: none;
        }
        @media (max-width: 767px) {
            div.container {
                width: 100% !important;
            }
            img {
                display: inline-block !important;
                width: 100% !important;
                max-width: 80% !important;
            }
            div img {
                max-width: 200px !important;
                display: inline-block !important;
            }
            table tr td {
                font-size: 13x !important;
                padding: 10px !important;
            }
            div {
                flex: wrap !important;
            }
            table tr td span {
                width: 25px !important;
                height: 20px !important;
                padding: 12px 10px !important;
            }
            table tr td button {
                max-width: 120px !important;
                font-size: 11px !important;
                padding: 10px 10px !important;
            }
            div {
                font-size: 13px !important;
                padding: 0 !important;
                display: inline-block !important;
                padding: 10px 0 0 0 !important;
            }
            table tr td div span {
                min-width: 35px;
                width: 35px !important;
                height: 35px !important;
                padding: 10px 10px !important;
            }
            table tr td div img {
                max-width: 80px !important;
                display: inline-block !important;
            }
            div div img {
                width: 100% !important;
                max-width: 80px !important;
                display: inline-block !important;
                padding: 0 !important;
            }
            div p {
                font-size: 13px !important;
            }
            .rating-stars img {
                max-width: 100px !important;
                min-width: 100px !important;
            }
        }
        @media (max-width: 576px) {
            table tr td {
                font-size: 13px !important;
                padding: 10px !important;
            }
            div {
                flex: wrap !important;
            }
            div img {
                max-width: 160px !important;
                display: inline-block !important;
            }
            table tr td div span {
                min-width: 28px;
                width: 28px !important;
                height: 28px !important;
                padding: 10px 10px !important;
            }
            table tr td div img {
                max-width: 70px !important;
                display: inline-block !important;
            }
            table tbody tr td button {
                max-width: 100px !important;
                font-size: 10px !important;
                padding: 10px 10px !important;
            }
        }
        @media (max-width: 480px) {
            table tr td {
                font-size: 11px !important;
                padding: 6px !important;
            }
            table {
                width: 100% !im;
            }
            .main-table {
                width: 100% !important;
                margin: 0 auto !important;
                padding: 10px !important;
            }
            table.main-table tr td table {
                padding: 0 !important;
            }
            table tbody tr td button {
                max-width: 90px !important;
                font-size: 10px !important;
                padding: 8px 6px !important;
            }
            table tbody tr td {
                line-height: 18px !important;
                font-size: 13px !important;
            }
            table tr td div span {
                min-width: 24px;
                width: 24px !important;
                height: 24px !important;
                padding: 10px 10px !important;
            }
            table tr td div img {
                max-width: 70px !important;
                display: inline-block !important;
            }
            div {
                font-size: 13px !important;
                padding: 0 !important;
                display: inline-block !important;
            }
            table tr td img {
                max-width: 140px !important;
                display: inline-block !important;
            }
            div div img {
                width: 100% !important;
                max-width: 50px !important;
                display: inline-block !important;
                padding: 0 !important;
            }
            div p {
                font-size: 11px !important;
            }
        }
        @media (max-width: 375px) {
            table tr td {
                font-size: 11px !important;
                padding: 6px !important;
            }
            table tbody tr td button {
                max-width: 90px !important;
                font-size: 10px !important;
                padding: 8px 6px !important;
            }
            table tbody tr td {
                line-height: 16px !important;
                font-size: 11px !important;
            }
            table tbody tr td span {
                width: 35px !important;
                height: 20px !important;
                padding-left: 0 !important;
            }
            table tr td div span {
                min-width: 22px;
                width: 22px !important;
                height: 22px !important;
                padding: 10px 10px !important;
            }
            table tr td div img {
                max-width: 70px !important;
                display: inline-block !important;
            }
            div {
                font-size: 13px !important;
                padding: 0 !important;
                display: inline-block !important;
                padding: 10px 0 0 0 !important;
            }
            table tr td img {
                max-width: 160px !important;
                display: inline-block !important;
            }
            div div img {
                width: 100% !important;
                max-width: 80px !important;
                display: inline-block !important;
                padding: 0 !important;
            }
            div p {
                font-size: 11px !important;
            }
        }
        @media (max-width: 320px) {
            table tr td a {
                max-width: 100px !important;
                font-size: 12px !important;
                padding: 9px 20px !important;
            }
            table tr td {
                font-size: 11px !important;
                padding: 6px !important;
            }
            table tbody tr td button {
                max-width: 90px !important;
                font-size: 10px !important;
                padding: 8px 6px !important;
            }
            table tbody tr td {
                line-height: 18px !important;
            }
            table tbody tr td span {
                width: 35px !important;
                height: 35px !important;
                padding: 0 !important;
            }
            table tr td div span {
                display: inline-block !important;
                min-width: 30px;
                width: 30px !important;
                height: 20px !important;
                padding: 10px 5px !important;
            }
            table tr td div img {
                max-width: 40px !important;
                display: inline-block !important;
            }
            div {
                font-size: 13px !important;
                padding: 0 !important;
                display: inline-block !important;
                padding: 10px 0 0 0 !important;
            }
            table tr td img {
                max-width: 120px !important;
                display: inline-block !important;
            }
            div img {
                max-width: 50px !important;
            }
            div div img {
                width: 100% !important;
                max-width: 80px !important;
                display: inline-block !important;
                padding: 0 !important;
            }
            div p {
                font-size: 11px !important;
            }
        }
    </style>
</head>
<body style="margin: 0;font-family: Arial, Helvetica, sans-serif;">
    <center>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" id="tableMain" bgcolor="#F2F3F4">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="800px" class="templateContainer">
                            <tbody>
                                <tr>
                                    <td valign="top" class="header">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; background-color: #fff;text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 10%;"></td>
                                                    <td style="width: 80%;">
                                                        {!! $data['content'] !!}
                                                    </td>
                                                    <td style="width: 10%;"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
        </table>
    </center>
</body>
</html>
