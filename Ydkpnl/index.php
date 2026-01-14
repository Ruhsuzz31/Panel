<?php
// Başlangıç: Oturum başlatma ve hata ayıklama
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sayfa başlığı ve yönlendirme
$page_title = "Ana Sayfa";
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Telegram bot ayarları
$bot_token = '7408626872:AAGg53fE_EVMJBDZb1xsf5ENVCiIqvZww10'; // Buraya Telegram bot token'ınızı ekleyin
$chat_id = '7226523981'; // Buraya kendi Telegram chat ID'nizi ekleyin

// Telegram mesaj gönderim fonksiyonu
function sendTelegramMessage($message) {
    global $bot_token, $chat_id;
    $url = "https://api.telegram.org/bot" . $bot_token . "/sendMessage";
    $post_fields = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_exec($ch);
    curl_close($ch);
}

// Sayfa içerikleri
function loadPageContent($page) {
    $allowed_pages = ['home', 'about', 'contact'];
    if (in_array($page, $allowed_pages)) {
        switch ($page) {
            case 'home':
                echo '<h2>Hoşgeldiniz!</h2><p>İstediğiniz Sorguyu Yapabilirsiniz Ama Lütfen Bilgi Kutusunu Kontrol Edin.</p>';
                echo '<p>Panel Giriş</p>';
                echo '<a href="http://Logsuzlar.duckdns.org/Login.php" class="button-small">Logsuzlar Checker Panel</a>';
                
                // Yeni eklenen başlık ve butonlar
                echo '<h3 style="margin-top: 30px;">Web Sitemizi Uygulama Gibi Kullanmak İster misiniz?</h3>';
                echo '<div style="margin-top: 10px;">';
                echo '<button type="button" class="button-small green-button" id="showGuideBtn" onclick="toggleHowToGuide(true)">Nasıl Yapılır?</button>';
                // Kapat butonu başlangıçta gizli olacak
                echo '<button type="button" class="button-small red-button" id="hideGuideBtn" style="margin-left: 10px; display: none;" onclick="toggleHowToGuide(false)">Kapat</button>';
                echo '</div>';

                echo '<div id="howToGuide" style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9; border-radius: 5px;">';
                echo '<h3>Ana Ekrana Ekleme Talimatları:</h3>';
                echo '<p>iPhone veya iPad\'inizde Safari tarayıcısını açın. Alt ortadaki paylaş (kare ve yukarı ok) simgesine dokunun ve \'Ana Ekrana Ekle\' seçeneğini seçin.</p>';
                echo '</div>';
                // Add some extra padding at the bottom of the main content when the guide might be visible
                echo '<div style="height: 100px;"></div>'; // This creates empty space below the content
                break;
            case 'about':
                echo '<h2>Hakkımızda</h2><p>Merhaba, Logsuzlar Checker Sorgu Paneli Olarak Daha Fazla İçerikle Yanınızda Olacağız.</p>';
                break;
            case 'contact':
                echo '<h2>İletişim</h2><p>Bizimle iletişime geçmek için lütfen aşağıdaki formu kullanın:</p>
                <form action="" method="post">
                    <label for="name">Adınız:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="username">Telegram Kullanıcı Adı:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="message">Mesaj:</label>
                    <textarea id="message" name="message" required></textarea>
                    <button type="submit">Gönder</button>
                </form>';
                
                // Form işleme
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = htmlspecialchars($_POST['name']);
                    $username = htmlspecialchars($_POST['username']);
                    $message = htmlspecialchars($_POST['message']);

                    // Telegram mesaj formatı
                    $telegram_message = "Ad: $name\nTelegram Kullanıcı Adı: @$username\n\nMesaj:\n$message";
                    
                    // Telegram mesaj gönderme
                    sendTelegramMessage($telegram_message);

                    echo "<p>Teşekkürler, $name! Mesajınız alınmıştır.</p>";
                }
                break;
        }
    } else {
        echo '<h2>404 - Sayfa Bulunamadı</h2><p>Aradığınız sayfa bulunamadı. Lütfen menüden başka bir sayfa seçin.</p>';
    }
}

// İçerik dosyasının yüklenmesi
ob_start(); // Çıktı tamponlama başlat
loadPageContent($current_page);
$content = ob_get_clean(); // Tamponlanan içeriği al ve temizle
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            min-height: 100vh; /* Ensure body takes at least full viewport height */
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        main {
            padding: 20px;
            background: #fff;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 8px;
            flex-grow: 1; /* Allow main content to grow and push footer down */
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Push footer to the bottom if content is short */
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin: 10px 0 5px;
        }
        form input, form textarea {
            margin-bottom: 10px;
            padding: 8px;
        }
        .button-small {
            display: inline-block;
            padding: 8px 16px;
            font-size: 0.9em;
            background: #0088cc;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 136, 204, 0.6);
            transition: background 0.3s ease, transform 0.2s ease;
            text-align: center;
            text-decoration: none; /* Linkler için */
        }
        .button-small:hover {
            background: #007ab8;
            transform: scale(1.05);
        }
        /* Yeni buton stilleri */
        .green-button {
            background-color: #4CAF50; /* Yeşil */
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.6);
        }
        .green-button:hover {
            background-color: #45a049;
        }
        .red-button {
            background-color: #f44336; /* Kırmızı */
            box-shadow: 0 0 5px rgba(244, 67, 54, 0.6);
        }
        .red-button:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="?page=home">Ana Sayfa</a></li>
                <li><a href="?page=about">Hakkımızda</a></li>
                <li><a href="?page=contact">İletişim</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <p>&copy; 2025 Logsuzlar Checker Web Sitemizin. Tüm hakları saklıdır.</p>
    </footer>

    <script>
        function toggleHowToGuide(show) {
            var guideDiv = document.getElementById('howToGuide');
            var showGuideBtn = document.getElementById('showGuideBtn');
            var hideGuideBtn = document.getElementById('hideGuideBtn');

            if (show) {
                // "Nasıl Yapılır?" butonuna tıklandığında rehberi göster
                guideDiv.style.display = 'block';
                showGuideBtn.style.display = 'none'; // "Nasıl Yapılır?" butonunu gizle
                hideGuideBtn.style.display = 'inline-block'; // "Kapat" butonunu göster
            } else {
                // "Kapat" butonuna tıklandığında rehberi gizle
                guideDiv.style.display = 'none';
                showGuideBtn.style.display = 'inline-block'; // "Nasıl Yapılır?" butonunu göster
                hideGuideBtn.style.display = 'none'; // "Kapat" butonunu gizle
            }
        }
    </script>
</body>
</html>