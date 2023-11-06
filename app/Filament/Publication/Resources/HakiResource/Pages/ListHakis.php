<?php

namespace App\Filament\Publication\Resources\HakiResource\Pages;

use App\Filament\Publication\Resources\HakiResource;
use App\Models\Faculty;
use App\Models\Haki;
use App\Models\Lecturer;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListHakis extends ListRecords
{
    protected static string $resource = HakiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('name'),
                    ImportField::make('inventors'),
                    ImportField::make('faculties'),
                    ImportField::make('type'),
                    ImportField::make('status'),
                    ImportField::make('registration_no'),
                    ImportField::make('haki_no'),
                    ImportField::make('registered_at'),
                    ImportField::make('scale'),
                    ImportField::make('year'),
                    ImportField::make('link'),
                    ImportField::make('output'),
                    ImportField::make('haki_type'),
                ])
                ->handleRecordCreation(function ($data) {
                    $keysToAdd = [
                        'name',
                        'type',
                        'status',
                        'registration_no',
                        'haki_no',
                        'registered_at',
                        'scale',
                        'year',
                        'link',
                        'output',
                        'haki_type'
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

                    $inventorsId = function () use ($data) {
                        $explodedLecturersData = explode(', ', $data['inventors']);
                        $lecturersData = array();

                        foreach ($explodedLecturersData as $lecturerData) {
                            $nip = null;
                            $name = null;

                            if (is_numeric($lecturerData)) {
                                $nip = $lecturerData;
                            } else $name = $lecturerData;

                            if (isset($nip)) {
                                $lecturersData[] = $nip;
                            } else {
                                $lecturer = Lecturer::firstOrCreate(
                                    [
                                        'name' => $name
                                    ],
                                    [
                                        'nip' => 'DL' . crc32(uniqid())
                                    ]
                                );
                            }

                            if (isset($lecturer)) {
                                $lecturersData[] = $lecturer->nip;
                            }
                        }

                        return Lecturer::whereIn('nip', $lecturersData)->get();
                    };


                    $facultiesId = function () use ($data) {
                        $explodedFacultiesData = explode(', ', $data['faculties']);
                        $faculties = Faculty::whereIn('name', $explodedFacultiesData)->get();
                        return $faculties->pluck('id')->toArray();
                    };

                    $newHaki = function () use ($newData, $inventorsId, $facultiesId) {
                        $haki = Haki::create($newData);
                        $haki->lecturers()->attach($inventorsId());
                        $haki->faculties()->attach($facultiesId());

                        return $haki;
                    };

                    return $newHaki();
                })
                ->hidden(auth()->user()->role !== '0'),
        ];
    }
}
