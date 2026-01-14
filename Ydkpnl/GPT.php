<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_message = urlencode(htmlspecialchars($_POST["message"]));

    // API URL'sini oluşturma
    $api_url = "https://tilki.dev/api/sohbet?soru=" . $user_message;

    // API'ye GET isteği gönderme
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // API'den dönen cevabı işleme
    $response_data = json_decode($response, true);
    $api_reply = isset($response_data['cevap']) ? $response_data['cevap'] : 'API cevap veremedi.';

    // Oturumda cevapları saklama
    $_SESSION['messages'][] = [
        'user_message' => $_POST["message"],
        'api_reply' => $api_reply
    ];
}

// Geçmiş mesajları alma
$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet Uygulaması</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.7);
        }
        .chat-box {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 10px;
            background-color: #333333;
            height: 200px;
            overflow-y: auto;
        }
        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            background-color: #444444;
            color: #ffffff;
        }
        .chat-reply {
            margin-top: 10px;
            padding: 10px;
            border-radius: 10px;
            background-color: #39FF14;
            color: #000000;
            font-weight: bold;
        }
        .chat-input {
            width: calc(100% - 20px);
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #333333;
            color: #ffffff;
        }
        .chat-button {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #39FF14;
            color: #000000;
            cursor: pointer;
            font-weight: bold;
        }
        .back-button {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #39FF14;
            color: #000000;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-box">
            <?php foreach ($messages as $message): ?>
                <div class="chat-message"><strong>Ben:</strong> <?php echo htmlspecialchars($message['user_message']); ?></div>
                <div class="chat-reply"><?php echo htmlspecialchars($message['api_reply']); ?></div>
            <?php endforeach; ?>
        </div>
        <form action="" method="POST">
            <input class="chat-input" type="text" name="message" placeholder="Mesajınızı yazın..." required>
            <button class="chat-button" type="submit">Gönder</button>
        </form>
        <button class="back-button" onclick="history.back()">Geri</button>
    </div>
</body>
</html>
