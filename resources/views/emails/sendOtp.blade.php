<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Time Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
<style>
body {
  font-family: "Poppins", sans-serif;
}

</style>
</head>
<body>
    <div class="container" style="width: 600px; background-color: #F5F5F5;">
        <div style="background-color: #FFFFFF; margin: 25px;">
            <img src=https://i.im.ge/2024/01/23/YVekAy.otp.png alt="" style="display: block; margin: 0 auto; padding-top: 15px;">
            <h2 style="text-align: center; color: #4D4D4D; line-height: 30px;"">OTP for password</h2>
            <div style="margin: 25px; padding-bottom: 20px; color: #4A4A4A;">
                <p style="align-content: center; text-align: center;line-height: 30px; font-size: 18px;">This is OTP for your account. Do not share this with anyone. if you have not requested this then please ignore.</p>
            </div>
            <div
                style="background-color: #E2F1FF; text-align: center; margin: 20px; border-radius: 10px; padding: 20px;">
                <h1 style="margin: 0; padding: 10px;">{{$otp}}</h1>
            </div>
            <div style="text-align: center; color: red; padding-bottom: 20px;">Valid for 5 minutes only</div>
        </div>
        <div style="text-align: center; padding-bottom: 20px;">© 2024 Groofly All Rights Reserved</div>
    </div>
</body>
</html>