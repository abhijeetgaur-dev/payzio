<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup Succes</title>
</head>

<body>
    <section style="text-align: center; padding: 20px;">
        <h1>Signup Successful!</h1>
        @if (session('success'))
            <p>Thank you for signing up! </p>
            <p>{{ session('success') }}</p>
        @endif
    </section>
</body>

</html>
