<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warning Notification</title>
  <style>
    body {
      margin: 0;
      padding: 20px;
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
      color: #333;
    }
    .email-container {
      max-width: 650px;
      margin: auto;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.06);
    }
    .header {
      background-color: #ffe0e0;
      padding: 25px;
      text-align: center;
    }
    .header h2 {
      color: #c0392b;
      margin: 0;
      font-size: 24px;
    }
    .body {
      padding: 30px;
    }
    .body p {
      line-height: 1.6;
      font-size: 15px;
    }
    .report-box {
      background-color: #fff7f0;
      padding: 15px 20px;
      border-left: 4px solid #f0ad4e;
      margin: 20px 0;
      border-radius: 6px;
    }
    .reporter {
      font-weight: bold;
      color: #555;
      margin-top: 10px;
    }
    .post-content {
      margin-top: 25px;
      background-color: #fefefe;
      border-left: 4px solid #d9534f;
      padding: 15px;
      border-radius: 6px;
    }
    .media-preview {
      margin-top: 15px;
      text-align: center;
    }
    .media-preview img,
    .media-preview video {
      max-width: 100%;
      border-radius: 8px;
      border: 1px solid #ddd;
    }
    .button-wrapper {
      text-align: center;
      margin-top: 30px;
    }
    .btn {
      background-color: #f0ad4e;
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      display: inline-block;
    }
    .footer {
      margin-top: 40px;
      padding: 20px;
      font-size: 13px;
      color: #888;
      text-align: center;
      border-top: 1px solid #eee;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h2>⚠️ Content Warning</h2>
    </div>
    <div class="body">
      <p>Hello {{ $reported_person->firstname }} {{ $reported_person->lastname }},</p>

      <p>We've received a report regarding a recent post you shared. It may not align with our community guidelines and was flagged for review.</p>

      <div class="report-box">
        <p><strong>Reported by:</strong> {{ $reporter->firstname }} {{ $reporter->lastname }}</p>
        <p class="reporter">Please review the content below.</p>
      </div>

      <div class="post-content">
        <p>{{ $post->content }}</p>
      <p>This is only a warning; no action has been taken yet. We encourage you to review our guidelines and ensure your future posts are in alignment.</p>
      <div class="button-wrapper">
        <a href="{{ url('/community-guidelines') }}" class="btn">Review Guidelines</a>
      </div>
    </div>
    <div class="footer">
      <p>If you believe this was an error, please contact our support team.</p>
      <p>© {{ date('Y') }} Rassid. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
