<?php

namespace App\Filament\Widgets;

use App\Models\Publication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class PublicationLineChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?array $options = [
        'elements' => [
            'line' => [
                'borderWidth' => 4
            ]
        ]
    ];

    public function getPublicationData(string $type): Collection {
        $yearData = collect(range(Publication::min('year'), Publication::max('year')));
        $data = Publication::selectRaw("year as year, count(*) as count")
            ->where('type', $type)
            ->groupBy('year')
            ->get()
            ->pluck('count', 'year');

        return $yearData
            ->mapWithKeys(function ($year) use ($data) {
                return [$year => $data->get($year, 0)];
            });
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jurnal',
                    'data' => $this->getPublicationData('jurnal'),
                ],
                [
                    'label' => 'Prosiding',
                    'data' => $this->getPublicationData('prosiding'),
                    'borderColor' => '#7D7C7C'
                ],
                [
                    'label' => 'Penelitian',
                    'data' => $this->getPublicationData('penelitian'),
                    'borderColor' => '#6499E9',
                ],
                [
                    'label' => 'Pengabdian',
                    'data' => $this->getPublicationData('pengabdian'),
                    'borderColor' => '#9400FF'
                ],
            ],
            'labels' => ['2018', '2019', '2020', '2021', '2022', '2023']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
