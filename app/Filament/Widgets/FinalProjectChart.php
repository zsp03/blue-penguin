<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class FinalProjectChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Proposal';
    protected static ?string $description = 'Mahasiswa yang proposal tiap bulan dalam satu tahun';
    protected int | string | array $columnSpan = 1;
    public function placeholder(): View
    {
        return view('components.loading-section', [
            'columnSpan' => $this->getColumnSpan(),
            'columnStart' => $this->getColumnStart(),
        ]);
    }

    protected static ?array $options = [
        'animation' => [
            'duration' => 1000,
            'easing' => 'easeOutCubic'
        ],
        'elements' => [
            'line' => [
                'tension' => 0.25
            ]
        ]
    ];
    protected function getData(): array
    {
        $this->filter = (string) now()->year;
        $data = Trend::model(FinalProject::class)
            ->dateColumn('submitted_at')
            ->between(
                start: Carbon::create($this->filter)->startOfYear(),
                end: Carbon::create($this->filter)->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Final Projects',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                    'animation' => [
                        'duration' => 600,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getFilters(): ?array
    {
        $distinctYear = FinalProject::selectRaw('YEAR(submitted_at) as year')
            ->distinct()
            ->get()
            ->pluck('year')
            ->mapWithKeys(function ($year) {
                return [$year => (string)$year];
            })
            ->toArray();
        return array_reverse($distinctYear, true);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
