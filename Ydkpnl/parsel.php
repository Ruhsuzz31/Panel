<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parsel Sorgusu</title>
    <style>
        @keyframes neon {
            from {
                text-shadow: 0 0 5px #0f0, 0 0 10px #0f0, 0 0 20px #0f0, 0 0 30px #0f0, 0 0 40px #0f0, 0 0 50px #0f0, 0 0 60px #0f0;
            }
            to {
                text-shadow: 0 0 10px #0f0, 0 0 20px #0f0, 0 0 30px #0f0, 0 0 40px #0f0, 0 0 50px #0f0, 0 0 60px #0f0, 0 0 70px #0f0;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.6);
        }

        h1 {
            color: #0f0;
            margin-bottom: 30px;
            animation: neon 1.5s ease-in-out infinite alternate;
        }

        iframe {
            width: 100%;
            height: 500px;
            border: none;
            margin-bottom: 20px;
        }

        button {
            background-color: #0f0;
            color: #222;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin: 10px;
            animation: neon 1.5s ease-in-out infinite alternate;
        }

        button:hover {
            background-color: #00cc00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PARSEL SORGU</h1>
        <iframe src="https://parselsorgu.tkgm.gov.tr/"></iframe>
        <button onclick="window.history.back()">Geri</button>
    </div>
</body>
</html>
