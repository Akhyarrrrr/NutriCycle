<?php

use Cloudinary\Cloudinary;
use Illuminate\Support\Str;

if (! function_exists('cloudinaryUrl')) {
    function cloudinaryUrl(?string $publicId, array $options = []): string
    {
        if ($publicId === null || $publicId === '') {
            return asset('images/product-placeholder.svg');
        }

        if (Str::startsWith($publicId, ['http://', 'https://'])) {
            return $publicId;
        }

        if (Str::startsWith($publicId, 'local:')) {
            return asset(Str::after($publicId, 'local:'));
        }

        if (Str::startsWith($publicId, ['uploads/', '/uploads/'])) {
            return asset(ltrim($publicId, '/'));
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
