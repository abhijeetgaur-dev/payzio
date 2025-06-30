<!DOCTYPE html>
<html>

<head>
    <title>Vendor Status Update</title>
</head>

<body>
    <h2>Hello {{ $vendor_name }},</h2>

    <p>Your account status has been updated to:
        <strong>
            @if ($status == 1)
                Active
            @elseif ($status == 0)
                Inactive
        </strong>
        @endif
    </p>

    @if ($status_reason)
        <p><strong>Reason:</strong> {{ $status_reason ? $status_reason : 'Normal Business Operations' }}
        </p>
    @endif

    <p>If you have any questions, please contact support.</p>

    <p>Regards,<br> <strong>{{ $admin_name }},<br>Payzio Team</strong></p>

    <p>
        Please Login Here: <a href="{{ route('vendor.login') }}">Click Here</a>
    </p>
</body>

</html>
