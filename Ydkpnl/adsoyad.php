<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADSOYAD Sorgulama</title>
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
            margin-right: 5px;
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
            margin-top: 20px;
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
        <h1>ADSOYAD Sorgulama</h1>
        <div class="form-container">
            <form method="GET">
                <input type="text" name="ad" placeholder="Ad" required>
                <input type="text" name="soyad" placeholder="Soyad" required>
                <input type="text" name="nufus_il" placeholder="Nüfus İl (isteğe bağlı)">
                <input type="text" name="nufus_ilce" placeholder="Nüfus İlçe (isteğe bağlı)">
                <div class="button-group">
                    <input type="submit" value="Sorgula">
                    <a href="javascript:history.back()" class="back-button">Geri</a>
                </div>
            </form>
        </div>

        <?php
        if (isset($_GET['ad']) && $_GET['ad'] !== '' && isset($_GET['soyad']) && $_GET['soyad'] !== '') {
            $ad = htmlspecialchars($_GET['ad']);
            $soyad = htmlspecialchars($_GET['soyad']);
            $nufus_il = isset($_GET['nufus_il']) ? htmlspecialchars($_GET['nufus_il']) : '';
            $nufus_ilce = isset($_GET['nufus_ilce']) ? htmlspecialchars($_GET['nufus_ilce']) : '';

            // Veritabanı bağlantısı
            $servername = "localhost";
            $username_db = "root";
            $password_db = "";
            $dbname = "101m";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username_db, $password_db);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM 101m WHERE ADI = :ad AND SOYADI = :soyad";

                if (!empty($nufus_il)) {
                    $sql .= " AND NUFUSIL = :nufus_il";
                }
                if (!empty($nufus_ilce)) {
                    $sql .= " AND NUFUSILCE = :nufus_ilce";
                }

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':ad', $ad);
                $stmt->bindParam(':soyad', $soyad);

                if (!empty($nufus_il)) {
                    $stmt->bindParam(':nufus_il', $nufus_il);
                }
                if (!empty($nufus_ilce)) {
                    $stmt->bindParam(':nufus_ilce', $nufus_ilce);
                }

                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($results) > 0) {
                    echo "<div class='result'><table>";
                    echo "<tr>
                                <th>ID</th>
                                <th>TC</th>
                                <th>Adı</th>
                                <th>Soyadı</th>
                                <th>Doğum Tarihi</th>
                                <th>Nüfus İl</th>
                                <th>Nüfus İlçe</th>
                                <th>Anne Adı</th>
                                <th>Anne TC</th>
                                <th>Baba Adı</th>
                                <th>Baba TC</th>
                                <th>Uyruk</th>
                                </tr>";

                    foreach ($results as $item) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['id'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['TC'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['ADI'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['SOYADI'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['DOGUMTARIHI'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['NUFUSIL'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['NUFUSILCE'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['ANNEADI'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['ANNETC'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['BABAADI'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['BABATC'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($item['UYRUK'] ?? '') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                } else {
                    echo "<div class='result'>Veri bulunamadı.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='result'>Veritabanı hatası: " . $e->getMessage() . "</div>";
            }
        } else if (isset($_GET['ad']) || isset($_GET['soyad']) || isset($_GET['nufus_il']) || isset($_GET['nufus_ilce'])) {
            echo "<div class='result'>Ad ve Soyad alanları zorunludur.</div>";
        }
        ?>
    </div>
</body>
</html>