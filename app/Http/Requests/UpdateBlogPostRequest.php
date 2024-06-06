<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogPostRequest extends FormRequest
{
    protected $id;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:80',
            'slug' => 'nullable|string|max:80', Rule::unique('blog_posts', 'slug')->ignore($this->id),
            'cover_image' => 'nullable|image|mimes:png,jpg, jpeg,webp|max:2048',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:150',
            'meta_keywords' => 'nullable|string',
        ];
    }
}
