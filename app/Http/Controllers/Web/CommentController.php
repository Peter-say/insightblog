<?php

namespace App\Http\Controllers\Web;

use App\Events\CommentSubmitted;
use App\Http\Controllers\Controller;
use App\Mail\CommentSubmittedMail;
use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validation rules
            $rules = [
                'body' => 'required|string',
                'commenter_website' => 'nullable|url|max:255',
                'post_id' => 'required|exists:blog_posts,id',
                'parent_id' => 'nullable|exists:blog_comments,id',
            ];

            // Additional rules for guest users
            if (!Auth::check()) {
                $rules['commenter_name'] = 'required|string|max:255';
                $rules['commenter_email'] = 'required|email|max:255';
            }

            $validatedData = $request->validate($rules);

            // If user is authenticated, use their name and email
            if (Auth::check()) {
                $validatedData['commenter_name'] = Auth::user()->name;
                $validatedData['commenter_email'] = Auth::user()->email;
            }

            // Store guest user details in cookies if provided
            if (!$request->user()) {
                Cookie::queue('commenter_name', $validatedData['commenter_name'], 43200); // 30 days expiration
                Cookie::queue('commenter_email', $validatedData['commenter_email'], 43200); // 30 days expiration
                Cookie::queue('commenter_website', $validatedData['commenter_website'], 43200); // 30 days expiration

                // Store in session as well
                Session::put('commenter_name', $validatedData['commenter_name']);
                Session::put('commenter_email', $validatedData['commenter_email']);
                Session::put('commenter_website', $validatedData['commenter_website']);
            }

            $comment = BlogComment::create([
                'post_id' => $validatedData['post_id'],
                'commenter_name' => $validatedData['commenter_name'],
                'commenter_email' => $validatedData['commenter_email'],
                'commenter_website' => $request->input('commenter_website'),
                'body' => $validatedData['body'],
                'parent_id' => $request->input('parent_id'),
                'status' => 'approved',
            ]);

            $comment->load('replies');
            // Dispatch the event when a comment is submitted
            event(new CommentSubmitted($comment));

            // Send email notification to the admin
            $adminUsers = User::where('role', 'Admin')->get();
            foreach ($adminUsers as $admin) {
                Mail::to($admin->email)->send(new CommentSubmittedMail($admin, $comment));
            }

            // Send email notification to the author of the blog post
            $author = $comment->post->user;
            Mail::to($author->email)->send(new CommentSubmittedMail($author, $comment));
            return response()->json(['success' => true, 'comment' => $comment, 'message' => 'Comment submitted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to submit comment: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to submit comment.']);
        }
    }
}
