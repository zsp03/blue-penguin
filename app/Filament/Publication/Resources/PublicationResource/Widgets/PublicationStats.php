<?php

namespace App\Filament\Publication\Resources\PublicationResource\Widgets;

use App\Models\Publication;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class PublicationStats extends BaseWidget
{
    public function getPublicationsData(string $type)
    {
        $panelId = Filament::getCurrentPanel()->getId();
        if ($panelId == 'publication') {
            return Publication::where('type', $type)
                ->whereHas('lecturers', function (Builder $query) {
                    return $query->where('nip', auth()->user()->lecturer?->nip);
                })->count();
        }
        return Publication::where('type', $type)->count();
    }

    protected function getStats(): array
    {
        return [
            Stat::make((__('Journal')), $this->getPublicationsData('jurnal')),
            Stat::make((__('Proceeding')), $this->getPublicationsData('prosiding')),
            Stat::make((__('Service')), $this->getPublicationsData('pengabdian')),
            Stat::make((__('Research')), $this->getPublicationsData('penelitian'))
        ];
    }
}
