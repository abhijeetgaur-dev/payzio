<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QR Code Generated</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

        <h2 style="color: #333;">Hello {{ $data['vendor_name'] }},</h2>

        <p style="font-size: 16px; color: #555;">
            Your QR Code has been successfully generated. It is attached to this email.
        </p>


        <p style="font-size: 16px; color: #555;">
            If you have any questions or need further assistance, feel free to reply to this email.
        </p>

        <p style="margin-top: 30px; font-size: 14px; color: #888;">
            Regards,<br>
            Payzio Teams
        </p>
    </div>
</body>

</html>
