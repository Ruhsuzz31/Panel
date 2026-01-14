<?php
// API'ye istek yapacak ve sonucu alacak olan fonksiyon
function getFamilyData($url) {
    $apiUrl = "https://tilki.dev/api/site-bilgi?url=" . urlencode($url);
    $response = @file_get_contents($apiUrl);

    if ($response === FALSE) {
        return "Hata: API'ye erişilemedi. Lütfen daha sonra tekrar deneyin.";
    }

    return $response;
}

// Eğer form gönderildiyse, API'den veri al
$siteData = "";
if (isset($_POST['submit'])) {
    $url = trim($_POST['url']);
    if (!empty($url)) {
        $siteData = getFamilyData($url);
    } else {
        $siteData = "Lütfen site URL'sini giriniz.";
    }
}

// Sonuçları tabloya dönüştür
function formatDataAsTable($data) {
    $decodedData = json_decode($data, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Geçersiz veri formatı. Lütfen tekrar deneyin.";
    }

    $table = "<table>";
    foreach ($decodedData as $key => $value) {
        $table .= "<tr><th>" . htmlspecialchars($key) . "</th><td>" . htmlspecialchars($value) . "</td></tr>";
    }
    $table .= "</table>";

    return $table;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Sorgulama</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
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
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.7);
        }
        h1, h2 {
            color: #0f0;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.8);
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #0f0;
            border-radius: 5px;
            background: #000;
            color: #0f0;
            width: 70%;
            max-width: 300px;
            box-shadow: 0 0 5px #0f0;
            font-size: 16px;
        }
        input[type="text"]:focus {
            box-shadow: 0 0 10px #0f0;
            outline: none;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            background: #000;
            color: #0f0;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 0 5px #0f0;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background: #0f0;
            color: #000;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            background: #000;
            color: #0f0;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 0 5px #0f0;
            margin-top: 20px;
            font-size: 16px;
        }
        .back-button:hover {
            background: #0f0;
            color: #000;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.7);
        }
        th, td {
            padding: 12px;
            border: 1px solid #0f0;
            text-align: left;
            color: #0f0;
        }
        th {
            background: #333;
        }
        td {
            background: #000;
        }
        pre {
            background: #000;
            padding: 15px;
            border-radius: 5px;
            text-align: left;
            overflow-x: auto;
            color: #0f0;
            box-shadow: 0 0 5px #0f0;
            white-space: pre-wrap;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Site Bilgileri Sorgulama</h1>
        <form method="post" action="">
            <input type="text" name="url" placeholder="URL" required />
            <input type="submit" name="submit" value="Sorgula" />
        </form>
        <?php if (!empty($siteData)): ?>
            <h2>Sonuç:</h2>
            <?php echo formatDataAsTable($siteData); ?>
        <?php endif; ?>
        <a href="javascript:history.back()" class="back-button">Geri</a>
    </div>
</body>
</html>
