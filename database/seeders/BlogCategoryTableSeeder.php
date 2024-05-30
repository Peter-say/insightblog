<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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


        $datas = [
            [
                'image' =>  $savedImage,
                'name' => 'Tech',
            ],

            [
                'image' =>  $savedImage,
                'name' => 'Electronics',
            ],

            [
                'image' =>  $savedImage,
                'name' => 'Football',
            ],

            [
                'image' =>  $savedImage,
                'name' => 'Phones',
            ],

            [
                'image' =>  $savedImage,
                'name' => 'Laptop',
            ],
        ];

        foreach ($datas as $key => $data) {
                BlogCategory::create($data);
        }
    }
}
