<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BlogPost::class;

    public function definition(): array
    {
       

        $imageDirectory = public_path('dashboard/assets/img/blogs/');
        $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        if (empty($images)) {
            throw new \Exception("No images found in the directory: $imageDirectory");
        }

        $randomImage = $images[array_rand($images)];
        $basename = basename($randomImage);

        // Destination directory
        $destinationPath = 'blog/images/' . $basename;

        // Check if the file already exists in storage
        if (Storage::disk('public')->exists($destinationPath)) {
            // If it exists, delete it
            Storage::disk('public')->delete($destinationPath);
        }

        // Ensure the file exists before reading
        if (!File::exists($randomImage)) {
            throw new \Exception("File does not exist: $randomImage");
        }

        // Store the image in the storage directory
        Storage::disk('public')->put($destinationPath, file_get_contents($randomImage));

        // Save the basename to the string
        $savedImage = $basename;

        
        $faker = \Faker\Factory::create();
        $title = $faker->sentence;
        $slug = Str::slug($title, '-');
        $meta_keyword = implode(',', $faker->words(mt_rand(3, 5)));

        return [
            'user_id' => 1,
            'category_id' => mt_rand(1, 5), 
            'title' => $title,
            'slug' => $slug,
            'cover_image' => $savedImage,
            'body' => $faker->paragraphs(mt_rand(3, 7), true),
            'published_at' => $faker->optional()->dateTime,
            'meta_title' => $faker->optional()->sentence,
            'meta_description' => $faker->optional()->sentence,
            'meta_keywords' => $meta_keyword,
        ];
    }
}
