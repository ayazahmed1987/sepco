<?php

namespace App\Services;

use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CustomPathGenerator extends DefaultPathGenerator
{
    public function getPath(Media $media): string
    {
        $modelType = strtolower(class_basename($media->model_type)); // e.g. admin
        $collection = $media->collection_name; // e.g. avatar

        return "media/{$modelType}/{$collection}/"; // ✅ custom subfolder path
    }

    public function getPathForConversions(Media $media): string
    {
        $modelType = strtolower(class_basename($media->model_type));
        $collection = $media->collection_name;

        return "media/{$modelType}/{$collection}/conversions/";
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        $modelType = strtolower(class_basename($media->model_type));
        $collection = $media->collection_name;

        return "media/{$modelType}/{$collection}/responsive/";
    }
}
