<?php
header("Content-Type: application/json; charset=utf-8");

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "101m"; // Genel olarak 'dbname' olarak kullanmak daha yaygın

// mysqli bağlantısını oluşturma (hem ana sorgular hem de GSM sorguları için tek bağlantı kullanmak daha iyidir)
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    // Hata durumunda JSON yanıtı döndür
    echo json_encode(["error" => "Veritabanı bağlantısı başarısız: " . $conn->connect_error], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit; // Betiği sonlandır
}

// Yetkilendirme Anahtarı (isteğe göre 'Logsuz' olarak ayarlandı)
$authKey = 'Logsuz';

// Gerekli GET parametrelerinin kontrolü
if (isset($_GET['ad']) && isset($_GET['soyad']) && isset($_GET['auth'])) {
    // GET parametrelerini güvenli bir şekilde al
    $tc = $_GET['tc'] ?? null;
    $ad = $_GET['ad'];
    $soyad = $_GET['soyad'];
    $annetc = $_GET['annetc'] ?? null;
    $babatc = $_GET['babatc'] ?? null;
    $il = $_GET['il'] ?? null;
    $auth = $_GET['auth'];

    // Yetkilendirme anahtarı kontrolü
    if ($auth === $authKey) {
        $startTime = microtime(true); // İşlem başlangıç zamanı

        // Kişi bilgilerini veritabanından çek
        // Bağlantı nesnesini getKisiBilgileri fonksiyonuna geçir
        $result = getKisiBilgileri($conn, $tc, $annetc, $babatc, $ad, $soyad, $il);

        // Sorgu sonucunu kontrol et
        if (!$result) {
            echo json_encode(["success" => false, "author" => "t.me/NovaByteProject", "message" => "Sorgu hatası veya geçerli arama parametresi yok."], JSON_UNESCAPED_UNICODE);
            die();
        }

        $resultarray = [];
        while ($row = $result->fetch_assoc()) {
            // 'ID' sütununu kaldırma (eğer veritabanında 'ID' adında bir sütun varsa ve istemiyorsanız)
            // Resimdeki sütun adı 'id' (küçük harf). Eğer ID yerine id ise bunu 'id' olarak değiştirin.
            if (isset($row['id'])) { // Resimde 'id' küçük harf olduğu için
                unset($row['id']);
            }
            $resultarray[] = $row;
        }
        $bulunans = count($resultarray); // Bulunan kayıt sayısı

        // Eğer kayıt bulunamazsa
        if ($bulunans < 1) {
            echo json_encode(["success" => false, "author" => "t.me/NovaByteProject", "message" => "Data Bulunmadı."], JSON_UNESCAPED_UNICODE);
            die();
        }

        // TC numaralarını topla (GSM sorgusu için)
        $tc_list = array_column($resultarray, 'TC');

        $gsm_listesi = [];
        foreach ($tc_list as $tc_number) {
            // GSM numarasını çekmek için yeni bir sorgu hazırla
            // Buradaki 'GSM' sütun adının veritabanınızdaki ile tam olarak eşleştiğinden emin olun (büyük/küçük harf dahil)
            $sqls = "SELECT GSM FROM 101m WHERE TC=?";
            $stmt_gsm = $conn->prepare($sqls); // $conn bağlantı nesnesini kullan
            
            if ($stmt_gsm) {
                $stmt_gsm->bind_param("s", $tc_number);
                $stmt_gsm->execute();
                $result_gsm = $stmt_gsm->get_result();
                while ($row_gsm = $result_gsm->fetch_assoc()) {
                    $gsm_listesi[$tc_number][] = $row_gsm['GSM'];
                }
                $stmt_gsm->close(); // Hazırlanmış ifadeyi kapat
            } else {
                // Hata günlüğü tutma veya hata mesajı döndürme
                error_log("GSM sorgusu hazırlanamadı: " . $conn->error);
            }
        }

        // Ana sonuç dizisine GSM bilgilerini ekle
        foreach ($resultarray as &$entry) {
            $tc_number = $entry['TC'];
            if (isset($gsm_listesi[$tc_number])) {
                $entry['GSM'] = implode(' / ', $gsm_listesi[$tc_number]);
            } else {
                $entry['GSM'] = "Bulunamadı.";
            }
        }

        $endTime = microtime(true); // İşlem bitiş zamanı
        $responseTime = round($endTime - $startTime, 3); // Yanıt süresi hesapla

        // Başarılı JSON yanıtı oluştur
        $message = [
            "success" => "true",
            'Api Saglayici' => 'NovaByte Service',
            'Api İsmi' => 'Ad Soyad',
            'Api Limit' => 'Limitsiz',
            'Api Yanıt Suresi' => round($responseTime, 2) . " Saniye",
            'Message' => 'NovaByte API Service.',
            'number' => $bulunans,
            'data' => $resultarray
        ];

        echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        die(); // Betiği sonlandır
    } else {
        // Yanlış yetkilendirme anahtarı hatası
        echo json_encode(["success" => false, "author" => "t.me/NovaByteProject", "message" => "Yanlış Yetkilendirme Anahtarı"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        die();
    }
} else {
    // Eksik parametre hatası
    echo json_encode(["success" => false, "author" => "t.me/NovaByteProject", "message" => "Parametre Eksik (ad, soyad, auth gereklidir)"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    die();
}

/**
 * Kişi bilgilerini veritabanından çeken fonksiyon.
 * @param mysqli $link Veritabanı bağlantı nesnesi.
 * @param string|null $tc TC kimlik numarası.
 * @param string|null $annetc Anne TC kimlik numarası.
 * @param string|null $babatc Baba TC kimlik numarası.
 * @param string|null $ad Adı.
 * @param string|null $soyad Soyadı.
 * @param string|null $il İkamet ili.
 * @return mysqli_result|null Sorgu sonucu veya hata durumunda null.
 */
function getKisiBilgileri($link, $tc = null, $annetc = null, $babatc = null, $ad = null, $soyad = null, $il = null) {
    $sql = "SELECT * FROM 101m";
    $whereClause = [];
    $params = [];
    $paramTypes = ""; // Parametre tipleri için string

    // Dinamik WHERE koşulları oluşturma ve parametreleri toplama
    if (!empty($tc)) {
        $whereClause[] = "TC=?";
        $params[] = $tc;
        $paramTypes .= "s";
    }
    if (!empty($annetc)) {
        $whereClause[] = "ANNETC=?"; // Resimde ANNETC var
        $params[] = $annetc;
        $paramTypes .= "s";
    }
    if (!empty($babatc)) {
        $whereClause[] = "BABATC=?"; // Resimde BABATC var
        $params[] = $babatc;
        $paramTypes .= "s";
    }
    if (!empty($ad)) {
        $whereClause[] = "ADI=?"; // Düzeltildi: 'AD' yerine 'ADI'
        $params[] = $ad;
        $paramTypes .= "s";
    }
    if (!empty($soyad)) {
        $whereClause[] = "SOYADI=?"; // Düzeltildi: 'SOYAD' yerine 'SOYADI'
        $params[] = $soyad;
        $paramTypes .= "s";
    }
    if (!empty($il)) {
        $whereClause[] = "NUFUSIL=?"; // Düzeltildi: 'MEMLEKETIL' yerine 'NUFUSIL'
        $params[] = $il;
        $paramTypes .= "s";
    }

    // Eğer herhangi bir arama koşulu varsa
    if (!empty($whereClause)) {
        $sql .= " WHERE " . implode(" AND ", $whereClause);

        $stmt = $link->prepare($sql);
        if ($stmt === false) {
            // Hazırlama hatası durumunda hata günlüğü tut
            error_log("SQL sorgusu hazırlanamadı: " . $link->error . " | Sorgu: " . $sql);
            return null;
        }

        // Parametreleri bağla (sadece parametre varsa)
        if (!empty($params)) {
            // call_user_func_array yerine ... operatörü kullanıldı, PHP 5.6+ için
            $stmt->bind_param($paramTypes, ...$params);
        }

        $stmt->execute(); // Sorguyu çalıştır
        return $stmt->get_result(); // Sonuç kümesini döndür
    } else {
        // Hiçbir arama parametresi verilmediyse boş bir sonuç kümesi döndür veya null
        // Mevcut durumda, herhangi bir WHERE koşulu yoksa null döndürülüyor.
        // Tüm veriyi çekmek isterseniz: return $link->query($sql);
        return null;
    }
}
?>