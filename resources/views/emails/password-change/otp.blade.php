<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>OTP Code</h1>
        </div>
        <div class="content">
            <p>Ваш код для смены пароля:</p>
            <p>Your password change code:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>Если вы не запрашивали смену пароля, просто проигнорируйте это письмо.</p>
            <p>If you did not request a password change, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>Спасибо, что пользуетесь нашими услугами!</p>
            <p>Thank you for using our services!</p>
        </div>
    </div>
</body>
</html>