<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            padding: 20px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .email-header {
            background-color: #2e7d32;
            color: #ffffff;
            text-align: center;
            padding: 25px 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 30px 25px;
            font-size: 16px;
            line-height: 1.6;
            color: #1a2e22;
        }
        .email-body h2 {
            color: #2e7d32;
            margin-top: 0;
        }
        .email-body p {
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #2e7d32, #4caf50);
            color: #fff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: linear-gradient(90deg, #4caf50, #2e7d32);
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #e2e8f0;
        }
        .highlight {
            color: #2e7d32;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-container">
        <div class="email-header">
            Harry's Lawn Care
        </div>
        <div class="email-body">
            <h2>Hello {{ $quote->client_name }},</h2>

            <p>We are excited to let you know that your <span class="highlight">quote has been successfully created!</span></p>

            <p>Please take a moment to review and sign your quote by clicking the button below:</p>

            <a href="{{ $link }}" class="btn" target="_blank">View & Sign Quote</a>

            <p>Thank you for choosing <span class="highlight">Harry Lawns Care</span>.<br>We look forward to helping your lawn look its best this season!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Harry's Lawn Care. All rights reserved.
        </div>
        <img src="https://quote.harryslawncare.ca/email/open/{{ $log->id }}" width="1" height="1" style="display:none;" alt="">
    </div>
</div>

</body>
</html>
