<?php

namespace App\Filament\Admin\Resources\LecturerResource\Pages;

use App\Filament\Admin\Resources\LecturerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;

class CreateLecturer extends CreateRecord
{
    protected static string $resource = LecturerResource::class;
    public function getTitle(): string|Htmlable
    {
        return (__('Make Lecturer'));
    }

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
