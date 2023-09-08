<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinalProjectResource\Pages;
use App\Filament\Resources\FinalProjectResource\RelationManagers;
use App\Filament\Tables\Columns\SupervisorList;
use App\Models\FinalProject;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinalProjectResource extends Resource
{
    protected static ?string $model = FinalProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->native(false)
                    ->options(Student::all()->pluck('name', 'id')),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('submitted_at')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_id.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('supervisor')
                    ->state(function (FinalProject $record) {
                        $list = [];
                        foreach ($record->lecturers as $lecturer)
                        {
                            if ($lecturer->pivot->role == 'supervisor') {
                                $list[] = $lecturer->image;
                            }
                        }
                        return $list;
                    })
                    ->circular()
                    ->stacked(),
                Tables\Columns\ImageColumn::make('evaluator')
                    ->state(function (FinalProject $record) {
                        $list = [];
                        foreach ($record->lecturers as $lecturer)
                        {
                            if ($lecturer->pivot->role == 'evaluator') {
                                $list[] = $lecturer->image;
                            }
                        }
                        return $list;
                    })
                    ->circular()
                    ->stacked(),
                SupervisorList::make('test')
                    ->state(function (FinalProject $record) {
                        $list = [];
                        foreach ($record->lecturers as $lecturer)
                        {
                            if ($lecturer->pivot->role == 'supervisor') {
                                $list[] = $lecturer->image;
                            }
                        }
                        return $list;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LecturersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinalProjects::route('/'),
            'create' => Pages\CreateFinalProject::route('/create'),
            'edit' => Pages\EditFinalProject::route('/{record}/edit'),
        ];
    }
}
