<?php
session_start();

// Görsel URL'lerini tanımlayın
$imageUrls = [
    'https://r.resimlink.com/ZDiIfFxsgK.jpeg',
    'https://r.resimlink.com/9Is6gyoTuk_N.jpeg',
    'https://r.resimlink.com/iBUCOuX59S-z.jpeg',
    // Daha fazla JPEG URL'si ekleyebilirsiniz
];

// Kullanıcı adı isteme
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = htmlspecialchars($_POST['username']);
    } else {
        echo '
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Logsuzlar Checker Sohbet</title>
            <style>
                body {
                    background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                }
                .login-form {
                    background: #fff;
                    padding: 30px;
                    border-radius: 12px;
                    text-align: center;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                    border: 1px solid #ddd;
                }
                .login-form input[type="text"] {
                    padding: 15px;
                    width: 100%;
                    margin-bottom: 20px;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                    font-size: 16px;
                }
                .login-form input[type="submit"] {
                    padding: 15px 30px;
                    background-color: #007bff;
                    border: none;
                    border-radius: 8px;
                    color: white;
                    cursor: pointer;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                }
                .login-form input[type="submit"]:hover {
                    background-color: #0056b3;
                }
                h2 {
                    margin-bottom: 20px;
                    font-size: 24px;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <form class="login-form" method="POST">
                <h2>Logsuzlar Checker Sohbet</h2>
                <input type="text" name="username" placeholder="İsminizi Girin" required>
                <input type="submit" value="Giriş Yap">
            </form>
        </body>
        </html>';
        exit;
    }
}

// Ses dosyası gönderme
if (isset($_FILES['audio'])) {
    $username = $_SESSION['username'];
    $timestamp = date("Y-m-d H:i:s");
    $fileName = basename($_FILES['audio']['name']);
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . $fileName;

    // Dosyayı yükle
    if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadFile)) {
        $data = [
            'username' => $username,
            'file' => $fileName,
            'timestamp' => $timestamp,
            'type' => 'audio'
        ];
        file_put_contents("chat_data.json", json_encode($data) . PHP_EOL, FILE_APPEND);
    }
    exit;
}

// Mesaj gönderme
if (isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    $username = $_SESSION['username'];
    $timestamp = date("Y-m-d H:i:s");

    // /nude komutunu kontrol edin
    if (strpos($message, '/nude') === 0) {
        // Rastgele bir JPEG görsel URL'si seçin
        $randomImage = $imageUrls[array_rand($imageUrls)];
        $data = [
            'username' => $username,
            'message' => "<img src='{$randomImage}' alt='Random Image' style='max-width: 100%; height: auto;'>",
            'timestamp' => $timestamp,
            'type' => 'text'
        ];
    } else {
        $data = [
            'username' => $username,
            'message' => $message,
            'timestamp' => $timestamp,
            'type' => 'text'
        ];
    }

    file_put_contents("chat_data.json", json_encode($data) . PHP_EOL, FILE_APPEND);
    exit;
}

// Mesajları oku
if (isset($_GET['action']) && $_GET['action'] === 'getMessages') {
    $chatContent = file_exists("chat_data.json") ? file("chat_data.json", FILE_IGNORE_NEW_LINES) : [];
    foreach ($chatContent as $line) {
        $chatData = json_decode($line, true);
        if ($chatData['type'] === 'audio') {
            echo "<div class='message'>
                    <strong>{$chatData['username']}</strong> <small style='color: #888;'>({$chatData['timestamp']})</small>
                    <audio controls>
                        <source src='uploads/{$chatData['file']}' type='audio/mpeg'>
                        Tarayıcınız ses dosyasını desteklemiyor.
                    </audio>
                  </div>";
        } else {
            echo "<div class='message'>
                    <strong>{$chatData['username']}</strong> <small style='color: #888;'>({$chatData['timestamp']})</small>
                    <p>{$chatData['message']}</p>
                  </div>";
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logsuzlar Checker Sohbet</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }
        .chat-container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            height: 80vh;
        }
        .chat-box {
            width: 100%;
            flex-grow: 1;
            border: 1px solid #ddd;
            overflow-y: auto;
            padding: 10px;
            background: url('https://i.hizliresim.com/hjrrqcy.jpg') no-repeat center center;
            background-size: cover;
            border-radius: 8px;
            color: #333;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); /* Mesajların daha okunaklı olması için hafif şeffaf beyaz arka plan */
        }
        .message p {
            margin: 5px 0;
        }
        .message-form {
            display: flex;
            width: 100%;
            margin-bottom: 10px;
        }
        .message-form input[type="text"] {
            flex-grow: 1;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-right: 10px;
            font-size: 16px;
            background-color: #f7f7f7;
        }
        .message-form input[type="submit"] {
            padding: 15px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .message-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .audio-form {
            display: flex;
            flex-direction: column;
        }
        .audio-form input[type="file"] {
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 28px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadMessages() {
                       $.ajax({
                url: "chat.php?action=getMessages",
                success: function(data) {
                    $("#chat-box").html(data);
                    $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 3000);

            $(".message-form").on("submit", function(e) {
                e.preventDefault();
                var button = $(".message-form input[type='submit']");
                button.val("Gönderiliyor...").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "chat.php",
                    data: $(this).serialize(),
                    success: function() {
                        loadMessages();
                        $(".message-form input[type='text']").val("");
                        button.val("Gönder").attr("disabled", false);
                    }
                });
            });

            $(".audio-form").on("submit", function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var button = $(".audio-form input[type='submit']");
                button.val("Yükleniyor...").attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "chat.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        loadMessages();
                        $(".audio-form")[0].reset();
                        button.val("Gönder").attr("disabled", false);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h2>Logsuzlar Checker Sohbet</h2>
<div class="info-text">Hos Geldiniz</div>
    <div class="chat-container">
        <div id="chat-box" class="chat-box"></div>
        <form class="message-form" method="POST">
            <input type="text" name="message" placeholder="Mesajınızı yazın" required>
            <input type="submit" value="Gönder">
        </form>
        <form class="audio-form" method="POST" enctype="multipart/form-data">
            <input type="file" name="audio" accept="audio/*" required>
            <input type="submit" value="Ses Gönder">
        </form>
    </div>
</body>
</html>
