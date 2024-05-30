<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\FileHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Admin' || $user->role === 'Moderator') {
            $blogs = BlogPost::with('category')->paginate(30);
        } else {
            $blogs = BlogPost::with('category')->where('user_id', $user->id)->paginate(30);
        }

        return view('dashboard.blog.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::where('status', 'active')->get();
        return view('dashboard.blog.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogPostRequest $request)
    {

        try {
            $coverImagePath = '';

            if ($request->hasFile('cover_image')) {
                $coverImageDirectory = 'blog/cover_images';
                Storage::disk('public')->makeDirectory($coverImageDirectory);
                $coverImagePath = basename(FileHelpers::saveImageRequest($request->file('cover_image'), $coverImageDirectory));
            }

            $user = Auth::user();
            $data = $request->all();
            $data['user_id'] = $user->id;
            $data['cover_image'] = $coverImagePath;

            if ($request->input('confirm_published_date')) {
                $data['published_at'] = now(); // Set published_at to current date and time
            }

            //   dd($request->all(), $data);
            BlogPost::create($data);

            return redirect()->route('dashboard.blog.index')->with('success_message', 'Post submitted successfully');
        } catch (\Exception $e) {
            Log::error('Error creating blog post: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'An error occurred while submitting the post. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = BlogPost::findOrFail($id);
        $categories = BlogCategory::where('status', 'active')->get();
        return view('dashboard.blog.edit', [
            'categories' => $categories,
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogPostRequest $request, string $id)
    {
        try {
            $blogPost = BlogPost::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('cover_image')) {
                $coverImageDirectory = 'blog/cover_images';
                Storage::disk('public')->makeDirectory($coverImageDirectory);
                $coverImagePath = basename(FileHelpers::saveImageRequest($request->file('cover_image'), $coverImageDirectory));
                $data['cover_image'] = $coverImagePath;


                if ($blogPost->cover_image) {
                    Storage::disk('public')->delete('blog/cover_images/' . $blogPost->cover_image);
                }
            }

            if ($request->input('published_at')) {
                $data['published_at'] = now(); // Set published_at to current date and time
            }
           
            $blogPost->update($data);

            return redirect()->route('dashboard.blog.index')->with('success_message', 'Post updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating blog post: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'An error occurred while updating the post. Please try again.' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Add logic to delete a blog post
    }

    /**
     * Handle image uploads for TinyMCE.
     */
    public function uploadImage(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('public/blog/images');
                $url = Storage::url($path);
                return response()->json(['url' => $url]);
            } else {
                return response()->json(['error' => 'No file uploaded'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed'], 500);
        }
    }

    public function updateFeatured(Request $request, $id)
    {
        try {
            $blog = BlogPost::findOrFail($id);
            $blog->update(['is_featured' => $request->input('is_featured')]);
            session()->flash('success_message', 'Blog feature updated');
        } catch (Exception $e) {
            session()->flash('error_message', 'Cannot update: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function searchBlogs(Request $request)
    {
        $searchValue = $request->input('search_blogs');
        $user = Auth::user();

        $query = BlogPost::query();

        if ($user->role !== 'Admin' && $user->role !== 'Moderator') {
            $query->where('user_id', $user->id);
        }

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'LIKE', "%$searchValue%")
                    ->orWhere('body', 'LIKE', "%$searchValue%")
                    ->orWhere('slug', 'LIKE', "%$searchValue%")
                    ->orWhereHas('user', function ($q) use ($searchValue) {
                        $q->where('name', 'LIKE', "%$searchValue%");
                    })
                    ->orWhereHas('category', function ($q) use ($searchValue) {
                        $q->where('name', 'LIKE', "%$searchValue%");
                    });
            });
        }

        $blogs = $query->paginate(10);

        return response()->json([
            'html' => view('dashboard.blog.search-items', compact('blogs'))->render(),
        ]);
    }
}
