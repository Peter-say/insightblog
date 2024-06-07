<?php

namespace App\Livewire;

use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BlogCommentReply extends Component
{
    public $post_id;
    public $comment_id;
    public $commenter_name;
    public $commenter_email;
    public $commenter_website;
    public $body;
    public $showReplyForm = false; // Initialize to false

    public function mount($commentId)
    {
        $this->comment_id = $commentId;

        if (Auth::check()) {
            $this->commenter_name = Auth::user()->name;
            $this->commenter_email = Auth::user()->email;
        }
    }

    protected $rules = [
        'body' => 'required|string',
        'commenter_name' => 'required_if:commenter_email,null|string|max:255',
        'commenter_email' => 'required_if:commenter_name,null|email|max:255',
        'commenter_website' => 'nullable|url|max:255',
    ];

    public function submit()
    {
        $this->validate();

        BlogComment::create([
            'post_id' => $this->post_id,
            'commenter_name' => $this->commenter_name,
            'commenter_email' => $this->commenter_email,
            'commenter_website' => $this->commenter_website,
            'body' => $this->body,
            'parent_id' => $this->comment_id,
            'status' => 'pending',
        ]);

        $this->reset(['commenter_website', 'body']);
        $this->showReplyForm = false; // Hide the reply form after submission

        session()->flash('success_message', 'Reply submitted successfully.');
    }

    public function toggleReplyForm()
    {
        // Toggle the visibility of the reply form
        $this->showReplyForm = !$this->showReplyForm;
    }

    public function render()
    {
        return view('livewire.blog-comment-reply');
    }
}
