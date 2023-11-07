<?php

namespace App\Filament\Widgets;

use App\Models\FinalProject;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class FinalProjectStudentGraph extends ChartWidget
{
    protected static ?string $heading = '';
    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '2000px';

    public function getStudentFinalProject() {
        $projects = FinalProject::where('status', 'Ongoing')
            ->with('student:id,name')
            ->orderBy('submitted_at')
            ->get();
        return $projects->map(function ($result) {
            $diffDays = now()->diffInDays(Carbon::createFromFormat('Y-m-d',$result->submitted_at));

            if ($diffDays >= 540) {
                $color = '#FF0000D8';
            } elseif ($diffDays >= 180) {
                $color = '#facc15d8';
            } else {
                $color = '#00FF2FD8';
            }

            return [
                'days' => $diffDays,
                'name' => $result->student->name,
                'color' => $color,
            ];
        });
    }

    protected function getData(): array
    {
//        dd($this->getStudentFinalProject());
        $data = $this->getStudentFinalProject()->pluck('days');
        $labels = $this->getStudentFinalProject()->pluck('name');
        $colors = $this->getStudentFinalProject()->pluck('color');

        return [
            'datasets' => [
                [
                    'label' => 'Days after proposal',
                    'data' => $data,
                    'borderColor' => $colors,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                indexAxis : 'y',
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(item) {
                                let dataLabel = item.dataset.label + ': ';
                                let value = item.formattedValue;
                                return dataLabel + value + ' days';
                            }
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            callback: (value) => value + ' days',
                        },
                    },
                },
            }
        JS);
    }
}
