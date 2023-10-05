<?php

namespace App\Filament\FinalProject\Resources\FinalProjectResource\Pages;

use App\Filament\FinalProject\Resources\FinalProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinalProject extends EditRecord
{
    protected static string $resource = FinalProjectResource::class;
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
