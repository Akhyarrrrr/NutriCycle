<?php

namespace App\Support;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Throwable;

class CloudinaryStorage
{
    public function upload(UploadedFile $file): ?string
    {
        if (blank(config('cloudinary.url'))) {
            return null;
        }

        $cloudinary = new Cloudinary(config('cloudinary.url'));

        try {
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => config('cloudinary.folder'),
                'resource_type' => 'image',
            ]);

            return $result['public_id'] ?? null;
        } catch (Throwable) {
            return null;
        }
    }

    public function delete(?string $publicId): void
    {
        if (blank($publicId) || blank(config('cloudinary.url'))) {
            return;
        }

        $cloudinary = new Cloudinary(config('cloudinary.url'));

        try {
            $cloudinary->uploadApi()->destroy($publicId, ['resource_type' => 'image']);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
