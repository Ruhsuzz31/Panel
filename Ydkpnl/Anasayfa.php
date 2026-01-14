<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logsuzlar SORGU PANELİ</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("https://i.hizliresim.com/7s5kqdz.jpg");
            background-size: cover;
            color: #fff;
        }

        .container {
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease-out;
            height: 100vh;
        }

.info-button {
    position: fixed;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
    z-index: 1000;
    color: #0f0;
    background-color: #111;
    border: none;
    padding: 5px;
    border-radius: 5px;
    box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
    text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
}

.info-box {
    display: none;
    position: fixed;
    top: 50px;
    right: 10px;
    background-color: #222;
    color: #0f0;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
    z-index: 1001;
}

.info-box button {
    background-color: #0f0;
    color: #000;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
}


/* Neon effect for sidebar */
.sidebar {
    background-color: #111;
    color: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 255, 0, 0.6);
}

.menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-list li {
    margin: 10px 0;
}

.menu-list a {
    color: #0f0; /* Neon green */
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
    display: block;
    position: relative;
    padding: 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

/* Neon glow on hover */
.menu-list a::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: rgba(0, 255, 0, 0.5);
    border-radius: 5px;
    transform: translate(-50%, -50%) scale(1.2);
    z-index: -1;
    opacity: 0;
    transition: all 0.3s ease;
}

.menu-list a:hover::before {
    opacity: 1;
}

