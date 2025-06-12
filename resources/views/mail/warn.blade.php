<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Warning Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #d9534f;
            margin: 0;
            font-size: 24px;
        }
        .content-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .post-content {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-left: 4px solid #d9534f;
            border-radius: 4px;
        }
        .media-container {
            margin-top: 15px;
            text-align: center;
        }
        .media-container img, .media-container video {
            max-width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Content Warning Notification</h1>
        </div>

        <p>Dear {{ $reported_person->firstname }} {{ $reported_person->lastname }},</p>

        <p>We're contacting you because your recent post has been reported by another user for potentially violating our community guidelines.</p>

        <div class="content-box">
            <h3>Report Details:</h3>

            <div class="user-info">
                <div class="avatar">{{ substr($reporter->firstname, 0, 1) }}{{ substr($reporter->lastname, 0, 1) }}</div>
                <div>
                    Reported by: <strong>{{ $reporter->firstname }} {{ $reporter->lastname }}</strong>
                </div>
            </div>
        </div>

        <h3>Your Reported Post:</h3>
        <div class="post-content">
            <p>{{ $post->content }}</p>
            @if($post->media)
            <div class="media-container">
                @if(pathinfo($post->media, PATHINFO_EXTENSION) === 'mp4')
                    <video controls>
                        <source src="{{ asset('storage/' . $post->media) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $post->media) }}" alt="Post media">
                @endif
            </div>
            @endif
        </div>

        <p>Please review our community guidelines to ensure your content aligns with our standards. This is a warning notification - no immediate action has been taken on your account.</p>

        <div style="text-align: center;">
            <a href="{{ url('/community-guidelines') }}" class="btn">Review Guidelines</a>
        </div>

        <div class="footer">
            <p>If you believe this report was made in error, you may contact our support team.</p>
            <p>© {{ date('Y') }} Rassid. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
