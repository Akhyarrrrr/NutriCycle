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
            $relativePath = Str::after($publicId, 'local:');

            return file_exists(public_path($relativePath))
                ? asset($relativePath)
                : asset('images/product-placeholder.svg');
        }

        if (Str::startsWith($publicId, ['uploads/', '/uploads/'])) {
            $relativePath = ltrim($publicId, '/');

            return file_exists(public_path($relativePath))
                ? asset($relativePath)
                : asset('images/product-placeholder.svg');
        }

        $cloudinaryUrl = config('cloudinary.url');

        if ($cloudinaryUrl === null || $cloudinaryUrl === '') {
            return asset('images/product-placeholder.svg');
        }

        try {
            $cloudinary = new Cloudinary($cloudinaryUrl);

            return (string) (empty($options)
                ? $cloudinary->image($publicId)->toUrl()
                : $cloudinary->image($publicId)->toUrl($options));
        } catch (Throwable) {
            return asset('images/product-placeholder.svg');
        }
    }
}
