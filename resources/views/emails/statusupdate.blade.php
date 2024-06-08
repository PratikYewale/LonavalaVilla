<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h3 {
            color: #333;
            margin-top: 0;
            font-size: 24px;
        }

        p {
            color: #555;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .credentials {
            margin-top: 30px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }

        .credentials p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-size: 20px;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        .rejection {
            color: #ff6f61;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Your Application Status: {{$status}}</h3>
        
        @if($status == "Rejected")
            <p class="rejection">Oops! It looks like there's a small hiccup.</p>
            <p><strong>Reason: {{$reason}}</strong></p>
            <p>Don't worry, we're here to help! Feel free to contact us for further assistance.</p>
        @else
            <p><strong>Congratulations! Your application has been accepted!</strong></p>
            <p>Username: {{$email}}</p>
            <p>Password: {{$pass}}</p>
        
            <div class="credentials">
                <p>Please use these credentials to log in to the student portal.</p>
            </div>
        @endif
    </div>
</body>
</html>
