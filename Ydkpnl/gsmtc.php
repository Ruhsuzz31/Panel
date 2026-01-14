<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSM ile TC Sorgulama</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* İçeriği üste hizala */
            min-height: 100vh; /* Minimum tam ekran yüksekliği */
            margin: 0;
            padding: 20px; /* Kenarlardan boşluk bırak */
            box-sizing: border-box; /* Padding'i genişliğe dahil et */
        }
        .container {
            text-align: center;
            padding: 20px;
            border: 2px solid #0f0;
            border-radius: 10px;
            background-color: #222;
            width: 100%; /* Genişliği %100 yap */
            max-width: 1200px; /* Maksimum genişlik belirle */
            margin-top: 20px; /* Üstten biraz boşluk */
            box-sizing: border-box;
            display: flex;
            flex-direction: column; /* İçeriği dikey sırala */
            min-height: calc(100vh - 40px); /* Ekranın neredeyse tamamını kapla */
        }
        h1 {
            margin-top: 10px; /* Başlık için biraz üst boşluk */
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-container {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #0f0;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
            width: 200px;
            margin-bottom: 10px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: 1px solid #0f0;
            border-radius: 5px;
            background-color: #333;
            color: #0f0;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0f0;
            color: #333;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #0f0;
            border-radius: 5px;
            background-color: #222;
            text-align: left;
            flex-grow: 1; /* Mevcut alanı doldur */
            overflow: auto; /* Hem yatay hem dikey kaydırma çubukları */
            white-space: nowrap; /* Metni tek satırda tut, yatay kaydırma için */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: auto; /* İçerik genişliğine göre ayarla */
        }
        table, th, td {
            border: 1px solid #0f0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            white-space: nowrap; /* Hücre içindeki metni tek satırda tut */
        }
        th {
            background-color: #333;
            position: sticky; /* Başlıkların yukarıda sabit kalmasını sağlar */
            top: 0;
            z-index: 1; /* Diğer içeriğin üzerinde kalmasını sağlar */
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #0f0;
            border-radius: 5px;
            background-color: #000;
            color: #0f0;
            text-decoration: none;
            font-size: 16px;
            margin-top: 0; /* Geri butonu için üst boşluğu kaldır */
            margin-bottom: 20px; /* Başlık ile araya boşluk koy */
            text-shadow: 0 0 5px #0f0, 0 0 10px #0f0, 0 0 15px #0f0, 0 0 20px #0f0;
            box-shadow: 0 0 5px #0f0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0f0;
            color: #000;
        }
        /* Küçük ekranlar için düzenleme */
        @media (max-width: 768px) {
            input[type="text"] {
                width: calc(100% - 10px); /* Küçük ekranlarda tüm genişliği kapla */
                margin-right: 0;
                margin-bottom: 10px;
            }
            .button-group {
                flex-direction: column; /* Butonları dikey sırala */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="javascript:history.back()" class="back-button">Geri</a>
        <h1>GSM ile TC Sorgulama</h1>
        <form method="GET">
            <input type="text" name="gsmtc" placeholder="GSM Numarası" required>
            <div class="button-group">
                <input type="submit" value="Sorgula">
            </div>
        </form>

        <?php
        if (isset($_GET['gsmtc'])) {
            $gsm = htmlspecialchars($_GET['gsmtc']);
            $url = "https://apiv2.tsgonline.net/tsgapis/OrramaKonmaBurragaKoy/gsmtc.php?auth=tsgxyunus&gsm=" . urlencode($gsm);

            // API isteği
            $response = file_get_contents($url);

            if ($response !== false) {
                // BOM karakterlerini temizleme
                $response = preg_replace('/^\xEF\xBB\xBF/', '', $response); // BOM temizleme
                $response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response); // Gizli karakterleri temizleme

                // JSON çözümleme
                $data = json_decode($response, true);

                // JSON çözümleme hatası kontrolü
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "<div class='result'>JSON Çözümleme Hatası: " . json_last_error_msg() . "</div>";
                } else {
                    // "success" anahtarını kontrol et
                    if (isset($data['success']) && $data['success'] === true) {
                        if (isset($data['data']) && is_array($data['data']) && count($data['data']) > 0) {
                            // Tabloyu oluştur
                            echo "<div class='result'><table>";
                            echo "<tr><th>GSM Numarası</th><th>TC Kimlik No</th></tr>";
                            
                            foreach ($data['data'] as $item) {
                                $gsm_no = htmlspecialchars($item['GSM'] ?? 'Bilinmiyor');
                                $tc = htmlspecialchars($item['TC'] ?? 'Bilinmiyor');
                                echo "<tr><td>{$gsm_no}</td><td>{$tc}</td></tr>";
                            }

                            echo "</table></div>";
                        } else {
                            echo "<div class='result'>Veri bulunamadı.</div>";
                        }
                    } else {
                        echo "<div class='result'>Hata: " . htmlspecialchars($data['message'] ?? 'Bilinmiyor') . "</div>";
                    }
                }
            } else {
                echo "<div class='result'>Hata: API isteği başarısız oldu.</div>";
            }
        }
        ?>
    </div>
</body>
</html>