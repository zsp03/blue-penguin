<?php

namespace App\Filament\FinalProject\Resources\FinalProjectResource\Widgets;

use App\Models\FinalProject;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class FinalProjectStudentChart extends ChartWidget
{
    protected static ?string $heading = 'Your Students Status';
    protected static ?string $description = 'Your students that has not yet complete their Final Project';

    protected int | string | array $columnSpan = 'full';

    public function getStudentFinalProject() {
        $projects = FinalProject::where('status', 'Ongoing')
            ->whereHas('lecturers', function (Builder $query) {
                return $query
                    ->where('nip', auth()->user()->lecturer?->nip)
                    ->whereIn('role', ['supervisor 1', 'supervisor 2']);
                })
            ->with('lecturers')
            ->with('student:id,name')
            ->orderBy('submitted_at')
            ->get();
        return $projects->map(function ($result) {
            $lecturerRole = $result->lecturers->first(function ($lecturer) {
                return $lecturer->nip === auth()->user()->lecturer?->nip;
            })?->pivot->role;

            $diffDays = now()->diffInDays(Carbon::createFromFormat('Y-m-d',$result->submitted_at));

            $colorLookup = [
                'supervisor 1' => ['#FF0000D8', '#facc15d8', '#00FF2FD8'],
                'supervisor 2' => ['#FF0000C2', '#facc15c2', '#00FF2FC2'],
            ];

            if ($diffDays >= 540) {
                $color = $colorLookup[$lecturerRole][0];
            } elseif ($diffDays >= 180) {
                $color = $colorLookup[$lecturerRole][1];
            } else {
                $color = $colorLookup[$lecturerRole][2];
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
