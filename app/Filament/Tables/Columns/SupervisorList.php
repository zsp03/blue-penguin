<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class SupervisorList extends Column
{
    protected string $view = 'filament.tables.columns.supervisor-list';

    public function getDisk(): Filesystem
    {
        return Storage::disk(config('filament.default_filesystem_disk'));
    }
    public function getImageUrl($path): string
    {
        return $this->getDisk()->url($path);
    }
}
