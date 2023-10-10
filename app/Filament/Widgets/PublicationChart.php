<?php

namespace App\Filament\Widgets;

use App\Models\Publication;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class PublicationChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Publikasi';
    public function getHeading(): string|Htmlable|null
    {
        return (__('Amount of Publications'));
    }
    public function getDescription(): string|Htmlable|null
    {
        return (__('Total publications that have been registered for each type'));
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
                        Publication::where('type', '=', 'Jurnal')->count(),
                        Publication::where('type', '=', 'Prosiding')->count(),
                        Publication::where('type', '=', 'Penelitian')->count(),
                        Publication::where('type', '=', 'Pengabdian')->count()
                  ],
                    'borderRadius' => 10,
                    'animation' => [
                        'duration' => 1000,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
            ],
            'labels' => ['Jurnal', 'Prosiding', 'Penelitian', 'Pengabdian']
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
