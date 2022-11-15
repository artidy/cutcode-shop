<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ThumbnailController extends Controller
{
    public function __invoke(string $dir, string $method, string $size, string $file)
    {
        abort_if(
            !in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'Размер не соответствует'
        );

        $storage = Storage::disk('images');
        $realPath = "$dir/$file";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if (!$storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));
            [$width, $height] = explode('x', $size);

            $image->{$method}($width, $height);
            $image->save($storage->path($resultPath));
        }

        return response()->file($storage->path($resultPath));
    }
}
