<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Filament\Resources\PublicationResource\Widgets\PublicationStats;
use App\Filament\Tables\Columns\AuthorsList;
use App\Models\Publication;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(255),
//                    Forms\Components\Select::make('authors')
//                    ->required()
//                    ->multiple()
//                    ->getSearchResultsUsing(fn (string $search): array => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
//                    ->getOptionLabelsUsing(fn (array $values): array => User::whereIn('id', $values)->pluck('name', 'id')->toArray()),
                        Forms\Components\TextInput::make('link')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('year')
                            ->native(false)
                            ->displayFormat('Y'),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->options([
                                'jurnal' => 'Jurnal',
                                'prosiding' => 'Prosiding',
                                'penelitian' => 'Penelitian',
                                'pengabdian' => 'Pengabdian',
                            ]),
                        Forms\Components\TextInput::make('citation')
                            ->numeric()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('total_funds')
                            ->prefix('Rp.')
                            ->numeric()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('fund_source')
                            ->maxLength(255),

                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?Publication $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Publication $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Publication $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Publication $record) => $record === null),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
//                Tables\Columns\ImageColumn::make('lecturers.image')
//                    ->label('Authors')
//                    ->circular()
//                    ->stacked(),
                AuthorsList::make('lecturers')
                    ->label('Authors'),
                Tables\Columns\TextColumn::make('link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->date('Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn (string $state): string => __(ucfirst($state)))
                    ->badge()
                    ->colors([
                        'success' => 'jurnal',
                        'gray' => 'prosiding',
                        'violet' => 'pengabdian',
                        'info' => 'penelitian',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('citation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_funds')
                    ->prefix('Rp. ')
                    ->numeric(0,'.',',')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fund_source')
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
            RelationManagers\LecturerRelationManager::class,
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PublicationStats::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
