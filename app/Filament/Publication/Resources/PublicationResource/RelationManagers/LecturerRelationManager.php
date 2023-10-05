<?php

namespace App\Filament\Publication\Resources\PublicationResource\RelationManagers;

use App\Models\Lecturer;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LecturerRelationManager extends RelationManager
{
    protected static string $relationship = 'lecturers';
    protected static ?string $title = 'Authors';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->icon(fn (Lecturer $record) => $record->image_url ?: asset('assets/images/default_avatar.jpg')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
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
                Tables\Actions\AttachAction::make(),
            ]);
    }
}
