<?php

namespace App\Filament\Admin\Resources\StudentResource\Pages;

use App\Actions\FilamentImport\Action\ImportAction;
use App\Filament\Admin\Resources\StudentResource;
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
