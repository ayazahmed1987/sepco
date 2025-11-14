<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission - PSPC</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', sans-serif;">
    <table align="center" width="600" cellpadding="0" cellspacing="0"
        style="margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td
                style="background-color: #003366; padding: 20px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <img src="{{ asset('frontend/assets/images/pspc-logo.png') }}" alt="PSPC Logo" height="60"
                    style="margin-bottom: 10px;">
                <h2 style="color: #ffffff; margin: 0;">Pakistan Security Printing Corporation</h2>
                <p style="color: #ffffff; font-size: 14px; margin: 0;">Contact Form Submission Notification</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h3 style="color: #333333; border-bottom: 1px solid #e0e0e0; padding-bottom: 10px;">Contact Details</h3>

                <table width="100%" cellpadding="5" cellspacing="0" style="font-size: 15px; color: #555555;">
                    <tr>
                        <td width="30%"><strong>Name:</strong></td>
                        <td>{{ $data['name'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $data['phone'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $data['email'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Subject:</strong></td>
                        <td>{{ $data['subject'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Type:</strong></td>
                        <td>{{ $data['type'] }}</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Message:</strong></td>
                        <td>{!! nl2br(e($data['message'])) !!}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td
                style="background-color: #f0f0f0; padding: 20px; text-align: center; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; color: #888888; font-size: 13px;">
                &copy; {{ now()->year }} Pakistan Security Printing Corporation. All rights reserved.
            </td>
        </tr>
    </table>
</body>

</html>
