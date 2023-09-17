<?php

namespace App\Filament\Tables\Columns;

use App\Models\User;
use Filament\Tables\Columns\Column;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class AuthorsList extends Column
{
    protected string $view = 'filament.tables.columns.authors-list';
    public function getDisk(): Filesystem
    {
        return Storage::disk(config('filament.default_filesystem_disk'));
    }
    public function getImageUrl($path): string
    {
        return $this->getDisk()->url($path);
    }
    public function getDefaultAvatar(): string
    {
        return asset('assets/images/default_avatar.jpg');
    }
}
