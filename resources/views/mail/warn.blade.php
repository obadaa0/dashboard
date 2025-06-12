<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Warning Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eee;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 26px;
            color: #c9302c;
        }
        .message {
            font-size: 16px;
            line-height: 1.7;
        }
        .content-box {
            background-color: #fcf8e3;
            border: 1px solid #faebcc;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .avatar {
            width: 45px;
            height: 45px;
            background-color: #ddd;
            border-radius: 50%;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #555;
        }
        .post-content {
            background: #f5f5f5;
            padding: 20px;
            border-left: 5px solid #c9302c;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .media-container {
            margin-top: 15px;
            text-align: center;
        }
        .media-container img,
        .media-container video {
            max-width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #c9302c;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: center;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Content Warning</h1>
        </div>

        <p class="message">
            Dear <strong>{{ $reported_person->firstname }} {{ $reported_person->lastname }}</strong>,
        </p>

        <p class="message">
            We are reaching out because a recent post of yours has been reported by another user as possibly violating our community guidelines.
        </p>

        <div class="content-box">
            <h3>📋 Report Details</h3>
            <div class="user-info">
                <div class="avatar">{{ substr($reporter->firstname, 0, 1) }}{{ substr($reporter->lastname, 0, 1) }}</div>
                <div>
                    <strong>Reported by:</strong> {{ $reporter->firstname }} {{ $reporter->lastname }}
                </div>
            </div>
        </div>

        <h3>📝 Your Reported Post</h3>
        <div class="post-content">
            <p>{{ $post->content }}</p>

            @if($post->media)
                <div class="media-container">
                    @php
                        $extension = pathinfo($post->media, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                        <video controls>
                            <source src="{{ asset('storage/' . $post->media) }}" type="video/{{ $extension }}">
                            Your browser does not support the video tag.
                        </video>
                    @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                        <img src="{{ asset('storage/' . $post->media) }}" alt="Reported Media">
                    @else
                        <p><em>Unsupported media format.</em></p>
                    @endif
                </div>
            @endif
        </div>

        <p class="message">
            Please take a moment to review our community guidelines to ensure your future content aligns with our platform's values. This is a courtesy warning—no immediate action has been taken on your account.
        </p>

        <div style="text-align: center;">
            <a href="{{ url('/community-guidelines') }}" class="btn">Review Community Guidelines</a>
        </div>

        <div class="footer">
            <p>If you believe this report was submitted in error, please contact our support team for assistance.</p>
            <p>&copy; {{ date('Y') }} Rassid. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
