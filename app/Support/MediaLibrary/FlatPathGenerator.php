<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class FlatPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $media->collection_name.'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $media->collection_name.'/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $media->collection_name.'/responsive/';
    }
}
