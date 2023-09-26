<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class FinalProjectChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        $data = Trend::model(FinalProject::class)
            ->dateColumn('submitted_at')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Final Projects',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
