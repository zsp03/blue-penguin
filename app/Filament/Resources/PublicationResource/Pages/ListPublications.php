<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use App\Models\Lecturer;
use App\Models\Publication;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListPublications extends ListRecords
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->fields([
                ImportField::make('title'),
                ImportField::make('authors'),
                ImportField::make('students'),
                ImportField::make('year'),
                ImportField::make('type'),
                ImportField::make('scale'),
                ImportField::make('total_funds'),
                ImportField::make('fund_source'),
                ImportField::make('citation'),
                ImportField::make('link'),
            ])
                ->handleRecordCreation(function ($data) {
                    $keysToAdd = [
                        'title',
                        'year',
                        'type',
                        'scale',
                        'total_funds',
                        'fund_source',
                        'citation',
                        'link',
                    ];

                    $lecturerIds = function () use ($data) {
                        $explodedLecturersData = explode(', ', $data['authors']);
                        $lecturers = Lecturer::whereIn('nip', $explodedLecturersData)->get();
                        return $lecturers->pluck('id')->toArray();
                    };

                    $studentIds = function () use ($data) {
                        $explodedStudentsData = explode(', ', $data['students']);
                        $students = Student::whereIn('nim', $explodedStudentsData)->get();
                        return $students->pluck('id')->toArray();
                    };

                    $lecturersId = $lecturerIds();
                    $studentsId = $studentIds();

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

                    $newPublication = function () use ($newData, $lecturersId, $studentsId) {
                        $publication = Publication::create($newData);
                        $publication->lecturers()->attach($lecturersId);
                        $publication->students()->attach($studentsId);

                        return $publication;
                    };
                    return $newPublication();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return PublicationResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            // null => Tab::make('All'),
            // 'jurnal' => Tab::make()
            //     ->query(fn ($query) => $query->where('type', 'jurnal')),
            // 'prosiding' => Tab::make()
            //     ->query(fn ($query) => $query->where('type', 'prosiding')),
            // 'penelitian' => Tab::make()
            //     ->query(fn ($query) => $query->where('type', 'penelitian')),
            // 'pengabdian' => Tab::make()
            //     ->query(fn ($query) => $query->where('type', 'pengabdian')),
        ];
    }
}
