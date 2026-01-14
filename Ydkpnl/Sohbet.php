<?php
// API'ye istek yapacak ve sonucu alacak olan fonksiyon
function getFamilyData($url) {
    $url = "http://Logsuzlarchecker.duckdns.org/Gpt/GPT.php?mesaj=merhaba" . urlencode($url);
    $response = file_get_contents($url);

    if ($response === FALSE) {
        return "Hata: API'ye erişilemedi.";
    }

    return $response;
}

// Eğer form gönderildiyse, API'den veri al
$familyData = "";
if (isset($_POST['submit'])) {
    $url = trim($_POST['url']);
    if (!empty($url)) {
        $familyData = getFamilyData($url);
    } else {
        $familyData = "Lütfen site Url si giriniz.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet + GPT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #000;
            color: #0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #111;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.7);
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #0f0;
            border-radius: 5px;
            background: #222;
            color: #0f0;
            width: 70%;
            max-width: 300px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            background: #111;
            color: #0f0;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            text-shadow: 0 0 5px #0f0, 0 0 10px #0f0;
            box-shadow: 0 0 5px #0f0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        input[type="submit"]:hover {
            background: #0f0;
            color: #111;
        }
        pre {
            background: #000;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            overflow-x: auto;
            white-space: pre-wrap; /* Makes sure long texts are wrapped */
            color: #0f0;
            border: 1px solid #0f0;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            background: #000;
            color: #0f0;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
            text-shadow: 0 0 5px #0f0, 0 0 10px #0f0;
            box-shadow: 0 0 5px #0f0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .back-button:hover {
            background: #0f0;
            color: #000;
        }
    </style>
</head>
<body>
    <a href="javascript:history.back()" class="back-button">Geri</a>
    <div class="container">
        <h1>Sohbet + GPT</h1>
        <form method="post" action="">
            <input type="text" name="url" placeholder="Mesajınız" />
            <input type="submit" name="submit" value="Cevap" />
        </form>
        <h2>Sonuç:</h2>
        <pre><?php echo htmlspecialchars($familyData); ?></pre>
    </div>
</body>
</html>
