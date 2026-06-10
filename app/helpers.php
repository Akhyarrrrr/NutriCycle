<?php

use Cloudinary\Cloudinary;

if (! function_exists('cloudinaryUrl')) {
    function cloudinaryUrl(?string $publicId, array $options = []): string
    {
        if ($publicId === null || $publicId === '') {
            return asset('images/product-placeholder.svg');
        }

        $cloudinaryUrl = config('cloudinary.url');

        if ($cloudinaryUrl === null || $cloudinaryUrl === '') {
            return asset('images/product-placeholder.svg');
        }

        try {
            $cloudinary = new Cloudinary($cloudinaryUrl);

            return (string) $cloudinary->image($publicId)->toUrl($options);
        } catch (Throwable) {
            return asset('images/product-placeholder.svg');
        }
    }
}
