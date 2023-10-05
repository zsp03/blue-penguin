<?php

namespace App\Filament\FinalProject\Resources\FinalProjectResource\RelationManagers;

use App\Models\Lecturer;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class LecturersRelationManager extends RelationManager
{
    protected static string $relationship = 'lecturers';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('role', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon(fn (Lecturer $record) => $record->image_url ?: asset('assets/images/default_avatar.jpg')),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'info' => 'supervisor 1',
                        'success' => 'supervisor 2',
                        'violet' => 'evaluator'
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Forms\Components\Select::make('role')
                        ->native(false)
                        ->options([
                            'supervisor 1' => 'Supervisor 1',
                            'supervisor 2' => 'Supervisor 2',
                            'evaluator' => 'Evaluator',
                        ])
                        ->required(),
                ])
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                AttachAction::make()->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    Forms\Components\Select::make('role')
                        ->native(false)
                        ->options([
                            'supervisor 1' => 'Supervisor 1',
                            'supervisor 2' => 'Supervisor 2',
                            'evaluator' => 'Evaluator'
                        ])
                        ->required(),
                ])
            ]);
    }
}
