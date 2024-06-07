<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        try {
            if (Auth::check()) {
                $request->validate([
                    'body' => 'required',
                    
                ]);
    
                $comment = new BlogComment();
                $comment->body = $request->input('body');
                $comment->user_id = Auth::id(); // Ensure user is authenticated
                $comment->post_id = $postId;
                $comment->parent_id = $request->input('parent_id');
                $comment->save();
    
                $successMessage = 'Comment submitted successfully.';
                Session::flash('success', $successMessage);
    
                return response()->json(['success' => true, 'comment' => $comment, 'message' => $successMessage]);
            } else {
                return back()->with('error_message', 'You need to login to make a comment.');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to submit comment: ' . $e->getMessage());
    
            // Flash error message
            $errorMessage = 'Failed to submit comment.';
            Session::flash('error_message', $errorMessage);
    
            // Return JSON response with error
            return response()->json(['success_mesage' => false, 'message' => $errorMessage]);
        }
    }
    
}
