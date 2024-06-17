<?php

namespace App\Helpers;
use App\Helpers\MetaData;
use App\Models\BlogPost;
use App\Models\Post;
use App\Models\Website_meta_description;
use App\Models\WebsiteMetaTitle;
use Illuminate\Support\Str;

class PageMetaData
{
    const DEFAULT_SUFFIX = "- Insightblog";
    const DEFAULT_KEYWORDS = "Read, Research, Learn stuffs, Explore Services.";

    public static function getTitle(string $name)
    {
        return $name . " " . self::DEFAULT_SUFFIX;
    }

    public static function getDefaultKeywords()
    {
        return self::DEFAULT_KEYWORDS;
    }

    public static function createMetaData($title, $description, $ogUrl, $ogImage = null)
    {
        $meta = new MetaData();
        $customMetaData = new Website_meta_description();
        $metaTitle = (new WebsiteMetaTitle())->appName();
        return $meta
        ->setAttribute("title",  $metaTitle ?? $title)
        ->setAttribute("description", $customMetaData->description ?? $description)
        ->setAttribute("keywords", self::getDefaultKeywords())
        ->setAttribute("og_url", $ogUrl)
        ->setAttribute("og_image", $ogImage ?? asset('web/images/default-image.png'));
    }

    public static function welcome()
    {
        return self::createMetaData(
            'Welcome to SwiftlySend',
            'Discover SwiftlySend - Your Premier Destination for Cutting-Edge Infomation and Tech Solutions. Explore Our Website Today!',
            'https://blog.swiftlysend.online/'
        );
    }

    public static function getPostMetaData(BlogPost $post)
    {
        // Example: Assuming $post is an instance of Post model
        return self::createMetaData(
            $post->title,
            $post->meta_description ?? self::getDefaultKeywords(),
            route('post.details', $post->slug),
            asset('storage/blog/cover_images/' . $post->cover_image)  ??  asset('web/images/default-image.png'),
        );
    }

    // public static function contactUS()
    // {
    //     return self::createMetaData(
    //         'Contact Us - SwiftlySend',
    //         'Get in touch with SwiftlySend for inquiries and support.',
    //         'https://swiftlysend.online/web/contact-us'
    //     );
    // }

    // public static function aboutUs()
    // {
    //     return self::createMetaData(
    //         'About Us - SwiftlySend',
    //         'Learn more about SwiftlySend and our services.',
    //         'https://swiftlysend.online/web/about-us'
    //     );
    // }

   



    
}
