<?php

namespace App\Filament\Admin\Resources\LecturerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinalProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'finalProjects';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::Small),
                Tables\Columns\TextColumn::make('role')
                    ->translateLabel()
                    ->badge()
                    ->colors([
                        'info' => 'supervisor 1',
                        'success' => 'supervisor 2',
                        'violet' => 'evaluator'
                    ])
                    ->formatStateUsing(fn (string $state): string => (__(ucfirst($state))))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                ]),
            ]);
    }
}
