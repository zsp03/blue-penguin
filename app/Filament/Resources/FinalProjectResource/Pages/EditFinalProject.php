<?php

namespace App\Filament\Resources\FinalProjectResource\Pages;

use App\Filament\Resources\FinalProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinalProject extends EditRecord
{
    protected static string $resource = FinalProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
