<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class FinalProjectStudentApexChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'finalProjectStudentApexChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'FinalProjectStudentApexChart';

    public int $height = 3240;
    protected function getContentHeight(): ?int
    {
        return $this->height;
    }

    public function placeholder(): View
    {
        return view('components.loading-section', [
            'columnSpan' => $this->getColumnSpan(),
            'columnStart' => $this->getColumnStart(),
        ]);
    }
    protected int | string | array $columnSpan = 'full';

    public function getStudentFinalProject() {
        $projects = FinalProject::where('status', 'Ongoing')
            ->with('student:id,name')
            ->orderBy('submitted_at')
            ->get();
        return $projects->map(function ($result) {
            $diffDays = now()->diffInDays(Carbon::createFromFormat('Y-m-d',$result->submitted_at));

            if ($diffDays >= 540) {
                $color = '#ff0000';
            } elseif ($diffDays >= 180) {
                $color = '#facc15';
            } else {
                $color = '#00ff2f';
            }

            return [
                'days' => $diffDays,
                'name' => $result->student->name,
                'color' => $color,
            ];
        });
    }


    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $data = $this->getStudentFinalProject()->pluck('days')->toArray();
        $labels = $this->getStudentFinalProject()->pluck('name')->toArray();
        $colors = $this->getStudentFinalProject()->pluck('color')->toArray();

        $this->height = 33.65 * count($data) + 312;

        return [
            'grid' => [
                'show' => false
            ],
            'colors' => $colors,
            'chart' => [
                'type' => 'bar',
                'height' => $this->getContentHeight(),
            ],
            'series' => [
                [
                    'name' => __('Days after Proposal'),
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'legend' => [
                'customLegendItems' => [
                    __('Less than 180 Days'),
                    __('Between 180 and 540 days'),
                    __('More than 540 days')
                ],
                'markers' => [
                    'fillColors' => [
                        '#00ff2f',
                        '#facc15',
                        '#ff0000',
                    ]
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'distributed' => true,
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }
}
