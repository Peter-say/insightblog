<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = BlogComment::all();
        return view('dashboard.comment', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = BlogComment::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update($request->only('body'));
        return back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();
        return back()->with('success_message', 'Comment deleted successfully.');
    }

    public function approve(string $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'approved', 'moderated_at' => now()]);
        return back()->with('success_mesage', 'Comment approved successfully.');
    }

    public function reject(string $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->update(['status' => 'rejected', 'moderated_at' => now()]);
        return back()->with('success_message', 'Comment rejected successfully.');
    }

}
