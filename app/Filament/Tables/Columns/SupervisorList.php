<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Support\Facades\Storage;

class SupervisorList extends Column
{
    protected string $view = 'filament.tables.columns.supervisor-list';

    public function getDisk()
    {

    }
    public function getImageUrl($path)
    {
        return Storage::disk('local')->url($path);
    }
}
