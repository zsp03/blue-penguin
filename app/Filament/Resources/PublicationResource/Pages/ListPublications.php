<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublications extends ListRecords
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return PublicationResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All'),
            'jurnal' => ListRecords\Tab::make()
                ->query(fn ($query) => $query->where('type', 'jurnal')),
            'prosiding' => ListRecords\Tab::make()
                ->query(fn ($query) => $query->where('type', 'prosiding')),
            'penelitian' => ListRecords\Tab::make()
                ->query(fn ($query) => $query->where('type', 'penelitian')),
            'pengabdian' => ListRecords\Tab::make()
                ->query(fn ($query) => $query->where('type', 'pengabdian')),
        ];
    }
}
