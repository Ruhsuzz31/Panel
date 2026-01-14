<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sifre = $_POST['sifre'];

    $dosya_yolu = 'sifre.txt';
    if (file_exists($dosya_yolu)) {
        $kayitli_sifreler = file($dosya_yolu, FILE_IGNORE_NEW_LINES);

        if (in_array($sifre, $kayitli_sifreler)) {
            header('Location: Anasayfa.php');
            exit();
        } else {
            $hata = 'Yanlış Şifre. Lütfen Şifreyi Tekrardan Giriniz. Yoksa Ban atar Admin (Logsuzlar)';
        }
    } else {
        $hata = 'Şifre dosyası bulunamadı.';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GİRİŞ YAP</title>
    <style>
        body {
            position: relative;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            background-color: #222;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://i.hizliresim.com/hjrrqcy.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px); /* Blur efekti */
            z-index: -1;
        }

        .container {
            background-color: rgba(34, 34, 34, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
            position: relative;
            z-index: 1;
        }

        .error {
            color: #f00;
        }

        label, input, button {
            display: block;
            margin: 10px auto;
        }

        input, button {
            width: 80%;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            padding: 10px;
            text-align: center;
            transition: border-color 0.3s ease;
        }

        input:focus, button:focus {
            outline: none;
            border-color: #ff0;
        }

        button {
            cursor: pointer;
            background-color: #0f0;
            color: #000;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);">LOGSUZLAR CHECKER 2.0</h1>
        <?php
        if (isset($hata)) {
            echo "<p class='error'>$hata</p>";
        }
        ?>
        <form method="post" action="">
            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre" name="sifre" required>
            <button type="submit">Giriş yap</button>
        </form>
        <button onclick="playAudio()">Ses Çal</button>
    </div>

    <!-- Ses dosyasını ekleyin -->
    <audio id="background-audio">
        <source src="h4ck3r.mp3" type="audio/mpeg">
        Tarayıcınız ses etiketini desteklemiyor.
    </audio>

    <script>
        function playAudio() {
            var audio = document.getElementById('background-audio');
            audio.play().catch(function(error) {
                console.log('Oynatma hatası:', error);
            });
        }
    </script>
</body>
</html>
