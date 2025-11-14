<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Intimation for Award of Contract - PSPC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            min-height: 100vh;
            padding: 40px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pspc-card {
            width: 100%;
            max-width: 600px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .pspc-header {
            background-color: #003366;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }

        .pspc-footer {
            background-color: #f0f0f0;
            text-align: center;
            color: #888888;
            font-size: 13px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="email-wrapper">
        <div class="pspc-card">

            <!-- Header -->
            <div class="pspc-header">
                <img src="{{ asset('frontend/assets/images/pspc-logo.png') }}" alt="PSPC Logo" height="60"
                    class="mb-2">
                <h4 class="mb-1">Pakistan Security Printing Corporation</h4>
                <p class="mb-0">Intimation for Award of Contract</p>
            </div>

            <!-- Body -->
            <div class="p-4" style="padding: 20px;">
                <h5 class="border-bottom pb-2 text-dark">Award of Contract Notification</h5>

                <p class="text-dark mb-2">Dear {{ $evaluation->tender->tenderPerson->name }},</p>

                <p class="text-dark mb-2">
                    <strong>Subject:</strong> Intimation for Award of Contract (Tender No.
                    {{ $evaluation->tender->ref_no }})
                </p>

                <p class="text-dark mb-3">
                    This is to inform you that the award of Contract opening of <strong>Tender No.
                        {{ $evaluation->tender->ref_no }}</strong> is due today.<br>
                    Please ensure the award of Contract as per scheduled time.
                </p>

                <p class="text-dark mb-0">
                    Regards,<br><strong>Tender Management System</strong>
                </p>
            </div>

            <!-- Footer -->
            <div class="pspc-footer">
                &copy; {{ now()->year }} Pakistan Security Printing Corporation. All rights reserved.
            </div>

        </div>
    </div>

</body>

</html>
