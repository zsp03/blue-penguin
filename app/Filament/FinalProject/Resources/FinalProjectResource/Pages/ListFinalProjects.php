<?php

namespace App\Filament\FinalProject\Resources\FinalProjectResource\Pages;

use App\Actions\FilamentImport\Action\ImportAction;
use App\Filament\FinalProject\Resources\FinalProjectResource;
use App\Models\FinalProject;
use App\Models\Lecturer;
use App\Models\Student;
use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;
use Konnco\FilamentImport\Actions\ImportField;

class ListFinalProjects extends ListRecords
{
    protected static string $resource = FinalProjectResource::class;
    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('nim'),
                    ImportField::make('title'),
                    ImportField::make('supervisorOne'),
                    ImportField::make('supervisorTwo'),
                    ImportField::make('evaluatorOne'),
                    ImportField::make('evaluatorTwo'),
                    ImportField::make('submitted_at'),
                    ImportField::make('status')
                ])
                ->hidden(auth()->user()->role !== '0')
                ->handleRecordCreation(function ($data) {
                    $keysToAdd = [
                        'title',
                        'submitted_at',
                        'status',
                    ];

                    $evaluatorList = [
                        $data['evaluatorOne'],
                        $data['evaluatorTwo'],
                    ];

                    $newData = [];
                    // Loop through the keys to add
                    foreach ($keysToAdd as $key) {
                        // Check if the key exists in the original array
                        if (array_key_exists($key, $data)) {
                            // If it exists, copy it to the new array
                            $newData[$key] = $data[$key];
                        } else {
                            // If it doesn't exist, add it with a default value of null
                            $newData[$key] = null;
                        }
                    }
                    $year = $data['submitted_at'];
                    $newData['submitted_at'] = Carbon::create($year, 1, 1);

                    $evaluatorIds = function () use ($evaluatorList) {
                        $lecturers = Lecturer::whereIn('nip', $evaluatorList)->get();
                        return $lecturers->pluck('id')->toArray();
                    };

                    $supervisorOneId = Lecturer::where('nip', '=', $data['supervisorOne'])->get()->first()->id;
                    $supervisorTwoId = Lecturer::where('nip', '=', $data['supervisorTwo'])->get()->first()->id;

                    $studentId = Student::where('nim', '=', $data['nim'])->get()->first()->id;
                    $newData['student_id'] = $studentId;

                    $newFinalProject = function () use ($newData, $supervisorOneId, $supervisorTwoId, $evaluatorIds) {
                        $finalProject = FinalProject::create($newData);
                        $finalProject->lecturers()->attach($supervisorOneId, ['role' => 'supervisor 1']);
                        $finalProject->lecturers()->attach($supervisorTwoId, ['role' => 'supervisor 2']);
                        $finalProject->lecturers()->attach($evaluatorIds(), ['role' => 'evaluator']);

                        return $finalProject;
                    };
                    return $newFinalProject();
                }),
        ];
    }
}