.menu-list a:hover {
    color: #fff;
}


        .menu-toggle {
            position: fixed;
            top: 10px;
            left: 10px;
            font-size: 20px; /* Küçültülmüş font boyutu */
            cursor: pointer;
            z-index: 1000;
            color: #0f0;
            background-color: #111;
            border: none;
            padding: 5px; /* Küçültülmüş padding */
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
        }

        .menu-item {
            cursor: pointer;
            padding: 5px; /* Küçültülmüş padding */
            background-color: #222;
            margin-bottom: 3px; /* Küçültülmüş margin */
            transition: background-color 0.3s;
            text-align: center;
            border-radius: 5px;
            color: #0f0;
            font-weight: bold;
            font-size: 14px; /* Büyütülmüş font boyutu */
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            animation: neon-glow 1s infinite alternate;
        }

        .menu-item:hover {
            background-color: #333;
        }

        .sub-menu {
            background-color: #333;
            padding: 5px; /* Küçültülmüş padding */
            border-radius: 5px;
            margin-top: 3px; /* Küçültülmüş margin */
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .sub-menu.open {
            max-height: 650px;
        }

        .sub-menu-item {
            display: block;
            padding: 5px; /* Küçültülmüş padding */
            cursor: pointer;
            transition: background-color 0.3s;
            color: #0f0;
            font-weight: bold;
            font-size: 12px; /* Büyütülmüş font boyutu */
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 3px; /* Küçültülmüş margin */
            background-color: #444;
            animation: neon-glow 1s infinite alternate;
        }

        .sub-menu-item:hover {
            background-color: #555;
        }

        .sub-menu-item.active {
            color: #0f0; /* Yeşil */
        }

        .sub-menu-item.inactive {
            color: #f00; /* Kırmızı */
        }

        .content {
            margin-left: 0;
            padding: 20px;
            flex: 1;
            overflow-y: auto; /* Allow vertical scrolling */
            border: 2px solid #0f0;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            transition: margin-left 0.3s ease-out;
            position: relative;
        }

        .menu-open .sidebar {
            display: block;
        }

        .menu-open .content {
            margin-left: 150px; /* Küçültülmüş margin */
        }

        .announcement-box {
            background-color: #222;
            color: #0f0;
            padding: 10px;
            margin: 5px; /* Küçültülmüş margin */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            animation: neon-glow 1s infinite alternate;
        }

        @keyframes neon-glow {
            0% { box-shadow: 0 0 10px rgba(395, 0, 0, 0.5); }
            25% { box-shadow: 0 0 20px rgba(399, 255, 0, 0.8); }
            50% { box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); }
            75% { box-shadow: 0 0 20px rgba(0, 0, 255, 0.8); }
            100% { box-shadow: 0 0 10px rgba(995, 0, 0, 0.5); }
        }

        .chat-box {
            width: 80%;
            max-height: 300px;
            overflow-y: auto;
            border: 2px solid #0f0;
            padding: 10px;
            background: #111;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            margin-bottom: 20px;
            color: #fff;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-form {
            display: flex;
            align-items: center;
        }

        .chat-form textarea {
            flex: 1;
            height: 50px;
            border: 2px solid #0f0;
            padding: 10px;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
            font-size: 14px; /* Büyütülmüş font boyutu */
        }

        .chat-form button {
            padding: 10px 20px;
            border: none;
            background-color: #0f0;
            color: #000;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        .neon-section {
            text-align: center;
            margin-top: 20px;
        }

        .neon-text {
            color: #0f0;
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            font-size: 24px;
            animation: neon-glow 1s infinite alternate;
        }

        .xp-section {
            margin-top: 20px;
        }

        .xp-bar {
            width: 80%;
            height: 20px;
            background-color: #333;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .xp-fill {
            height: 100%;
            background-color: #0f0;
            border-radius: 10px 0 0 10px;
            transition: width 0.5s ease-in-out;
        }

        .xp-level {
            color: #0f0;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .xp-ranking {
            margin-top: 20px;
        }

        .ranking-list {
            list-style: none;
            padding: 0;
        }

        .ranking-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .ranking-position {
            color: #0f0;
            font-weight: bold;
            margin-right: 10px;
        }

        .ranking-name {
            color: #fff;
            font-weight: bold;
        }

        .ranking-xp {
            color: #0f0;
            margin-left: auto;
        }
        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .sidebar {
            width: 120px;
            background-color: #111;
            padding: 5px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.5);
            border-right: 2px solid #0f0;
            display: none; /* Menü varsayılan olarak kapalı */
            z-index: 999;
        }

        .sidebar.open {
            display: block; /* Menü açıldığında görünür */
        }

        .menu-toggle {
            position: fixed;
            top: 10px;
            left: 10px;
            font-size: 20px;
            cursor: pointer;
            z-index: 1000;
            color: #0f0;
            background-color: #111;
            border: none;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
        }

        .menu-item {
            cursor: pointer;
            padding: 5px;
            background-color: #222;
            margin-bottom: 3px;
            transition: background-color 0.3s;
            text-align: center;
            border-radius: 5px;
            color: #0f0;
            font-weight: bold;
            font-size: 14px;
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .menu-item:hover {
            background-color: #333;
        }

        .sub-menu {
            background-color: #333;
            padding: 5px;
            border-radius: 5px;
            margin-top: 3px;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .sub-menu.open {
            max-height: 650px;
        }

        .sub-menu-item {
            display: block;
            padding: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: #0f0;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 3px;
            background-color: #444;
        }


        .announcement-box {
            background-color: #222;
            color: #0f0;
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            animation: neon-glow 1s infinite alternate;
        }

        @keyframes neon-glow {
            0% { box-shadow: 0 0 10px rgba(255, 0, 0, 0.5); }
            25% { box-shadow: 0 0 20px rgba(255, 255, 0, 0.8); }
            50% { box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); }
            75% { box-shadow: 0 0 20px rgba(0, 0, 255, 0.8); }
            100% { box-shadow: 0 0 10px rgba(255, 0, 0, 0.5); }
        }

        .chat-box {
            width: 80%;
            max-height: 300px;
            overflow-y: auto;
            border: 2px solid #0f0;
            padding: 10px;
            background: #111;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            margin-bottom: 20px;
            color: #fff;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-form {
            display: flex;
            align-items: center;
        }

        .chat-form textarea {
            flex: 1;
            height: 50px;
            border: 2px solid #0f0;
            padding: 10px;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
            font-size: 14px;
        }

        .chat-form button {
            padding: 10px 20px;
            border: none;
            background-color: #0f0;
            color: #000;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        .neon-section {
            text-align: center;
            margin-top: 20px;
        }

        .neon-text {
            color: #0f0;
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            font-size: 24px;
            animation: neon-glow 1s infinite alternate;
        }

        .neon-button {
            padding: 10px 20px;
            border: none;
            background-color: #0f0;
            color: #000;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            margin-top: 10px;
            animation: neon-glow 1s infinite alternate;
        }

        .neon-button:hover {
            background-color: #0b0;
        }

        .xp-section {
            margin-top: 20px;
        }

        .xp-bar {
            width: 80%;
            height: 20px;
            background-color: #333;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .xp-fill {
            height: 100%;
            background-color: #0f0;
            border-radius: 10px 0 0 10px;
            transition: width 0.5s ease-in-out;
        }

        .xp-level {
            color: #0f0;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .xp-ranking {
            margin-top: 20px;
        }

        .ranking-list {
            list-style: none;
            padding: 0;
        }

        .ranking-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .ranking-position {
            color: #0f0;
            font-weight: bold;
            margin-right: 10px;
        }

        .ranking-name {
            color: #fff;
            font-weight: bold;
        }

        .ranking-xp {
            color: #0f0;
            margin-left: auto;
        }

        .market-section {
            margin-top: 20px;
        }

        .package-item {
            background-color: #222;
            color: #0f0;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            cursor: pointer;
        }

        .package-item:hover {
            background-color: #0f0;
        }

        .package-item.active {
            background-color: #0f0;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="menu-toggle" onclick="toggleSidebar()">&#9776;</div>
    <div class="info-button" onclick="showInfo()">ℹ️</div>

    <div class="container">
        <div class="sidebar" id="sidebar">
            <ul class="menu-list">
                <li><a href=""></a></li>
                <li><a href="adsoyad.php">Ad Soyad</a></li>
                <li><a href="tc.php">TC</a></li>
                <li><a href="tcgsm.php">TC GSM</a></li>
                <li><a href="gsmtc.php">GSM TC</a></li>
                <li><a href="gsmdetay.php">GSM DETAY</a></li>
                <li><a href="adres.php">Adres</a></li>
                <li><a href="smsbomber.php">SMS BOMBER</a></li>
                <li><a href="isyeri.php">İŞ Yeri</a></li>
                <li><a href="aile.php">Aile</a></li>
                <li><a href="sulale.php">Sülale</a></li>
                <li><a href="sitesorgu.php">Site</a></li>
                <li><a href="GPT.php">Sohbet + GPT</a></li>
            </ul>
        </div>

<!-- Bilgi simgesi ve bilgi kutucuğu -->
<div class="info-button" onclick="showInfo()">ℹ️</div>
<div id="info-box" class="info-box">
            <h2>Logsuzlar Panel Kuralları (Zorunlu)</h2>
            <p>İstediğin sorguyu yap kankam</p>
            <p>Ünlüleri Sorgulama Ve.</p>
            <p>-18 Yaş Sorgulama Yeter ?</p>
            <p>Yapımcılar (Logsuzlar)</p>
            <a href="https://t.me/DenkOlamazsiniz" class="telegram-link" target="_blank">Telegram</a>
    <button onclick="hideInfo()">Kapat</button>
</div>

        <div class="content">
            <h2>Hoş Geldiniz!</h2>
            <div class="announcement-box">
                <p>DUYURU : Sorgu panelimiz Aktiftir!</p>
                <p>DUYURUYU YAPAN : Logsuzlar</p>
            </div>
            <div class="announcement-box">
                <p>DUYURU : SİSTEME HER GÜN GÜNCELLEME GELİYOR.</p>
                <p>DUYURUYU YAPAN : Logsuzlar</p>
            </div>
            <div class="neon-section">
                <span class="neon-text">GÜNÜN ŞARKISI</span>
                <button id="play-button" class="neon-button">Ses Çal</button>
                <audio id="audio" src="h4ck3r2.mp3" preload="auto"></audio>
            </div>
            <div class="announcement-box">
                <p>YENİ SORGULAR YAKINDADIR BY Logsuzlar</p>
            </div>
            <h2>CHAT SİSTEMİ</h2>
            <div class="chat-box" id="chat-box"></div>

           <div class="content" id="content">
                <h1 class="neon-text">Logsuzlar Sorgu Paneli Chat</h1>
              <a href="chat.php">
        <button class="button">Chat Giris</button>
             </a>
            </div>

            <div class="xp-section">
                <div class="xp-level">Seviye: 1</div>
                <div class="xp-bar" onclick="addXP(10)">
                    <div class="xp-fill"></div>
                </div>
            </div>

            <div class="xp-ranking">
                <h3>XP Sıralaması</h3>
                <ul class="ranking-list">
                    <li class="ranking-item">
                        <span class="ranking-position">1.</span>
                        <span class="ranking-name">Logsuzlar</span>
                        <span class="ranking-xp">1000 XP</span>
                    </li>
                    <li class="ranking-item">
                        <span class="ranking-position">2.</span>
                        <span class="ranking-name">Logsuzlar</span>
                        <span class="ranking-xp">900 XP</span>
                    </li>
                    <li class="ranking-item">
                        <span class="ranking-position">3.</span>
                        <span class="ranking-name">Logsuzlar</span>
                        <span class="ranking-xp">800 XP</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('open');
        });

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function () {
                const submenuId = this.getAttribute('data-submenu');
                const submenu = document.getElementById(submenuId);
                submenu.classList.toggle('open');
            });
        });

        function addXP(xpGain) {
            let xpBar = document.querySelector('.xp-fill');
            let currentXP = parseInt(xpBar.style.width) || 0;
            let newXP = currentXP + xpGain;
            xpBar.style.width = newXP + '%';
            saveXP(newXP);
        }

        function saveXP(xp) {
            fetch('xp.txt', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `xp=${xp}`
            }).then(response => console.log("XP kaydedildi:", response));
        }

function showInfo() {
    document.getElementById('info-box').style.display = 'block';
}

function hideInfo() {
    document.getElementById('info-box').style.display = 'none';
}


        // Şarkıyı oynat/durdur işlevi
        document.getElementById('play-button').addEventListener('click', () => {
            const audio = document.getElementById('audio');
            if (audio.paused) {
                audio.play();
                document.getElementById('play-button').textContent = 'Ses Durdur';
            } else {
                audio.pause();
                document.getElementById('play-button').textContent = 'Ses Çal';
            }
        });
    </script>
</body>
</html>
