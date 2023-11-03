<?php

namespace App\Filament\Publication\Resources\HakiResource\Pages;

use App\Filament\Publication\Resources\HakiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHaki extends EditRecord
{
    protected static string $resource = HakiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
