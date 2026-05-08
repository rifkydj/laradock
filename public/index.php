<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrankenPHP is Running! 🎉</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 600px;
        }
        h1 {
            color: #333;
            margin: 0 0 20px 0;
            font-size: 2.5em;
        }
        .success {
            color: #4CAF50;
            font-size: 3em;
            margin: 20px 0;
        }
        p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            margin: 15px 0;
        }
        .info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            text-align: left;
            margin: 20px 0;
            font-family: monospace;
            font-size: 0.9em;
            color: #333;
        }
        .port {
            color: #667eea;
            font-weight: bold;
        }
        .features {
            text-align: left;
            margin: 30px 0;
        }
        .features li {
            margin: 10px 0;
            color: #666;
        }
        .version {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success">✅</div>
        <h1>FrankenPHP is Running!</h1>

        <p>Your FrankenPHP application server is up and running on:</p>
        <p><strong class="port">http://localhost:8085</strong></p>

        <div class="version">
            PHP Version: <?php echo phpversion(); ?>
        </div>

        <div class="info">
            <strong>Server Information:</strong><br>
            Server Software: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?><br>
            HTTP Host: <?php echo $_SERVER['HTTP_HOST'] ?? 'Unknown'; ?><br>
            Document Root: <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?>
        </div>

        <div class="features">
            <strong>What's Included:</strong>
            <ul style="padding-left: 20px;">
                <li>✅ FrankenPHP with built-in Caddy Web Server</li>
                <li>✅ PHP 8.3 with common extensions</li>
                <li>✅ Access to MySQL at: <code style="background: #f0f0f0; padding: 2px 5px;">mysql:3306</code></li>
                <li>✅ Access to Redis at: <code style="background: #f0f0f0; padding: 2px 5px;">redis:6379</code></li>
                <li>✅ Access to RabbitMQ at: <code style="background: #f0f0f0; padding: 2px 5px;">rabbitmq:5672</code></li>
            </ul>
        </div>

        <p style="color: #999; font-size: 0.9em; margin-top: 40px;">
            Running alongside Nginx on port <strong>8083</strong>
        </p>
    </div>
</body>
</html>

