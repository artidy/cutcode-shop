<?php

namespace App\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function getThumbnailDir(): string;

    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->getThumbnailDir(),
            'method' => $method,
            'file' => File::basename($this->{$this->thumbnailColumn()}),
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
