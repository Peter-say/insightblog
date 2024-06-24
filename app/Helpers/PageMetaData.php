<?php

namespace App\Helpers;

use App\Helpers\MetaData;
use App\Models\BlogPost;
use App\Models\Website_meta_description;
use App\Models\WebsiteMetaTitle;
use Illuminate\Support\Str;

class PageMetaData
{
    const DEFAULT_SUFFIX = "Insightblog";
    const DEFAULT_KEYWORDS = " - Read, Research, Learn stuffs, Explore Services.";

    public static function getTitle()
    {
        return self::DEFAULT_SUFFIX;
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
            ->setAttribute("title", $title)
            ->setAttribute("description", $customMetaData->description ?? $description)
            ->setAttribute("keywords", self::getDefaultKeywords())
            ->setAttribute("og_url", $ogUrl)
            ->setAttribute("og_image", $ogImage ?? asset('web/images/default-image.png'));
    }

    public static function welcome()
    {
        return self::createMetaData(
            'Welcome to Insightblog' .  self::getDefaultKeywords(),
            'Discover SwiftlySend - Your Premier Destination for Cutting-Edge Information and Tech Solutions. Explore Our Website Today!',
            'https://blog.swiftlysend.online/'
        );
    }

    public static function getPostMetaData(BlogPost $post)
    {
        return self::createMetaData(
            $post->title,
            $post->meta_description ?? Str::limit($post->body, 150),
            route('post.details', $post->slug),
           $post_image = asset('storage/blog/images/' . $post->cover_image) ?? asset('web/images/default-image.png'),
        //    dd($post_image),
        );
    }
}
