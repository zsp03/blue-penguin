<?php

namespace App\Filament\Admin\Resources\LecturerResource\Pages;

use App\Filament\Admin\Resources\LecturerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditLecturer extends EditRecord
{
    protected static string $resource = LecturerResource::class;
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
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['image'] !== null){
            $data['image_url'] = Storage::disk()->url($data['image']);
        }

        return $data;
    }
}
