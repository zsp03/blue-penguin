<?php

namespace App\Filament\Widgets;

use App\Models\Publication;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PublicationLineChart extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return (__('Publication by Year'));
    }

    public function getDescription(): string|Htmlable|null
    {
        return (__('Shows all registered Publications by type each year'));
    }


    protected static ?array $options = [
        'elements' => [
            'line' => [
                'borderWidth' => 3
            ]
        ]
    ];

    public function getPublicationData(string $type): Collection {
        $yearData = collect(range(Publication::min('year'), Publication::max('year')));
        if (\filament()->getCurrentPanel()->getId() == 'publication'){
            $data = Publication::selectRaw("year as year, count(*) as count")
                ->where('type', $type)
                ->whereHas('lecturers', function (Builder $query){
                    return $query->where('nip', auth()->user()->lecturer?->nip);
                })
                ->groupBy('year')
                ->get()
                ->pluck('count', 'year');
        } else {
            $data = Publication::selectRaw("year as year, count(*) as count")
                ->where('type', $type)
                ->groupBy('year')
                ->get()
                ->pluck('count', 'year');
        }



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
                    'label' => (__('Journal')),
                    'data' => $this->getPublicationData('jurnal'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'borderColor' => '#10B981A5',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => (__('Proceeding')),
                    'data' => $this->getPublicationData('prosiding'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#7D7C7C',
                    'borderColor' => '#7D7C7CAA',
                    'animation' => [
                        'duration' => 400,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => (__('Research')),
                    'data' => $this->getPublicationData('penelitian'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#6499E9',
                    'borderColor' => '#6499E9AA',
                    'animation' => [
                        'duration' => 500,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => (__('Service')),
                    'data' => $this->getPublicationData('pengabdian'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#9400FF',
                    'borderColor' => '#9400FFAA',
                    'animation' => [
                        'duration' => 600,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
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
