<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vendor Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .email-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #6f42c1;
        }

        .section {
            margin-top: 20px;
        }

        .label {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #6f42c1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Welcome, {{ $data['vendor_name'] }}!</h2>

        <p>Thank you for registering with us as a vendor. Your application has been received successfully. Below are the
            details you submitted:</p>

        <div class="section">
            <p><span class="label">Business Category:</span> {{ $data['business_category'] }}</p>
            <p><span class="label">Contact Person:</span> {{ $data['contact_person'] }}</p>
            <p><span class="label">Email:</span> {{ $data['email'] }}</p>
            <p><span class="label">Phone:</span> {{ $data['phone'] }}</p>
        </div>
        <strong>
            <p>Your password is : {{ $data['password'] }}
        </strong></p>

        <p>We will review your registration and
            contact you shortly for further steps. If you have any questions in the
            meantime, feel free to reach out to our support team.</p>

        <a href="{{ route('vendor.login') }}" class="button">Click Here to Login</a>


        <div class="footer">
            This email is for confirmation purposes only.<br>
            &copy; {{ date('Y') }} Payzio. All rights reserved.
        </div>
    </div>
</body>

</html>
