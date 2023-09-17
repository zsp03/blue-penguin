<?php

namespace App\Filament\Resources\FinalProjectResource\RelationManagers;

use App\Models\Lecturer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LecturersRelationManager extends RelationManager
{
    protected static string $relationship = 'lecturers';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon(fn (Lecturer $record) => $record->image_url ?: asset('assets/images/default_avatar.jpg')),
                Tables\Columns\TextColumn::make('role')
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
                            'supervisor' => 'Supervisor',
                            'evaluator' => 'Evaluator'
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
                            'supervisor' => 'Supervisor',
                            'evaluator' => 'Evaluator'
                        ])
                        ->required(),
                ])
            ]);
    }
}
