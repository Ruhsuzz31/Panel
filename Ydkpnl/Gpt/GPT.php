<?php
// Parametreyi al
$mesaj = $_GET['mesaj'];

// Hedef API'nin URL'sini oluştur
$apiUrl = "https://tilki.dev/api/sohbet?soru=merhaba" . urlencode($mesaj);

// API'ye istek gönder
$response = file_get_contents($apiUrl);

// Yanıtı döndür
header('Content-Type: application/json');
echo $response;
?>