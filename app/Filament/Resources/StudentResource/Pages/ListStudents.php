<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Coolsam\FilamentExcel\Actions\ImportAction;
use Coolsam\FilamentExcel\Actions\ImportField;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make('students')->fields([
                ImportField::make('name')->required(),
                ImportField::make('nim')->required(),
            ]),
        ];
    }
}
