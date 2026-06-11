<?php

namespace App\Support;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class CloudinaryStorage
{
    public function upload(UploadedFile $file): ?string
    {
        if (blank(config('cloudinary.url'))) {
            return $this->storeLocallyWhenAllowed($file);
        }

        $cloudinary = new Cloudinary(config('cloudinary.url'));

        try {
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => config('cloudinary.folder'),
                'resource_type' => 'image',
            ]);

            return $result['public_id'] ?? null;
        } catch (Throwable $e) {
            report($e);

            return $this->storeLocallyWhenAllowed($file);
        }
    }

    public function delete(?string $publicId): void
    {
        if (blank($publicId)) {
            return;
        }

        if (str_starts_with($publicId, 'local:')) {
            $path = public_path(Str::after($publicId, 'local:'));

            if (File::exists($path)) {
                File::delete($path);
            }

            return;
        }

        if (blank(config('cloudinary.url'))) {
            return;
        }

        $cloudinary = new Cloudinary(config('cloudinary.url'));

        try {
            $cloudinary->uploadApi()->destroy($publicId, ['resource_type' => 'image']);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function storeLocally(UploadedFile $file): ?string
    {
        try {
            $directory = public_path('uploads/produk');

            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $extension = $file->extension() ?: $file->guessExtension() ?: 'jpg';
            $filename = Str::uuid().'.'.$extension;

            $file->move($directory, $filename);

            return 'local:uploads/produk/'.$filename;
        } catch (Throwable $e) {
            report($e);

            return null;
        }
    }

    private function storeLocallyWhenAllowed(UploadedFile $file): ?string
    {
        if (! app()->environment(['local', 'testing'])) {
            return null;
        }

        return $this->storeLocally($file);
    }
}
