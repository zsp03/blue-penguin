<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Actions\FilamentImport\Action\ImportAction;
use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportField;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make('students')
                ->uniqueField('nim')
                ->fields([
                    ImportField::make('name')->required(),
                    ImportField::make('nim')->required(),
                    ImportField::make('email'),
                ])
        ];
    }
}
