<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class FinalProjectChartTwo extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int | string | array $columnSpan = 1;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => $this->getColumnSpan(),
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
