<?php

namespace Tests\Feature;

use Tests\TestCase;

class CloudinaryUrlTest extends TestCase
{
    public function test_cloudinary_url_without_options_does_not_emit_array_transformation(): void
    {
        config(['cloudinary.url' => 'cloudinary://123456789012345:secret@demo']);

        $url = cloudinaryUrl('nutricycle/produk/test');

        $this->assertStringContainsString(
            'https://res.cloudinary.com/demo/image/upload/v1/nutricycle/produk/test',
            $url,
        );
        $this->assertStringNotContainsString('/Array/', $url);
    }

    public function test_cloudinary_url_uses_placeholder_when_image_is_missing(): void
    {
        $this->assertStringEndsWith('/images/product-placeholder.svg', cloudinaryUrl(null));
    }
}
