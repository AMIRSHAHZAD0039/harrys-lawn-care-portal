<!DOCTYPE html>
<html>
<head>
    <title>Quote Voided</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

<div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:10px;">

    <h2 style="color:#333;">Hello 👋</h2>

    <p style="font-size:15px; color:#555;">
        We hope you are doing well. We would like to inform you that your quote has been <b>voided</b> by our team.
    </p>

    <!-- RED REASON BOX -->
    <div style="margin-top:20px; padding:15px; background:#ffe5e5; border-left:5px solid #ff0000; border-radius:6px;">
        <h4 style="margin:0 0 10px 0; color:#d10000;">Reason for Void:</h4>
        <p style="margin:0; color:#b30000; font-weight:bold;">
            {{ $quote->void_reason }}
        </p>
    </div>

    <p style="font-size:15px; color:#555;">
        If you have any questions, feel free to contact us anytime.
    </p>

    <p>Thank you,<br>Harry's Lawncare Ltd.</p>

</div>

</body>
</html>
