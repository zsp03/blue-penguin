<?php

namespace App\Filament\Widgets;

use App\Models\Publication;
use Filament\Widgets\ChartWidget;

class PublicationChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

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
                  'color' => ['danger', 'gray', 'primary', 'info']
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
