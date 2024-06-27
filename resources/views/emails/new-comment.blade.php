<!DOCTYPE html>
<html>
<head>
    <title>New Comment Submitted</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e6e6e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #666;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-view-comment {
            background-color: #28a745;
            margin-top: 20px;
        }
        .regards {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>New Comment Submitted</h1>
        <p>Hello {{ $user->name }},</p>
        <p>A new comment has been submitted on your post. Here are the details:</p>
        <ul>
            <li><strong>Comment:</strong> {{ $comment->body }}</li>
            <li><strong>Submitted by:</strong> {{ $comment->commenter_name }}</li>
        </ul>
        <p>You can view the comment by clicking the button below:</p>
        <span>
            <a href="{{  route('dashboard.comments.index') }}?highlight_comment_id={{ $comment->id }}" target="_blank" rel="noopener noreferrer">
                {{-- {{ $comment->post->title }} --}}
                View Comment
            </a>
        </span>
        {{-- <a class="btn btn-view-comment" href="{{ route('dashboard.comments.show', $comment->id) }}">View Comment</a> --}}
        <p class="regards">Regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
