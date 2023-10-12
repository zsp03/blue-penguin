<?php

namespace App\Filament\FinalProject\Resources\FinalProjectResource\Widgets;

use App\Models\FinalProject;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class FinalProjectStudentChart extends ChartWidget
{
    protected static ?string $heading = 'Your Students Status';
    protected static ?string $description = 'Your students that has not yet complete their Final Project';

    protected static ?array $options = [
        'indexAxis' => 'y',
    ];

    protected int | string | array $columnSpan = 'full';

    public function getStudentFinalProject() {
        $projects = FinalProject::where('status', 'Ongoing')
            ->whereHas('lecturers', function (Builder $query) {
                return $query
                    ->where('nip', auth()->user()->lecturer?->nip)
                    ->whereIn('role', ['supervisor 1', 'supervisor 2']);
                })
            ->with('student:id,nim')
            ->select('submitted_at', 'student_id')
            ->get();

        return $projects->map(function ($result) {
            $diffDays = now()->diffInDays(Carbon::createFromFormat('Y-m-d',$result->submitted_at));

            if ($diffDays >= 180) {
                $color = '#FF0000D8';
            } elseif ($diffDays >= 90) {
                $color = '#facc15d8';
            } else $color = '#00FF2FD8';

            return [
                'days' => $diffDays,
                'nim' => $result->student->nim,
                'color' => $color
            ];
        });
    }

    protected function getData(): array
    {
        $data = $this->getStudentFinalProject()->pluck('days');
        $labels = $this->getStudentFinalProject()->pluck('nim');
        $colors = $this->getStudentFinalProject()->pluck('color');
        return [
            'datasets' => [
                [
                    'label' => 'Your Student Status',
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
}
