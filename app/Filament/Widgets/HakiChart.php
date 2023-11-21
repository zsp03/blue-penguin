<?php

namespace App\Filament\Widgets;

use App\Models\Haki;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class HakiChart extends ChartWidget
{
    public function getHeading(): string|Htmlable|null
    {
        return __('Intellectual Properties');
    }

    public function getHakiData()
    {
        return Haki::groupBy('haki_type')
            ->select(DB::raw('COALESCE(haki_type, "Uncategorized") as haki_type'), DB::raw('count(*) as count'))
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count');
    }
    protected static ?array $options = [
        'indexAxis' => 'y',
        'plugins' => [
            'legend' => [
                'display' => false
            ]
        ]
    ];
    public function getHakiLabel()
    {
        return Haki::groupBy('haki_type')
            ->select(DB::raw('COALESCE(haki_type, "Uncategorized") as haki_type'), DB::raw('count(*) as count'))
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('haki_type');
    }
    protected function getData(): array
    {
//        dd($this->getHakiLabel());
        return [
            'datasets' => [
                [
                    'label' => __('Intellectual Properties'),
                    'data' => $this->getHakiData(),
                    'animation' => [
                        'duration' => 1000,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ]
            ],
            'labels' => $this->getHakiLabel()
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
