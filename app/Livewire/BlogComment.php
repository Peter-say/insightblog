<?php

namespace App\Livewire;

use App\Models\BlogComment as ModelsBlogComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BlogComment extends Component
{
    public $post_id;
    public $commenter_name;
    public $commenter_email;
    public $commenter_website;
    public $body;
    public $parent_id = null;
    public $showReplyForm = false; // Initialize to false

    public function mount($postId)
    {
        $this->post_id = $postId;

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

        ModelsBlogComment::create([
            'post_id' => $this->post_id,
            'commenter_name' => $this->commenter_name,
            'commenter_email' => $this->commenter_email,
            'commenter_website' => $this->commenter_website,
            'body' => $this->body,
            'parent_id' => $this->parent_id,
            'status' => 'pending',
        ]);

        $this->reset(['commenter_website', 'body']);

        session()->flash('success_message', 'Comment submitted successfully.');
    }

    public function showReplyForm($parentId)
    {
        // Set the parent_id and show the reply form
        $this->parent_id = $parentId;
        $this->showReplyForm = true;
    }

    public function hideReplyForm()
    {
        // Hide the reply form
        $this->showReplyForm = false;
    }

    public function closePopup()
    {
        //
    }

    public function render()
    {
        return view('livewire.blog-comment');
    }
}
