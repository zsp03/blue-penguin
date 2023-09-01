<?php

namespace App\Filament\Tables\Columns;

use App\Models\User;
use Filament\Tables\Columns\Column;

class AuthorsList extends Column
{
    protected string $view = 'filament.tables.columns.authors-list';
}
