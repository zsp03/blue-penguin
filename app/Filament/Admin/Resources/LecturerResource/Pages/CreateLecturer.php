<?php

namespace App\Filament\Admin\Resources\LecturerResource\Pages;

use App\Filament\Admin\Resources\LecturerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateLecturer extends CreateRecord
{
    protected static string $resource = LecturerResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['image'] !== null){
            $data['image_url'] = Storage::disk()->url($data['image']);
        }

        return $data;
    }
}
