<?php

namespace App\Filament\Resources\LecturerResource\Pages;

use App\Filament\Resources\LecturerResource;
use Closure;
use Coolsam\FilamentExcel\Actions\ImportAction;
use Coolsam\FilamentExcel\Actions\ImportField;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLecturers extends ListRecords
{
    protected static string $resource = LecturerResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make('lecturers')->fields([
                ImportField::make('name')->required(),
                ImportField::make('nip')->required(),
            ]),
        ];
    }
}
