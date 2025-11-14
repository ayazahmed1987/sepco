<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;

class MediaPreview extends Component
{
    public $file;
    public $id;
    public $removeRoute;
    public $columnName;
    public function __construct($file, $id = null, $removeRoute = null, $columnName = null)
    {
        $this->file = $file;
        $this->id = $id;
        $this->removeRoute = $removeRoute;
        $this->columnName = $columnName;
    }

    public function mediaType()
    {
        $extension = strtolower(pathinfo($this->file, PATHINFO_EXTENSION));

        return match (true) {
            in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) => 'image',
            in_array($extension, ['mp4', 'webm', 'ogg']) => 'video',
            in_array($extension, ['pdf']) => 'pdf',
            in_array($extension, ['doc', 'docx']) => 'word',
            in_array($extension, ['xls', 'xlsx']) => 'excel',
            default => 'file',
        };
    }

    public function mediaPath()
    {
        return asset(Storage::url($this->file));
    }

    public function render()
    {
        return view('components.media-preview');
    }
}
