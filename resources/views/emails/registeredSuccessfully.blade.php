<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Registration Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
            margin-bottom: 20px;
        }

        p {
            color: #555555;
            line-height: 1.6;
            margin-top: 0;
        }

        .credentials {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        .credentials p {
            margin: 0;
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Application Registration Confirmation</h1>
        <p>Hello {{ $to_name }},</p>

        <div class="credentials">
            <p>Thank you for registering your application.</p>
            <p>Your application is currently pending approval from the administrator.</p>
            <p>We will notify you once your application is approved.</p>
        </div>

        <p class="footer">Thank you,<br> DHI-Vidyadham</p>
    </div>
</body>
</html>
