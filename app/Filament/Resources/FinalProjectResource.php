<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinalProjectResource\Pages;
use App\Filament\Resources\FinalProjectResource\RelationManagers;
use App\Models\FinalProject;
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
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('submitted_at')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('supervisor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('evaluator')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supervisor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('evaluator')
                    ->searchable(),
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
            //
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
