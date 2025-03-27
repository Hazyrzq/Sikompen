<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiKompen TIK PNJ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px;
            background-color: #f5f5f5;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .token {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SiKompen TIK PNJ</h2>
        </div>
        
        <h3>{{ $mailData['title'] }}</h3>
        
        <div class="token">{{ $mailData['body'] }}</div>
        
        <p>Silakan gunakan kode di atas untuk reset password akun Anda.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <p>Terima kasih,<br>Tim SiKompen TIK PNJ</p>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>