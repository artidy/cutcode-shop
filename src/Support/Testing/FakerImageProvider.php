<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    private const IMAGE_DIRECTORY = 'images';

    public function fixtureImage(string $fixturesDir, string $storageDir): string
    {
        $storagePath = self::IMAGE_DIRECTORY . '/' . $storageDir;

        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            Storage::path($storagePath),
            false
        );

        return 'storage/' . trim($storagePath, '/') . '/' .$file;
    }
}
