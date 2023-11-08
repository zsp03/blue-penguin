<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use Filament\Forms\Components\Select;
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
    protected static ?string $heading = 'Final Project Graph';
    protected function getHeading(): ?string
    {
        return __('Final Project Graph');
    }

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

    protected function getFilters(): ?array
    {
        return [
            'all' => __('All'),
            'okay' => __("Less than 180 days"),
            'warning' => __("Between 180 to 540 days"),
            'danger' => __("More than 540 days"),
        ];
    }

    protected function getOptions(): array
    {
        if ($this->filter == 'danger') {
            $finalProjects = $this->getStudentFinalProject()->filter(function ($item) {
                return $item['days'] > 540;
            });
        } elseif ($this->filter == 'warning') {
            $finalProjects = $this->getStudentFinalProject()->filter(function ($item) {
                return $item['days'] > 180 && $item['days'] <= 540;
            });
        } elseif ($this->filter == 'okay') {
            $finalProjects = $this->getStudentFinalProject()->filter(function ($item) {
                return $item['days'] <= 180;
            });
        } else $finalProjects = $this->getStudentFinalProject();

        $data = $finalProjects->pluck('days')->toArray();
        $labels = $finalProjects->pluck('name')->toArray();
        $colors = $finalProjects->pluck('color')->toArray();

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
                    __('Less than 180 days'),
                    __('Between 180 to 540 days'),
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
