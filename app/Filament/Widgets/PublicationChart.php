<?php

namespace App\Filament\Widgets;

use App\Models\Publication;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class PublicationChart extends ChartWidget
{

    public function getHeading(): string|Htmlable|null
    {
        return (__('Amount of Publications'));
    }
    public function getDescription(): string|Htmlable|null
    {
        return (__('Total publications that have been registered for each type'));
    }

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

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false
            ]
        ]
    ];

    public function placeholder(): View
    {
        return view('components.loading-section', [
            'columnSpan' => $this->getColumnSpan(),
            'columnStart' => $this->getColumnStart(),
        ]);
    }
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Publication',
                    'data' => [
                        $this->getPublicationsData('jurnal'),
                        $this->getPublicationsData('prosiding'),
                        $this->getPublicationsData('penelitian'),
                        $this->getPublicationsData('pengabdian')
                  ],
                    'borderRadius' => 10,
                    'animation' => [
                        'duration' => 1000,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
            ],
            'labels' => [(__('Journal')), (__('Proceeding')), (__('Research')), (__('Service'))]
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
