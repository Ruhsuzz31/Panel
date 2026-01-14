<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <script src="Logsuz.js"></script>
    <title>Logsuzlar Checker</title>
    <link rel="canonical" href="https://newtonbulem.000webhostapp.com" />
    <style>
        body {
            background-image: url('1.gif');
            background-color: #000;
            height: 100%;
            position: relative;
            margin: 0;
            padding: 0;
            color: #fff;
            background-repeat: no-repeat;
            background-size: cover;
            zoom: 1.5; /* This zooms in the entire body */
            transform-origin: 0 0; /* Keeps the zoom centered from the top-left corner */
        }
        .username-box {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #111;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            z-index: 99999;
        }
        .username-box button {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: rgba(255, 0, 0, 0.5);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .username-box button:hover {
            background-color: rgba(255, 0, 0, 0.7);
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 300px;
            margin: 0 auto;
            background-color: rgba(28, 28, 28, 0.9);
            border-radius: 6px;
            padding: 10px 15px;
            margin-top: 20px;
        }
        .container input,
        .container button {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        .container button {
            background-color: rgba(0, 205, 0);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container button:hover {
            background-color: rgba(0, 238, 0);
        }
        h1 {
            font-size: 20px;
            color: #fff;
            margin-bottom: 15px;
        }
        .result-container {
            margin-top: 10px;
            padding: 15px;
            width: 100%;
            background-color: rgba(28, 28, 28, 0.9);
            border-radius: 6px;
        }
        .result-container .smsStatus {
            color: #111;
            padding: 10px;
            background-color: #fff;
            margin-top: 5px;
            font-size: 16px;
            text-align: center;
        }
        .result-container .smsstat {
            color: #fff;
            text-align: center;
            font-size: 15px;
        }
        .result-container .not {
            text-align: center;
            margin-top: 10px;
        }
        .statcontainer-wrap {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
        .additional-container {
            display: none;
            width: 500%;
            max-width: 900px;
            max-height: 80vh;
            background-color: rgba(28, 28, 28);
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 15px 20px;
            overflow-y: auto;
        }
        .statusMessages {
            color: #fff;
            font-size: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Logsuzlar Checker</h1>
    <input type="text" id="phoneNumber" placeholder="Telefon numarası">
    <input type="number" id="smsAmount" placeholder="SMS miktarı">
    <input type="number" id="workerAmount" placeholder="Threads miktarı">
    <button onclick="start()">Gönder</button>
</div>
<div class="result-container">
    <label class="smsstat">SMS Durumu:</label>
    <div class="smsStatus" id="smsStatus"></div>
    <div id="result"></div>
    <pre class="not">Not: Thread 50-100 arası Önerilir.</pre>
</div>
<div class="statcontainer-wrap">
    <div id="additional-container" class="additional-container">
        <div id="statusMessages"></div>
    </div>
</div>
<script>
    function redirectToLink() {
    }
</script>
<div class="footer">
    &copy; Logsuzlar Checker
</div>
</body>
</html>
