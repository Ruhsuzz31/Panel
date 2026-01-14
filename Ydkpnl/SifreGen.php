<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Paneli</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kullanıcıdan gelen şifre
            $password = $_POST['password'];
            
            // Şifre dosyasına yazma
            $file = 'sifre.txt';
            $currentContent = file_get_contents($file);
            file_put_contents($file, $currentContent . $password . PHP_EOL);
            
            echo '<p style="color: #333;">Yeni şifre <strong>sifre.txt</strong> dosyasına kaydedildi:</p>';
            echo '<p style="font-size: 20px; color: #4CAF50;">' . htmlspecialchars($password) . '</p>';
        }
        ?>
        <form method="post">
            <div class="form-group">
                <input type="text" name="password" placeholder="Şifreyi girin" required>
            </div>
            <button type="submit" class="button">Şifreyi Kaydet</button>
        </form>
    </div>
</body>
</html>
